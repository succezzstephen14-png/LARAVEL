<?php

use Illuminate\Database\Seeder;
use App\Models\CmsPage;
use App\Models\CmsSection;

class CmsPageSeeder extends Seeder
{
    public function run()
    {
        // Create home page
        $homepage = CmsPage::create([
            'title' => 'Welcome to Our Platform',
            'slug' => 'home',
            'description' => 'This is the homepage created from the CMS',
            'seo_title' => 'Welcome | SUCCEZZ Drivers Agency',
            'seo_description' => 'Find professional drivers and vehicles for your transportation needs',
            'template' => 'default',
            'is_published' => true,
            'is_home' => true,
            'order' => 1,
        ]);

        // Add hero section
        CmsSection::create([
            'cms_page_id' => $homepage->id,
            'title' => 'Welcome to SUCCEZZ',
            'type' => 'hero',
            'content' => 'Start managing your transportation business with confidence. Book reliable drivers and vehicles for your needs.',
            'background_color' => '#6366f1',
            'order' => 1,
        ]);

        // Add text section
        CmsSection::create([
            'cms_page_id' => $homepage->id,
            'title' => 'Why Choose Us?',
            'type' => 'text',
            'content' => '<p>SUCCEZZ provides a comprehensive platform for booking professional drivers and quality vehicles. Our verified professionals ensure safety, reliability, and exceptional service.</p>',
            'order' => 2,
        ]);

        $this->command->info('CMS homepage created successfully!');
    }
}
