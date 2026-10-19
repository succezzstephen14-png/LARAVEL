<?php

namespace Database\Seeders;

use App\Models\CmsFooter;
use App\Models\CmsHeader;
use App\Models\CmsCard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CmsElementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        CmsFooter::truncate();
        CmsHeader::truncate();
        CmsCard::truncate();

        // ===== FOOTER ELEMENTS =====
        
        // Main footer description
        CmsFooter::create([
            'section' => 'main',
            'label' => 'About',
            'title' => 'Vehicle & Driver Recruitment',
            'content' => 'Secure matches for logistics teams, drivers, and vehicle owners — all in one polished portal.',
            'type' => 'text',
            'order' => 1,
        ]);

        // Column 1: Explore Links
        CmsFooter::create([
            'section' => 'column1',
            'label' => 'Explore',
            'title' => 'Explore',
            'type' => 'label',
            'order' => 1,
        ]);

        CmsFooter::create([
            'section' => 'column1',
            'title' => 'Home',
            'link' => '/',
            'type' => 'link',
            'order' => 2,
        ]);

        CmsFooter::create([
            'section' => 'column1',
            'title' => 'Drivers',
            'link' => '/drivers',
            'type' => 'link',
            'order' => 3,
        ]);

        CmsFooter::create([
            'section' => 'column1',
            'title' => 'Vehicles',
            'link' => '/vehicles',
            'type' => 'link',
            'order' => 4,
        ]);

        CmsFooter::create([
            'section' => 'column1',
            'title' => 'Recruitments',
            'link' => '/recruitments',
            'type' => 'link',
            'order' => 5,
        ]);

        // Column 2: Connect (Social)
        CmsFooter::create([
            'section' => 'column2',
            'label' => 'Connect',
            'title' => 'Connect',
            'type' => 'label',
            'order' => 1,
        ]);

        CmsFooter::create([
            'section' => 'column2',
            'title' => 'Facebook',
            'link' => 'https://www.facebook.com/share/1CQarEnFX4/?mibextid=wwXIfr',
            'icon' => 'fab fa-facebook-f',
            'type' => 'social',
            'order' => 2,
        ]);

        CmsFooter::create([
            'section' => 'column2',
            'title' => 'Twitter',
            'link' => '#',
            'icon' => 'fab fa-twitter',
            'type' => 'social',
            'order' => 3,
        ]);

        CmsFooter::create([
            'section' => 'column2',
            'title' => 'LinkedIn',
            'link' => '#',
            'icon' => 'fab fa-linkedin-in',
            'type' => 'social',
            'order' => 4,
        ]);

        CmsFooter::create([
            'section' => 'column2',
            'title' => 'Instagram',
            'link' => 'https://www.instagram.com/succezzdriversagency?igsh=MWxnand6b3Zlcmc5OQ%3D%3D&utm_source=qr',
            'icon' => 'fab fa-instagram',
            'type' => 'social',
            'order' => 5,
        ]);

        CmsFooter::create([
            'section' => 'column2',
            'content' => 'Ready to recruit or apply? Start with your profile today.',
            'type' => 'text',
            'order' => 6,
        ]);

        // Bottom section
        CmsFooter::create([
            'section' => 'bottom',
            'content' => '© 2026 SUCCEZZ Drivers Agency. All rights reserved.',
            'type' => 'text',
            'order' => 1,
        ]);

        CmsFooter::create([
            'section' => 'bottom',
            'title' => 'Privacy Policy',
            'link' => '/privacy-policy',
            'type' => 'link',
            'order' => 2,
        ]);

        CmsFooter::create([
            'section' => 'bottom',
            'title' => 'Terms of Service',
            'link' => '/terms-and-conditions',
            'type' => 'link',
            'order' => 3,
        ]);

        CmsFooter::create([
            'section' => 'bottom',
            'title' => 'Support',
            'link' => '/#contact',
            'type' => 'link',
            'order' => 4,
        ]);

        // ===== HEADER/NAVIGATION ELEMENTS =====

        CmsHeader::create([
            'section' => 'logo',
            'title' => 'SUCCEZZ Drivers Agency',
            'type' => 'logo',
            'order' => 1,
        ]);

        CmsHeader::create([
            'section' => 'nav',
            'title' => 'Home',
            'link' => '/',
            'type' => 'link',
            'order' => 1,
        ]);

        CmsHeader::create([
            'section' => 'nav',
            'title' => 'Services',
            'link' => '/#services',
            'type' => 'link',
            'order' => 2,
        ]);

        CmsHeader::create([
            'section' => 'nav',
            'title' => 'Contact',
            'link' => '/#contact',
            'type' => 'link',
            'order' => 3,
        ]);

        CmsHeader::create([
            'section' => 'nav',
            'title' => 'Vehicles',
            'link' => '/vehicles',
            'type' => 'link',
            'order' => 4,
        ]);

        CmsHeader::create([
            'section' => 'nav',
            'title' => 'Drivers',
            'link' => '/drivers',
            'type' => 'link',
            'order' => 5,
        ]);

        CmsHeader::create([
            'section' => 'nav',
            'title' => 'Recruitment',
            'link' => '/recruitments',
            'type' => 'link',
            'order' => 6,
        ]);

        // Hero slides
        CmsCard::create([
            'section' => 'hero',
            'type' => 'slide',
            'title' => 'Trusted & Professional Drivers',
            'description' => 'Connect with verified, experienced drivers for all your transportation needs',
            'button_text' => 'Explore Drivers',
            'button_link' => '/drivers',
            'image_url' => 'https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=1500&q=80',
            'order' => 1,
        ]);

        CmsCard::create([
            'section' => 'hero',
            'type' => 'slide',
            'title' => 'Affordable Vehicle Rentals',
            'description' => 'Wide selection of well-maintained vehicles for your business and personal use',
            'button_text' => 'Browse Vehicles',
            'button_link' => '/vehicles',
            'image_url' => 'https://images.unsplash.com/photo-1552820728-8ac41f1ce891?auto=format&fit=crop&w=1500&q=80',
            'order' => 2,
        ]);

        CmsCard::create([
            'section' => 'hero',
            'type' => 'slide',
            'title' => 'Easy Booking System',
            'description' => 'Simple and secure booking process with real-time confirmation and tracking',
            'button_text' => 'Book Now',
            'button_link' => '/book',
            'image_url' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1500&q=80',
            'order' => 3,
        ]);

        CmsCard::create([
            'section' => 'hero',
            'type' => 'slide',
            'title' => 'Join Our Growing Team',
            'description' => 'Explore recruitment opportunities for drivers and vehicle owners',
            'button_text' => 'View Opportunities',
            'button_link' => '/recruitments',
            'image_url' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1500&q=80',
            'order' => 4,
        ]);

        // ===== CARD ELEMENTS =====
        // Feature Cards
        CmsCard::create([
            'section' => 'features',
            'title' => 'Professional Drivers',
            'description' => 'Connect with verified, experienced drivers who undergo thorough background checks and license verification for maximum safety.',
            'icon' => 'fas fa-user-tie',
            'type' => 'feature',
            'order' => 1,
        ]);

        CmsCard::create([
            'section' => 'features',
            'title' => 'Premium Vehicles',
            'description' => 'Access quality-assured vehicles with complete maintenance records, insurance, and real-time tracking capabilities.',
            'icon' => 'fas fa-truck',
            'type' => 'feature',
            'order' => 2,
        ]);

        CmsCard::create([
            'section' => 'features',
            'title' => 'Streamlined Recruitment',
            'description' => 'Post requirements, receive applications, and onboard talent efficiently through our intuitive platform.',
            'icon' => 'fas fa-briefcase',
            'type' => 'feature',
            'order' => 3,
        ]);

        CmsCard::create([
            'section' => 'features',
            'title' => 'Secure Transactions',
            'description' => 'End-to-end encryption and secure payment processing ensure every interaction is protected and reliable.',
            'icon' => 'fas fa-lock',
            'type' => 'feature',
            'order' => 4,
        ]);

        // Testimonial Cards
        CmsCard::create([
            'section' => 'testimonials',
            'title' => 'SUCCEZZ has transformed our operations',
            'content' => '"SUCCEZZ Drivers Agency has completely transformed how we manage transportation. The drivers are professional, punctual, and very reliable. Highly recommended!"',
            'badge' => '⭐⭐⭐⭐⭐',
            'type' => 'testimonial',
            'order' => 1,
        ]);

        CmsCard::create([
            'section' => 'testimonials',
            'title' => 'Fast and efficient platform',
            'content' => '"The recruitment process on SUCCEZZ is incredibly fast and efficient. We found perfect matches for our fleet within days. Great service!"',
            'badge' => '⭐⭐⭐⭐⭐',
            'type' => 'testimonial',
            'order' => 2,
        ]);

        CmsCard::create([
            'section' => 'testimonials',
            'title' => 'Excellent support team',
            'content' => '"Exceptional support and transparent pricing. SUCCEZZ helped us scale our business without any hassles. Best decision ever!"',
            'badge' => '⭐⭐⭐⭐⭐',
            'type' => 'testimonial',
            'order' => 3,
        ]);

        // Service Cards
        CmsCard::create([
            'section' => 'services',
            'title' => 'Driver Recruitment',
            'description' => 'Find and hire experienced drivers with verified credentials, training, and background checks.',
            'icon' => 'fas fa-id-card',
            'button_text' => 'Browse Drivers',
            'button_link' => '/drivers',
            'type' => 'service',
            'order' => 1,
        ]);

        CmsCard::create([
            'section' => 'services',
            'title' => 'Vehicle Sourcing',
            'description' => 'Access a wide range of premium vehicles—trucks, vans, and specialized transport vehicles.',
            'icon' => 'fas fa-car-side',
            'button_text' => 'View Vehicles',
            'button_link' => '/vehicles',
            'type' => 'service',
            'order' => 2,
        ]);

        CmsCard::create([
            'section' => 'services',
            'title' => 'Recruitment Solutions',
            'description' => 'Post positions and receive applications from qualified candidates across the logistics and transport sector.',
            'icon' => 'fas fa-handshake',
            'button_text' => 'Post Position',
            'button_link' => '/recruitments/create',
            'type' => 'service',
            'order' => 3,
        ]);

        CmsCard::create([
            'section' => 'services',
            'title' => 'Booking & Management',
            'description' => 'Seamlessly book drivers and vehicles with integrated tracking, payments, and real-time updates.',
            'icon' => 'fas fa-calendar-check',
            'button_text' => 'Book Now',
            'button_link' => '/book',
            'type' => 'service',
            'order' => 4,
        ]);
    }
}
