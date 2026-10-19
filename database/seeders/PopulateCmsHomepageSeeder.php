<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use App\Models\CmsSection;
use Illuminate\Database\Seeder;

class PopulateCmsHomepageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or get the home page
        $page = CmsPage::where('slug', 'home')->first();
        
        if ($page) {
            // Delete existing sections
            $page->sections()->delete();
        } else {
            // Create home page
            $page = CmsPage::create([
                'title' => 'Home',
                'slug' => 'home',
                'is_published' => true,
                'is_home' => true,
                'order' => 1
            ]);
        }

        // 1. Hero Carousel Section
        CmsSection::create([
            'cms_page_id' => $page->id,
            'title' => 'Hero Carousel',
            'type' => 'hero',
            'content' => 'Your trusted platform for connecting professional drivers, vehicles, and recruitment opportunities in one seamless system.',
            'background_color' => '#1f2937',
            'order' => 1
        ]);

        // 2. Intelligent Driving Section
        CmsSection::create([
            'cms_page_id' => $page->id,
            'title' => 'Intelligent Driving Starts Here',
            'type' => 'text',
            'content' => '<p>Unlock next-level coordination for drivers, vehicles, and recruitment workflows. Discover the built-in tools that make recruitment more efficient and safer.</p>
<h4>Key Features:</h4>
<ul>
  <li><strong>Real-time tracking:</strong> Monitor license approvals, vehicle status, and driver availability in one place.</li>
  <li><strong>Fast approvals:</strong> Reduce onboarding time with a streamlined driver and vehicle review process.</li>
  <li><strong>Secure matching:</strong> Match qualified drivers to opportunities with transparent profiles and performance details.</li>
</ul>',
            'order' => 2
        ]);

        // 3. Why Choose SUCCEZZ Section
        CmsSection::create([
            'cms_page_id' => $page->id,
            'title' => 'Why Choose SUCCEZZ Drivers Agency',
            'type' => 'features',
            'content' => '<div class="feature-item">
  <i class="fas fa-user-tie me-3" style="font-size: 1.5rem; color: #3b82f6;"></i>
  <div>
    <h5>Professional Drivers</h5>
    <p>Connect with verified, experienced drivers who undergo thorough background checks and license verification for your peace of mind.</p>
  </div>
</div>
<div class="feature-item">
  <i class="fas fa-car me-3" style="font-size: 1.5rem; color: #3b82f6;"></i>
  <div>
    <h5>Reliable Vehicles</h5>
    <p>Access a wide range of well-maintained vehicles including cars, vans, and trucks, all with comprehensive insurance coverage.</p>
  </div>
</div>
<div class="feature-item">
  <i class="fas fa-calendar-check me-3" style="font-size: 1.5rem; color: #3b82f6;"></i>
  <div>
    <h5>Easy Booking Process</h5>
    <p>Simple and secure booking system with real-time confirmation, tracking, and instant communication between all parties.</p>
  </div>
</div>
<div class="feature-item">
  <i class="fas fa-shield-alt me-3" style="font-size: 1.5rem; color: #3b82f6;"></i>
  <div>
    <h5>Trusted Service</h5>
    <p>Building lasting partnerships with transparent profiles, performance tracking, and commitment to excellence in service delivery.</p>
  </div>
</div>',
            'background_color' => '#f8fafc',
            'order' => 3
        ]);

        // 4. Services Section
        CmsSection::create([
            'cms_page_id' => $page->id,
            'title' => 'Our Services',
            'type' => 'text',
            'content' => '<div class="row g-4">
  <div class="col-md-6 col-lg-3">
    <div class="service-card">
      <div class="service-icon"><i class="fas fa-users"></i></div>
      <h4>Driver Management</h4>
      <p>Connect with professional drivers, verify credentials, and manage all driver-related logistics from one platform.</p>
    </div>
  </div>
  <div class="col-md-6 col-lg-3">
    <div class="service-card">
      <div class="service-icon"><i class="fas fa-car"></i></div>
      <h4>Vehicle Rental</h4>
      <p>Access a diverse fleet of well-maintained vehicles for short-term and long-term rentals with flexible booking options.</p>
    </div>
  </div>
  <div class="col-md-6 col-lg-3">
    <div class="service-card">
      <div class="service-icon"><i class="fas fa-calendar-alt"></i></div>
      <h4>Easy Booking</h4>
      <p>Simplified booking system with real-time tracking, instant confirmation, and 24/7 customer support.</p>
    </div>
  </div>
  <div class="col-md-6 col-lg-3">
    <div class="service-card">
      <div class="service-icon"><i class="fas fa-briefcase"></i></div>
      <h4>Recruitment</h4>
      <p>Post opportunities and recruit qualified drivers and vehicle owners for your business needs.</p>
    </div>
  </div>
</div>',
            'order' => 4
        ]);

        // 5. Benefits Section
        CmsSection::create([
            'cms_page_id' => $page->id,
            'title' => 'Key Benefits',
            'type' => 'text',
            'content' => '<div class="row">
  <div class="col-md-6 mb-4">
    <div class="benefit-item">
      <h5 class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Verified Professionals</h5>
      <p class="mb-0">All drivers and vehicle owners undergo thorough vetting and background checks.</p>
    </div>
  </div>
  <div class="col-md-6 mb-4">
    <div class="benefit-item">
      <h5 class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Secure Transactions</h5>
      <p class="mb-0">Protected payments and transparent pricing with no hidden charges.</p>
    </div>
  </div>
  <div class="col-md-6 mb-4">
    <div class="benefit-item">
      <h5 class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Real-Time Support</h5>
      <p class="mb-0">24/7 customer support to assist with any questions or concerns.</p>
    </div>
  </div>
  <div class="col-md-6 mb-4">
    <div class="benefit-item">
      <h5 class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Performance Tracking</h5>
      <p class="mb-0">Monitor driver performance and vehicle maintenance in real-time.</p>
    </div>
  </div>
</div>',
            'order' => 5
        ]);

        // 6. Testimonials Section
        CmsSection::create([
            'cms_page_id' => $page->id,
            'title' => 'What Our Customers Say',
            'type' => 'text',
            'content' => '<div class="row g-4">
  <div class="col-md-4">
    <div class="testimonial-card">
      <p>"Excellent service! The drivers are professional and the booking process is incredibly easy. Highly recommended!"</p>
      <strong>John Mwangi</strong>
      <small class="text-muted">Transport Manager</small>
    </div>
  </div>
  <div class="col-md-4">
    <div class="testimonial-card">
      <p>"Finally found a reliable platform for vehicle rentals. Great support team and well-maintained vehicles."</p>
      <strong>Sarah Kipchoge</strong>
      <small class="text-muted">Business Owner</small>
    </div>
  </div>
  <div class="col-md-4">
    <div class="testimonial-card">
      <p>"The vetting process is thorough and the platform is easy to use. Great experience working with SUCCEZZ."</p>
      <strong>David Kiplagat</strong>
      <small class="text-muted">Fleet Owner</small>
    </div>
  </div>
</div>',
            'order' => 6
        ]);

        // 7. Call to Action Section
        CmsSection::create([
            'cms_page_id' => $page->id,
            'title' => 'Ready to Get Started?',
            'type' => 'hero',
            'content' => 'Join thousands of satisfied users. Browse our drivers and vehicles or post your recruitment needs today!',
            'background_color' => '#3b82f6',
            'order' => 7
        ]);

        echo "✓ CMS homepage populated with 7 sections successfully!\n";
    }
}
