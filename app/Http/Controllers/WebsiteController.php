<?php

namespace App\Http\Controllers;

use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class WebsiteController extends Controller
{
    /**
     * Display the website settings dashboard.
     */
    public function index(): View
    {
        $groups = WebsiteSetting::getGroups();
        $currentGroup = request('group', 'general');
        $settings = WebsiteSetting::whereIn('group', $groups)->get();

        return view('admin.website.settings', compact('groups', 'currentGroup', 'settings'));
    }

    /**
     * Show appearance settings (logos, colors, fonts, etc).
     */
    public function appearance(): View
    {
        $settings = WebsiteSetting::getByGroup('appearance');
        $logo = WebsiteSetting::get('logo');
        $favicon = WebsiteSetting::get('favicon');
        $primaryColor = WebsiteSetting::get('primary_color', '#007bff');
        $secondaryColor = WebsiteSetting::get('secondary_color', '#6c757d');

        return view('admin.website.appearance', compact('logo', 'favicon', 'primaryColor', 'secondaryColor', 'settings'));
    }

    /**
     * Update appearance settings.
     */
    public function updateAppearance(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'favicon' => 'nullable|image|mimes:png,jpg,jpeg,ico|max:512',
            'primary_color' => 'nullable|regex:/^#[0-9A-F]{6}$/i',
            'secondary_color' => 'nullable|regex:/^#[0-9A-F]{6}$/i',
            'accent_color' => 'nullable|regex:/^#[0-9A-F]{6}$/i',
            'primary_font' => 'nullable|string|max:255',
            'secondary_font' => 'nullable|string|max:255',
        ]);

        // Handle file uploads
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('branding', 'public');
            WebsiteSetting::set('logo', $logoPath, 'file');
        }

        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('branding', 'public');
            WebsiteSetting::set('favicon', $faviconPath, 'file');
        }

        // Update color settings
        if (isset($validated['primary_color'])) {
            WebsiteSetting::set('primary_color', $validated['primary_color'], 'color');
        }
        if (isset($validated['secondary_color'])) {
            WebsiteSetting::set('secondary_color', $validated['secondary_color'], 'color');
        }
        if (isset($validated['accent_color'])) {
            WebsiteSetting::set('accent_color', $validated['accent_color'], 'color');
        }

        // Update font settings
        if (isset($validated['primary_font'])) {
            WebsiteSetting::set('primary_font', $validated['primary_font'], 'string');
        }
        if (isset($validated['secondary_font'])) {
            WebsiteSetting::set('secondary_font', $validated['secondary_font'], 'string');
        }

        return back()->with('success', 'Appearance settings updated successfully.');
    }

    /**
     * Show header and footer customization settings.
     */
    public function headerFooter(): View
    {
        $headerCode = WebsiteSetting::get('header_code');
        $footerCode = WebsiteSetting::get('footer_code');
        $headerTitle = WebsiteSetting::get('header_title');
        $footerText = WebsiteSetting::get('footer_text');

        return view('admin.website.header-footer', compact('headerCode', 'footerCode', 'headerTitle', 'footerText'));
    }

    /**
     * Update header and footer.
     */
    public function updateHeaderFooter(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'header_title' => 'nullable|string|max:255',
            'header_code' => 'nullable|string|max:5000',
            'footer_text' => 'nullable|string|max:1000',
            'footer_code' => 'nullable|string|max:5000',
        ]);

        foreach ($validated as $key => $value) {
            if ($value !== null) {
                WebsiteSetting::set($key, $value, 'string');
            }
        }

        return back()->with('success', 'Header and footer updated successfully.');
    }

    /**
     * Show navigation menu management.
     */
    public function menus(): View
    {
        $menuItems = WebsiteSetting::get('navigation_menu', []);

        if (!is_array($menuItems)) {
            $menuItems = json_decode($menuItems, true) ?? [];
        }

        return view('admin.website.menus', compact('menuItems'));
    }

    /**
     * Save navigation menus.
     */
    public function saveMenus(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'menu_items' => 'required|array',
            'menu_items.*.label' => 'required|string|max:255',
            'menu_items.*.url' => 'required|string|max:255',
            'menu_items.*.icon' => 'nullable|string|max:255',
            'menu_items.*.target' => 'nullable|in:_self,_blank',
            'menu_items.*.visible' => 'nullable|boolean',
        ]);

        WebsiteSetting::set('navigation_menu', $validated['menu_items'], 'json');

        return response()->json([
            'success' => true,
            'message' => 'Navigation menu saved successfully.',
        ]);
    }

    /**
     * Show global settings panel.
     */
    public function globalSettings(): View
    {
        $settings = WebsiteSetting::all()
            ->groupBy('group')
            ->toArray();

        return view('admin.website.global-settings', compact('settings'));
    }

    /**
     * Update a single setting via AJAX.
     */
    public function updateSetting(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'key' => 'required|string|exists:website_settings,key',
            'value' => 'required',
            'type' => 'string|in:string,json,boolean,integer,float,color,file',
        ]);

        WebsiteSetting::set($validated['key'], $validated['value'], $validated['type'] ?? 'string');

        return response()->json([
            'success' => true,
            'message' => 'Setting updated successfully.',
        ]);
    }

    /**
     * Get all settings by group.
     */
    public function getSettingsByGroup(string $group): JsonResponse
    {
        $settings = WebsiteSetting::where('group', $group)->get();

        return response()->json($settings);
    }

    /**
     * Bulk update settings.
     */
    public function bulkUpdate(Request $request): JsonResponse
    {
        $settings = $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|exists:website_settings,key',
            'settings.*.value' => 'required',
        ]);

        foreach ($settings['settings'] as $setting) {
            WebsiteSetting::set($setting['key'], $setting['value']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully.',
        ]);
    }

    /**
     * Reset settings to defaults.
     */
    public function resetDefaults(Request $request): RedirectResponse
    {
        $group = $request->get('group', 'general');

        // Reset specific group settings
        WebsiteSetting::where('group', $group)->delete();

        return back()->with('success', "Settings for '$group' have been reset to defaults.");
    }
}
