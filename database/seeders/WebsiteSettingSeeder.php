<?php

namespace Database\Seeders;

use App\Models\WebsiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebsiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_name',
                'value' => 'SUCCEZZ Drivers Agency',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Site Name',
                'description' => 'The name of your website',
                'is_public' => true,
            ],
            [
                'key' => 'site_description',
                'value' => 'Professional driver services and vehicle rentals',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Site Description',
                'description' => 'Brief description of your website',
                'is_public' => true,
            ],
            [
                'key' => 'site_email',
                'value' => 'info@succeszzdrivers.com',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Contact Email',
                'description' => 'Primary contact email address',
                'is_public' => true,
            ],
            [
                'key' => 'site_phone',
                'value' => '+1 (555) 123-4567',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Contact Phone',
                'description' => 'Primary contact phone number',
                'is_public' => true,
            ],

            // Appearance Settings
            [
                'key' => 'primary_color',
                'value' => '#007bff',
                'type' => 'color',
                'group' => 'appearance',
                'label' => 'Primary Color',
                'description' => 'Main brand color used throughout the site',
                'is_public' => true,
            ],
            [
                'key' => 'secondary_color',
                'value' => '#6c757d',
                'type' => 'color',
                'group' => 'appearance',
                'label' => 'Secondary Color',
                'description' => 'Secondary brand color',
                'is_public' => true,
            ],
            [
                'key' => 'accent_color',
                'value' => '#28a745',
                'type' => 'color',
                'group' => 'appearance',
                'label' => 'Accent Color',
                'description' => 'Accent color for highlights and buttons',
                'is_public' => true,
            ],
            [
                'key' => 'primary_font',
                'value' => 'Inter, sans-serif',
                'type' => 'string',
                'group' => 'appearance',
                'label' => 'Primary Font',
                'description' => 'Main font family for headings and body text',
                'is_public' => true,
            ],
            [
                'key' => 'secondary_font',
                'value' => 'Poppins, sans-serif',
                'type' => 'string',
                'group' => 'appearance',
                'label' => 'Secondary Font',
                'description' => 'Secondary font for special elements',
                'is_public' => true,
            ],

            // Header & Footer
            [
                'key' => 'header_title',
                'value' => 'SUCCEZZ Drivers Agency',
                'type' => 'string',
                'group' => 'header_footer',
                'label' => 'Header Title',
                'description' => 'Title displayed in the website header',
                'is_public' => true,
            ],
            [
                'key' => 'footer_text',
                'value' => '© 2026 SUCCEZZ Drivers Agency. All rights reserved.',
                'type' => 'string',
                'group' => 'header_footer',
                'label' => 'Footer Copyright Text',
                'description' => 'Copyright text displayed in footer',
                'is_public' => true,
            ],

            // SEO Settings
            [
                'key' => 'meta_title_default',
                'value' => 'SUCCEZZ Drivers Agency - Professional Driver Services',
                'type' => 'string',
                'group' => 'seo',
                'label' => 'Default Meta Title',
                'description' => 'Default page title for SEO',
                'is_public' => true,
            ],
            [
                'key' => 'meta_description_default',
                'value' => 'Professional driver services, vehicle rentals, and transportation solutions. Book reliable drivers for your transportation needs.',
                'type' => 'string',
                'group' => 'seo',
                'label' => 'Default Meta Description',
                'description' => 'Default meta description for SEO',
                'is_public' => true,
            ],
            [
                'key' => 'meta_keywords_default',
                'value' => 'drivers, transportation, vehicle rental, chauffeur, professional drivers',
                'type' => 'string',
                'group' => 'seo',
                'label' => 'Default Meta Keywords',
                'description' => 'Default meta keywords for SEO',
                'is_public' => true,
            ],

            // Social Media
            [
                'key' => 'facebook_url',
                'value' => 'https://facebook.com/succeszzdrivers',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Facebook URL',
                'description' => 'Facebook page URL',
                'is_public' => true,
            ],
            [
                'key' => 'twitter_url',
                'value' => 'https://twitter.com/succeszzdrivers',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Twitter URL',
                'description' => 'Twitter profile URL',
                'is_public' => true,
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://instagram.com/succeszzdrivers',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Instagram URL',
                'description' => 'Instagram profile URL',
                'is_public' => true,
            ],
            [
                'key' => 'linkedin_url',
                'value' => 'https://linkedin.com/company/succeszzdrivers',
                'type' => 'string',
                'group' => 'social',
                'label' => 'LinkedIn URL',
                'description' => 'LinkedIn company page URL',
                'is_public' => true,
            ],

            // System Settings
            [
                'key' => 'maintenance_mode',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'system',
                'label' => 'Maintenance Mode',
                'description' => 'Enable maintenance mode for the website',
                'is_public' => false,
            ],
            [
                'key' => 'registration_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'system',
                'label' => 'User Registration',
                'description' => 'Allow new user registrations',
                'is_public' => false,
            ],
            [
                'key' => 'email_verification_required',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'system',
                'label' => 'Email Verification',
                'description' => 'Require email verification for new accounts',
                'is_public' => false,
            ],
        ];

        foreach ($settings as $setting) {
            WebsiteSetting::create($setting);
        }
    }
}
