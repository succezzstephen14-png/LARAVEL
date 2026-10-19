<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    /**
     * Display a listing of vehicles.
     */
    public function index()
    {
        $vehicles = Vehicle::with('user')
            ->where('status', 'available')
            ->where('approval_status', 'approved')
            ->paginate(12);
        return view('vehicles.index', compact('vehicles'));
    }

    /**
     * Show user's approved vehicles.
     */
    public function myVehicles()
    {
        $vehicles = Vehicle::where('user_id', Auth::id())
            ->where('approval_status', 'approved')
            ->paginate(10);

        return view('vehicles.my-vehicles', compact('vehicles'));
    }

    /**
     * Show user's pending vehicles.
     */
    public function myPendingVehicles()
    {
        $vehicles = Vehicle::where('user_id', Auth::id())
            ->where('approval_status', 'pending')
            ->paginate(10);

        return view('vehicles.my-pending-vehicles', compact('vehicles'));
    }

    /**
     * Show the form for creating a new vehicle.
     */
    public function create()
    {
        return view('vehicles.create');
    }

    /**
     * Store a newly created vehicle in database.
     */
    public function store(Request $request)
    {
        \Log::info('Vehicle store request', ['data' => $request->all()]);

        $validated = $request->validate([
            // Basic Information
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'vehicle_type' => 'required|in:car,van,truck,motorcycle',
            'color' => 'nullable|string|max:50',
            
            // License & Registration
            'license_plate' => [
                'required',
                'string',
                'max:20',
                Rule::unique('vehicles', 'license_plate'),
                function ($attribute, $value, $fail) {
                    // Prevent a vehicle license plate matching any driver license number
                    if (Driver::where('license_number', $value)->exists()) {
                        $fail('The vehicle license plate cannot match an existing driver license number.');
                    }
                    // Ghana plate basic pattern: two letters, space, 4 digits, hyphen, 2 digits (e.g., GR 1234-25)
                    if (!preg_match('/^[A-Z]{2}\s\d{4}-\d{2}$/i', $value)) {
                        $fail('The license plate must follow the Ghana plate format, e.g., "GR 1234-25".');
                    }
                },
            ],
            'registration_number' => 'nullable|string|max:100',
            'vin' => 'nullable|string|unique:vehicles|max:17',
            
            // Technical Specifications
            'fuel_type' => 'nullable|in:petrol,diesel,hybrid,electric,gas',
            'transmission' => 'nullable|in:manual,automatic',
            'engine_size' => 'nullable|string|max:20',
            'capacity' => 'nullable|integer|min:1|max:100',
            'number_of_seats' => 'nullable|integer|min:1|max:100',
            'mileage' => 'nullable|integer|min:0',
            
            // Vehicle Condition (Owner-provided)
            'condition' => 'required|in:excellent,very_good,good,fair,needs_maintenance',
            
            // Documentation & Dates (Required)
            'registration_expiry' => 'nullable|date',
            'insurance_expiry' => 'nullable|date',
            'inspection_expiry' => 'nullable|date',
            'registration_document' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'insurance_document' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'roadworthiness_certificate' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            
            // Images & Description
            'image_url' => 'nullable|array',
            'image_url.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        // Forward the original request (including uploaded files) to the payment initiation flow.
        return app(\App\Http\Controllers\PaymentController::class)
            ->initiateVehiclePayment($request);
    }

    /**
     * Display the specified vehicle.
     */
    public function show(Vehicle $vehicle)
    {
        abort_unless($vehicle->approval_status === 'approved', 404);

        return view('vehicles.show', compact('vehicle'));
    }

    public function showImage(Vehicle $vehicle, int $index)
    {
        if ($vehicle->approval_status !== 'approved') {
            abort_unless(
                Auth::check() &&
                ((string) Auth::id() === (string) $vehicle->user_id || Auth::user()->isAdmin()),
                404
            );
        }

        $imagePath = $vehicle->imagePaths()[$index] ?? null;
        abort_unless($imagePath && Storage::disk('public')->exists($imagePath), 404);

        $mimeType = Storage::disk('public')->mimeType($imagePath);
        abort_unless(is_string($mimeType) && str_starts_with($mimeType, 'image/'), 404);

        return response()->file(Storage::disk('public')->path($imagePath), [
            'Content-Disposition' => 'inline',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * Show the form for editing the vehicle.
     */
    public function edit(Vehicle $vehicle)
    {
        if (Auth::id() !== $vehicle->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        return view('vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified vehicle in database.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        if (Auth::id() !== $vehicle->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            // Basic Information
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'vehicle_type' => 'required|in:car,van,truck,motorcycle',
            'color' => 'nullable|string|max:50',
            
            // License & Registration
            'license_plate' => [
                'required',
                'string',
                'max:20',
                Rule::unique('vehicles', 'license_plate')->ignore($vehicle->id),
                function ($attribute, $value, $fail) {
                    if (Driver::where('license_number', $value)->exists()) {
                        $fail('The vehicle license plate cannot match an existing driver license number.');
                    }
                    if (!preg_match('/^[A-Z]{2}\s\d{4}-\d{2}$/i', $value)) {
                        $fail('The license plate must follow the Ghana plate format, e.g., "GR 1234-25".');
                    }
                },
            ],
            'registration_number' => 'nullable|string|max:100',
            'vin' => 'nullable|string|unique:vehicles,vin,' . $vehicle->id,
            
            // Technical Specifications
            'fuel_type' => 'nullable|in:petrol,diesel,hybrid,electric,gas',
            'transmission' => 'nullable|in:manual,automatic',
            'engine_size' => 'nullable|string|max:20',
            'capacity' => 'nullable|integer|min:1|max:100',
            'number_of_seats' => 'nullable|integer|min:1|max:100',
            'mileage' => 'nullable|integer|min:0',
            
            // Documentation & Dates
            'status' => 'required|in:available,unavailable,maintenance,on_duty',
            'registration_expiry' => 'nullable|date',
            'insurance_expiry' => 'nullable|date',
            'inspection_expiry' => 'nullable|date',
            'registration_document' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'insurance_document' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'roadworthiness_certificate' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
            // Images & Description
            'image_url' => 'nullable|array',
            'image_url.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        // Handle file uploads
        $fileFields = ['registration_document', 'insurance_document', 'roadworthiness_certificate'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('documents', 'public');
            }
        }

        // Handle multiple image uploads
        if ($request->hasFile('image_url')) {
            $imagePaths = [];
            foreach ($request->file('image_url') as $file) {
                $imagePaths[] = $file->store('documents', 'public');
            }
            $validated['image_url'] = $imagePaths;
        }

        $vehicle->update($validated);

        return redirect()->route('vehicles.show', $vehicle)
            ->with('success', 'Vehicle updated successfully!');
    }

    /**
     * Remove the specified vehicle from database.
     */
    public function destroy(Vehicle $vehicle)
    {
        if (Auth::id() !== $vehicle->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $vehicle->delete();

        return redirect()->route('vehicles.my-vehicles')
            ->with('success', 'Vehicle deleted successfully!');
    }

    /**
     * Get all available vehicles (API endpoint).
     */
    public function getAvailable()
    {
        $vehicles = Vehicle::where('status', 'available')
            ->where('approval_status', 'approved')
            ->with('user')
            ->get();
        return response()->json($vehicles);
    }

    /**
     * Search vehicles by type.
     */
    public function search(Request $request)
    {
        $query = Vehicle::where('approval_status', 'approved');

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'available');
        }

        if ($request->has('type') && $request->type) {
            $query->where('vehicle_type', $request->type);
        }

        if ($request->has('make') && $request->make) {
            $query->where('make', 'like', '%' . $request->make . '%');
        }

        $vehicles = $query->with('user')->paginate(12);
        return view('vehicles.index', compact('vehicles'));
    }
}
