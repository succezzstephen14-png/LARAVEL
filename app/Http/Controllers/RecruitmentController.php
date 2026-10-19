<?php

namespace App\Http\Controllers;

use App\Models\Recruitment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class RecruitmentController extends Controller
{
    /**
     * Apply approval status filtering when the column exists.
     */
    protected function applyApprovalFilter($query)
    {
        if (Schema::hasColumn('recruitments', 'approval_status')) {
            $query->where('approval_status', 'approved');
        }

        return $query;
    }

    /**
     * Display a listing of recruitment posts.
     */
    public function index()
    {
        $recruitments = $this->applyApprovalFilter(Recruitment::where('status', 'open'))
            ->with('user')
            ->latest('posted_at')
            ->paginate(12);
        return view('recruitments.index', compact('recruitments'));
    }

    /**
     * Show user's recruitment posts.
     */
    public function myPosts()
    {
        $recruitments = Auth::user()->recruitments()->paginate(10);
        return view('recruitments.my-posts', compact('recruitments'));
    }

    /**
     * Show the form for creating a new recruitment post.
     */
    public function create()
    {
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403, 'Only admins can create recruitment postings.');
        }

        return view('recruitments.create');
    }

    /**
     * Store a newly created recruitment post in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'position_type' => 'required|in:driver,cleaner,gateman,vehicle_owner,security_guard,delivery_rider,maintenance_worker,office_assistant,housekeeper,warehouse_loader',
            'location' => 'required|string|max:255',
            'requirements' => 'nullable|string|max:2000',
            'job_brief' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'offer_document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'salary_range_min' => 'nullable|numeric|min:0',
            'salary_range_max' => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('job_brief')) {
            $validated['job_brief'] = $request->file('job_brief')->store('recruitments/documents', 'public');
        }

        if ($request->hasFile('offer_document')) {
            $validated['offer_document'] = $request->file('offer_document')->store('recruitments/documents', 'public');
        }

        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403, 'Only admins can create recruitment postings.');
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'open';
        $validated['posted_at'] = now();

        Recruitment::create($validated);

        return redirect()->route('recruitments.my-posts')
            ->with('success', 'Recruitment post created successfully!');
    }

    /**
     * Display the specified recruitment post.
     */
    public function show(Recruitment $recruitment)
    {
        abort_unless(
            $recruitment->approval_status === 'approved' && $recruitment->status === 'open',
            404
        );

        return view('recruitments.show', compact('recruitment'));
    }

    /**
     * Show the form for editing the recruitment post.
     */
    public function edit(Recruitment $recruitment)
    {
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403, 'Only admins can edit recruitment postings.');
        }

        return view('recruitments.edit', compact('recruitment'));
    }

    /**
     * Update the specified recruitment post in database.
     */
    public function update(Request $request, Recruitment $recruitment)
    {
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403, 'Only admins can update recruitment postings.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'position_type' => 'required|in:driver,cleaner,gateman,vehicle_owner,security_guard,delivery_rider,maintenance_worker,office_assistant,housekeeper,warehouse_loader',
            'location' => 'required|string|max:255',
            'requirements' => 'nullable|string|max:2000',
            'job_brief' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'offer_document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'salary_range_min' => 'nullable|numeric|min:0',
            'salary_range_max' => 'nullable|numeric|min:0',
            'status' => 'required|in:open,closed,filled',
        ]);

        if ($request->hasFile('job_brief')) {
            $validated['job_brief'] = $request->file('job_brief')->store('recruitments/documents', 'public');
        }

        if ($request->hasFile('offer_document')) {
            $validated['offer_document'] = $request->file('offer_document')->store('recruitments/documents', 'public');
        }

        $recruitment->update($validated);

        return redirect()->route('recruitments.show', $recruitment)
            ->with('success', 'Recruitment post updated successfully!');
    }

    /**
     * Remove the specified recruitment post from database.
     */
    public function destroy(Recruitment $recruitment)
    {
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403, 'Only admins can delete recruitment postings.');
        }

        $recruitment->delete();

        return redirect()->route('admin.recruitments')
            ->with('success', 'Recruitment post deleted successfully!');
    }

    /**
     * Show guest request form to submit a recruitment posting request.
     */
    public function requestForm()
    {
        return view('recruitments.request');
    }

    /**
     * Store a guest recruitment request for admin review.
     */
    public function storeRequest(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'position_type' => 'required|in:driver,cleaner,gateman,vehicle_owner,security_guard,delivery_rider,maintenance_worker,office_assistant,housekeeper,warehouse_loader',
            'location' => 'required|string|max:255',
            'requirements' => 'nullable|string|max:2000',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'nullable|string|max:25',
        ]);

        $requestModel = \App\Models\RecruitmentRequest::create([
            'guest_name' => $validated['guest_name'],
            'guest_email' => $validated['guest_email'],
            'guest_phone' => $validated['guest_phone'] ?? null,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'position_type' => $validated['position_type'],
            'location' => $validated['location'],
            'requirements' => $validated['requirements'] ?? null,
            'status' => 'pending',
        ]);

        $this->notifyAdmins(
            'New recruitment request submitted',
            "A new recruitment request has been submitted by {$requestModel->guest_name} ({$requestModel->guest_email}).\n\n" .
            "Title: {$requestModel->title}\n" .
            "Position: {$requestModel->position_type}\n" .
            "Request ID: {$requestModel->id}\n" .
            "Status: Pending review."
        );

        return redirect()->back()->with('success', 'Thank you — your request has been submitted and will be reviewed by an admin.');
    }

    /**
     * Get all open recruitment positions (API endpoint).
     */
    public function getOpen()
    {
        $recruitments = $this->applyApprovalFilter(Recruitment::where('status', 'open'))
            ->with('user')
            ->latest('posted_at')
            ->get();
        return response()->json($recruitments);
    }

    /**
     * Search recruitment posts.
     */
    public function search(Request $request)
    {
        $query = $this->applyApprovalFilter(Recruitment::where('status', 'open'));

        if ($request->has('position_type') && $request->position_type) {
            $query->where('position_type', $request->position_type);
        }

        if ($request->has('location') && $request->location) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->has('keyword') && $request->keyword) {
            $keyword = '%' . $request->keyword . '%';
            $query->where(function ($query) use ($keyword) {
                $query->where('title', 'like', $keyword)
                    ->orWhere('description', 'like', $keyword);
            });
        }

        $recruitments = $query->with('user')
            ->latest('posted_at')
            ->paginate(12);

        return view('recruitments.index', compact('recruitments'));
    }
}
