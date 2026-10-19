<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use App\Models\CmsSection;
use Illuminate\Database\Seeder;

class CreateAdditionalCmsPages extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Services Page
        $servicesPage = CmsPage::firstOrCreate(
            ['slug' => 'services'],
            [
                'title' => 'Our Services',
                'description' => 'Comprehensive transportation and recruitment solutions',
                'is_published' => true,
                'order' => 2
            ]
        );

        if ($servicesPage->sections()->count() === 0) {
            CmsSection::create([
                'cms_page_id' => $servicesPage->id,
                'title' => 'Professional Driver Services',
                'type' => 'text',
                'content' => '<p>Connect with verified, professional drivers for all your transportation needs. Our platform ensures thorough background checks and license verification.</p>
<ul>
  <li>Experienced drivers with clean records</li>
  <li>Real-time driver tracking and communication</li>
  <li>Flexible booking for short and long-term needs</li>
  <li>Competitive rates and transparent pricing</li>
</ul>',
                'order' => 1
            ]);

            CmsSection::create([
                'cms_page_id' => $servicesPage->id,
                'title' => 'Vehicle Rental Solutions',
                'type' => 'text',
                'content' => '<p>Choose from our diverse fleet of well-maintained vehicles for personal and business use.</p>
<ul>
  <li>Wide selection: cars, vans, trucks</li>
  <li>Comprehensive insurance coverage</li>
  <li>Regular maintenance and inspections</li>
  <li>Flexible rental periods and pricing</li>
</ul>',
                'order' => 2
            ]);

            CmsSection::create([
                'cms_page_id' => $servicesPage->id,
                'title' => 'Easy Booking System',
                'type' => 'text',
                'content' => '<p>Simple, secure, and transparent booking process with real-time tracking and support.</p>
<ul>
  <li>Quick online booking</li>
  <li>Instant confirmation and notifications</li>
  <li>Real-time tracking of drivers and vehicles</li>
  <li>24/7 customer support</li>
</ul>',
                'order' => 3
            ]);
        }

        // About Page
        $aboutPage = CmsPage::firstOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'About SUCCEZZ',
                'description' => 'Learn about our mission and values',
                'is_published' => true,
                'order' => 3
            ]
        );

        if ($aboutPage->sections()->count() === 0) {
            CmsSection::create([
                'cms_page_id' => $aboutPage->id,
                'title' => 'Who We Are',
                'type' => 'text',
                'content' => '<p>SUCCEZZ Drivers Agency is a leading platform connecting professional drivers, vehicle owners, and businesses. We are committed to revolutionizing the transportation and recruitment industry with innovative, secure, and user-friendly solutions.</p>',
                'order' => 1
            ]);

            CmsSection::create([
                'cms_page_id' => $aboutPage->id,
                'title' => 'Our Mission',
                'type' => 'hero',
                'content' => 'To provide secure, efficient, and transparent connections between drivers, vehicles, and recruitment opportunities.',
                'background_color' => '#3b82f6',
                'order' => 2
            ]);

            CmsSection::create([
                'cms_page_id' => $aboutPage->id,
                'title' => 'Our Values',
                'type' => 'text',
                'content' => '<h4>Trust & Transparency</h4>
<p>We believe in honest communication and transparent operations in all our dealings.</p>
<h4>Professional Excellence</h4>
<p>We maintain high standards in service delivery and professional conduct.</p>
<h4>Customer-Centric Approach</h4>
<p>Your satisfaction and success are at the heart of everything we do.</p>
<h4>Innovation & Technology</h4>
<p>We continuously improve our platform to meet evolving customer needs.</p>',
                'order' => 3
            ]);

            CmsSection::create([
                'cms_page_id' => $aboutPage->id,
                'title' => 'Why Choose Us',
                'type' => 'features',
                'content' => '<div class="feature-item">
  <h5><i class="fas fa-check-circle text-success me-2"></i>Verified Professionals</h5>
  <p>All users undergo thorough vetting and background checks.</p>
</div>
<div class="feature-item">
  <h5><i class="fas fa-check-circle text-success me-2"></i>Secure Platform</h5>
  <p>State-of-the-art security measures protect your data and transactions.</p>
</div>
<div class="feature-item">
  <h5><i class="fas fa-check-circle text-success me-2"></i>24/7 Support</h5>
  <p>Our dedicated support team is always ready to help.</p>
</div>
<div class="feature-item">
  <h5><i class="fas fa-check-circle text-success me-2"></i>Proven Track Record</h5>
  <p>Thousands of successful connections and satisfied users.</p>
</div>',
                'order' => 4
            ]);
        }

        // Contact Page
        $contactPage = CmsPage::firstOrCreate(
            ['slug' => 'contact'],
            [
                'title' => 'Contact Us',
                'description' => 'Get in touch with our support team',
                'is_published' => true,
                'order' => 4
            ]
        );

        if ($contactPage->sections()->count() === 0) {
            CmsSection::create([
                'cms_page_id' => $contactPage->id,
                'title' => 'Get in Touch',
                'type' => 'text',
                'content' => '<p>Have a question or need assistance? Our support team is here to help. Reach out to us through any of the following channels:</p>',
                'order' => 1
            ]);

            CmsSection::create([
                'cms_page_id' => $contactPage->id,
                'title' => 'Contact Information',
                'type' => 'text',
                'content' => '<div class="row">
  <div class="col-md-6 mb-4">
    <h5><i class="fas fa-envelope text-primary me-2"></i>Email</h5>
    <p><a href="mailto:support@succezz.com">support@succezz.com</a></p>
  </div>
  <div class="col-md-6 mb-4">
    <h5><i class="fas fa-phone text-primary me-2"></i>Phone</h5>
    <p><a href="tel:+254712345678">+254 712 345 678</a></p>
  </div>
  <div class="col-md-6 mb-4">
    <h5><i class="fas fa-map-marker-alt text-primary me-2"></i>Address</h5>
    <p>Nairobi, Kenya</p>
  </div>
  <div class="col-md-6 mb-4">
    <h5><i class="fas fa-clock text-primary me-2"></i>Hours</h5>
    <p>Monday - Sunday: 24/7</p>
  </div>
</div>',
                'order' => 2
            ]);

            CmsSection::create([
                'cms_page_id' => $contactPage->id,
                'title' => 'Follow Us',
                'type' => 'text',
                'content' => '<p>Connect with us on social media for updates and news:</p>
<div class="mt-3">
  <a href="https://www.facebook.com" class="btn btn-sm btn-primary me-2"><i class="fab fa-facebook me-1"></i> Facebook</a>
  <a href="https://www.twitter.com" class="btn btn-sm btn-info me-2"><i class="fab fa-twitter me-1"></i> Twitter</a>
  <a href="https://www.instagram.com" class="btn btn-sm btn-danger"><i class="fab fa-instagram me-1"></i> Instagram</a>
</div>',
                'order' => 3
            ]);
        }

        echo "✓ Additional CMS pages created: Services, About, Contact\n";
    }
}
