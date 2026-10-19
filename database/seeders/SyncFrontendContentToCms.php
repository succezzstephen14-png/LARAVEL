<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use App\Models\CmsSection;
use Illuminate\Database\Seeder;

class SyncFrontendContentToCms extends Seeder
{
    public function run(): void
    {
        // Update Home Page
        $homepage = CmsPage::where('slug', 'home')->first();
        if ($homepage) {
            $homepage->sections()->delete();
            
            CmsSection::create([
                'cms_page_id' => $homepage->id,
                'title' => 'Hero Carousel',
                'type' => 'hero',
                'content' => 'Your trusted platform for connecting professional drivers, vehicles, and recruitment opportunities.',
                'background_color' => '#1f2937',
                'order' => 1
            ]);

            CmsSection::create([
                'cms_page_id' => $homepage->id,
                'title' => 'Intelligent Driving Starts Here',
                'type' => 'text',
                'content' => '<h4>Unlock next-level coordination</h4>
<p>Discover the built-in tools that make recruitment more efficient and safer.</p>
<h5>Key Features:</h5>
<ul>
  <li><strong>Real-time tracking:</strong> Monitor license approvals, vehicle status, and driver availability in one place.</li>
  <li><strong>Fast approvals:</strong> Reduce onboarding time with a streamlined driver and vehicle review process.</li>
  <li><strong>Secure matching:</strong> Match qualified drivers to opportunities with transparent profiles and performance details.</li>
</ul>',
                'order' => 2
            ]);

            CmsSection::create([
                'cms_page_id' => $homepage->id,
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
                'order' => 3
            ]);

            CmsSection::create([
                'cms_page_id' => $homepage->id,
                'title' => 'What Our Customers Say',
                'type' => 'text',
                'content' => '<div class="row g-4">
  <div class="col-md-4">
    <div class="testimonial-card">
      <p>"SUCCEZZ Drivers Agency has completely transformed how we manage transportation. The drivers are professional, punctual, and very respectful. Booking is simple and reliable every time."</p>
      <strong>Michael A.</strong>
      <small class="text-muted">Business Owner</small>
    </div>
  </div>
  <div class="col-md-4">
    <div class="testimonial-card">
      <p>"I used their daily sales service and it\'s very flexible and convenient. The process is smooth, and the support team is always helpful. I highly recommend them."</p>
      <strong>Sandra K.</strong>
      <small class="text-muted">Entrepreneur</small>
    </div>
  </div>
  <div class="col-md-4">
    <div class="testimonial-card">
      <p>"Everything from vehicle quality to driver professionalism is top-notch. SUCCEZZ truly delivers safety and reliability."</p>
      <strong>Daniel T.</strong>
      <small class="text-muted">Private Client</small>
    </div>
  </div>
</div>',
                'order' => 4
            ]);

            CmsSection::create([
                'cms_page_id' => $homepage->id,
                'title' => 'Ready to Get Started?',
                'type' => 'hero',
                'content' => 'Join thousands of satisfied users. Browse our drivers and vehicles or post your recruitment needs today!',
                'background_color' => '#3b82f6',
                'order' => 5
            ]);
        }

        // Update Services Page
        $servicesPage = CmsPage::where('slug', 'services')->first();
        if ($servicesPage) {
            $servicesPage->sections()->delete();
            
            CmsSection::create([
                'cms_page_id' => $servicesPage->id,
                'title' => 'COMFI - TROSKI',
                'type' => 'text',
                'content' => '<h4>Book Professional Drivers</h4>
<p>Find experienced drivers immediately and schedule a ride with confidence. We connect you with trusted, verified professionals for safe, on-demand trips.</p>
<ul>
  <li>Experienced drivers with clean records</li>
  <li>Real-time driver tracking and communication</li>
  <li>Immediate availability and responsive service</li>
  <li>Competitive rates and transparent pricing</li>
</ul>',
                'order' => 1
            ]);

            CmsSection::create([
                'cms_page_id' => $servicesPage->id,
                'title' => 'SALES TO OWN',
                'type' => 'text',
                'content' => '<h4>Vehicle Ownership Opportunities</h4>
<p>Explore vehicle ownership opportunities and flexible support plans. Join our growing network of vehicle owners earning stable income.</p>
<ul>
  <li>Competitive commission structures</li>
  <li>Vehicle acquisition support and guidance</li>
  <li>Steady income opportunities</li>
  <li>Comprehensive insurance coverage</li>
</ul>',
                'order' => 2
            ]);

            CmsSection::create([
                'cms_page_id' => $servicesPage->id,
                'title' => 'CONTRACT DRIVERS',
                'type' => 'text',
                'content' => '<h4>Apply for Contract Driving Roles</h4>
<p>Find contract work and connect with employers offering steady driving jobs. Build your career with stable contracts.</p>
<ul>
  <li>Stable contract positions</li>
  <li>Flexible working arrangements</li>
  <li>Professional development opportunities</li>
  <li>Reliable monthly income</li>
</ul>',
                'order' => 3
            ]);

            CmsSection::create([
                'cms_page_id' => $servicesPage->id,
                'title' => 'DAILY SALES SERVICES',
                'type' => 'text',
                'content' => '<h4>Daily Sales-Driving Work</h4>
<p>Find daily sales-driving work without vehicle ownership. Browse short-term daily earning assignments perfect for flexible schedules.</p>
<ul>
  <li>Daily earning opportunities</li>
  <li>No vehicle ownership required</li>
  <li>Flexible schedule options</li>
  <li>Quick payment processing</li>
</ul>',
                'order' => 4
            ]);
        }

        // Update About Page
        $aboutPage = CmsPage::where('slug', 'about')->first();
        if ($aboutPage) {
            $aboutPage->sections()->delete();
            
            CmsSection::create([
                'cms_page_id' => $aboutPage->id,
                'title' => 'About SUCCEZZ Drivers Agency',
                'type' => 'text',
                'content' => '<h4>Humanity for Others</h4>
<p>SUCCEZZ Drivers Agency is dedicated to connecting transportation businesses with reliable, professional drivers and vehicles. We believe in creating opportunities that benefit everyone in the transportation ecosystem.</p>
<p>Our platform brings together trusted drivers, quality vehicles, and growing businesses to create a seamless transportation solution.</p>',
                'order' => 1
            ]);

            CmsSection::create([
                'cms_page_id' => $aboutPage->id,
                'title' => 'Our Vision',
                'type' => 'hero',
                'content' => 'To be the leading provider of premium driver services, renowned for our reliability and unparalleled expertise, ensuring peace of mind and superior experiences for all our clients.',
                'background_color' => '#0f172a',
                'order' => 2
            ]);

            CmsSection::create([
                'cms_page_id' => $aboutPage->id,
                'title' => 'Our Mission',
                'type' => 'hero',
                'content' => 'To deliver exceptional transportation solutions by providing highly skilled, trustworthy, and experienced drivers who prioritize safety, reliability, and customer satisfaction.',
                'background_color' => '#3b82f6',
                'order' => 3
            ]);

            CmsSection::create([
                'cms_page_id' => $aboutPage->id,
                'title' => 'Why Choose Us',
                'type' => 'features',
                'content' => '<div class="feature-item">
  <h5><i class="fas fa-shield-alt text-primary me-2"></i>Trusted & Verified</h5>
  <p>All our drivers undergo thorough background checks and license verification.</p>
</div>
<div class="feature-item">
  <h5><i class="fas fa-clock text-primary me-2"></i>Reliable Service</h5>
  <p>Punctual, professional service you can count on for your transportation needs.</p>
</div>
<div class="feature-item">
  <h5><i class="fas fa-handshake text-primary me-2"></i>Partnership Focus</h5>
  <p>Building lasting relationships between drivers, vehicle owners, and businesses.</p>
</div>',
                'order' => 4
            ]);
        }

        // Update Contact Page
        $contactPage = CmsPage::where('slug', 'contact')->first();
        if ($contactPage) {
            $contactPage->sections()->delete();
            
            CmsSection::create([
                'cms_page_id' => $contactPage->id,
                'title' => 'Get in Touch',
                'type' => 'text',
                'content' => '<p>We\'re here to help with all your transportation and recruitment needs. Reach out to us through any of the channels below.</p>',
                'order' => 1
            ]);

            CmsSection::create([
                'cms_page_id' => $contactPage->id,
                'title' => 'Contact Information',
                'type' => 'text',
                'content' => '<div class="row">
  <div class="col-md-6 mb-4">
    <h5><i class="fas fa-phone text-primary me-2"></i>Phone</h5>
    <p><a href="tel:+233500730901">+233 50 073 0901</a></p>
    <p><a href="tel:+233555962723">+233 55 596 2723</a></p>
  </div>
  <div class="col-md-6 mb-4">
    <h5><i class="fas fa-envelope text-primary me-2"></i>Email</h5>
    <p><a href="mailto:info@succezzdriversagency.com">info@succezzdriversagency.com</a></p>
    <p><a href="mailto:support@succezzdriversagency.com">support@succezzdriversagency.com</a></p>
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
  <a href="https://www.facebook.com/share/1CQarEnFX4/" class="btn btn-sm btn-primary me-2"><i class="fab fa-facebook me-1"></i> Facebook</a>
  <a href="https://www.instagram.com/succezzdriversagency" class="btn btn-sm btn-danger"><i class="fab fa-instagram me-1"></i> Instagram</a>
</div>',
                'order' => 3
            ]);
        }

        // Create Driver Code of Conduct Page
        $policyPage = CmsPage::firstOrCreate(
            ['slug' => 'driver-policy'],
            [
                'title' => 'Driver Code of Conduct',
                'description' => 'Professional standards and expectations for SUCCEZZ drivers',
                'is_published' => true,
                'order' => 5
            ]
        );

        if ($policyPage->sections()->count() === 0) {
            CmsSection::create([
                'cms_page_id' => $policyPage->id,
                'title' => 'Purpose of the Policy',
                'type' => 'text',
                'content' => '<p>This policy establishes the professional standards, responsibilities, and behavioral expectations required of all drivers representing SUCCEZZ Drivers Agency. It ensures safety, reliability, and professionalism in all service engagements.</p>',
                'order' => 1
            ]);

            CmsSection::create([
                'cms_page_id' => $policyPage->id,
                'title' => 'Professional Conduct',
                'type' => 'text',
                'content' => '<ul>
  <li>Maintain respectful and professional behavior at all times</li>
  <li>Dress neatly and appropriately</li>
  <li>Follow client instructions within legal limits</li>
  <li>Avoid arguments or inappropriate discussions</li>
  <li>Do not discuss sensitive or personal matters while on duty</li>
</ul>',
                'order' => 2
            ]);

            CmsSection::create([
                'cms_page_id' => $policyPage->id,
                'title' => 'Safety and Driving Standards',
                'type' => 'text',
                'content' => '<ul>
  <li>Obey all traffic laws</li>
  <li>Drive responsibly and defensively</li>
  <li>Never drive under the influence</li>
  <li>Perform vehicle safety checks before trips</li>
  <li>Report faults immediately</li>
</ul>',
                'order' => 3
            ]);

            CmsSection::create([
                'cms_page_id' => $policyPage->id,
                'title' => 'Confidentiality and Trust',
                'type' => 'text',
                'content' => '<ul>
  <li>Keep all client information confidential</li>
  <li>Do not share client details or routes</li>
  <li>Avoid recording or photographing clients</li>
  <li>Respect privacy at all times</li>
  <li>Violations may lead to termination</li>
</ul>',
                'order' => 4
            ]);
        }

        echo "✓ All frontend content synced to CMS successfully!\n";
        echo "✓ Homepage, Services, About, Contact, and Driver Policy pages updated.\n";
    }
}
