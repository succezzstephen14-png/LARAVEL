<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\SiteSetting::create([
            'site_title' => 'Driver Recruitment Platform',
            'site_description' => 'Find and book professional drivers and vehicles for your needs.',
            'primary_color' => '#007bff',
            'secondary_color' => '#6c757d',
            'font_family' => 'Arial, sans-serif',
            'font_color' => '#000000',
            'background_color' => '#ffffff',
            'background_image' => null,
            'custom_css' => '',
            'home_page_content' => 'Welcome to our platform!',
            'footer_text' => '© 2024 Driver Recruitment Platform',
        ]);
    }
}
