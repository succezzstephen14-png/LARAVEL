<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\CmsPage;
use App\Models\SiteSetting;
use App\Models\CmsCard;
use App\Models\CmsHeader;
use App\Models\CmsFooter;

class HomeController extends Controller
{
    public function index()
    {
        $siteSettings = SiteSetting::first();
        return view('welcome', [
            'siteSettings' => $siteSettings,
            'settings' => $siteSettings,
        ]);
    }
    
    public function showPage($pageSlug = null)
    {
        // Handle both CmsPage model (from index()) and slug string (from dynamic route)
        if ($pageSlug instanceof CmsPage) {
            $page = $pageSlug;
        } else {
            // Fetch page by slug from dynamic route
            $page = CmsPage::where('slug', $pageSlug)->first();
            
            if (!$page) {
                abort(404, 'Page not found');
            }
        }
        
        // Check if page is published
        if (!$page->is_published) {
            abort(404, 'Page not found');
        }
        
        $siteSettings = SiteSetting::first();
        return view('pages.show', [
            'page' => $page,
            'siteSettings' => $siteSettings,
            'settings' => $siteSettings,
        ]);
    }

    public function contact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Send email to the configured MAIL_FROM_ADDRESS
        Mail::raw(
            "New Contact Form Submission\n\n" .
            "Name: {$validated['name']}\n" .
            "Email: {$validated['email']}\n" .
            "Message:\n{$validated['message']}\n\n" .
            "Sent from: " . config('app.url'),
            function ($message) use ($validated) {
                $message->to(config('mail.from.address'))
                        ->subject('New Contact Form Message from ' . $validated['name'])
                        ->from($validated['email'], $validated['name']);
            }
        );

        return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }

    public function privacyPolicy()
    {
        return view('privacy-policy');
    }

    public function termsAndConditions()
    {
        return view('terms-and-conditions');
    }
}
