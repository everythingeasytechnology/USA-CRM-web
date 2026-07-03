<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Package;
use App\Models\Lead;
use App\Models\JobPosting;
use App\Models\JobApplication;
use App\Models\Order;
use App\Models\Testimonial;
use App\Models\TeamMember;
use App\Models\Faq;
use App\Models\Popup;
use App\Models\Page;
use App\Models\LegalPage;
use App\Models\SocialLink;
use App\Models\Location;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed default admin (login with admin@everythingeasy.in / password)
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@everythingeasy.in',
            'password' => Hash::make('password'),
            'role' => 'Administrator',
            'is_active' => true,
        ]);

        // Seed Services
        $webDev = Service::create([
            'name' => 'Custom Website Development',
            'slug' => 'website-development',
            'category' => 'Web Development',
            'display_order' => 1,
            'short_description' => 'Custom Laravel 12 website configurations matching Stripe and Shopify standards.',
            'long_description' => 'We design dynamic database backends and premium Blade dashboard views.',
            'pseo_enabled' => true,
            'target_countries' => 'India, United States',
            'target_states' => 'Uttarakhand, California, Delhi',
            'target_cities' => 'Dehradun, New York, Mumbai',
            'pseo_slug_template' => '{slug}-in-{city}',
            'pseo_title_template' => 'Best {service} in {city}, {state} | EverythingEasy',
            'pseo_desc_template' => 'Looking for professional {service} in {city}? Contact EverythingEasy for affordable, top-rated agency services in {city}, {state}.',
            'is_active' => true,
            'is_featured' => true
        ]);

        $seo = Service::create([
            'name' => 'Search Engine Optimization (SEO)',
            'slug' => 'seo-packages',
            'category' => 'SEO & Marketing',
            'display_order' => 2,
            'short_description' => 'Structured JSON-LD schema builder and indexation optimizations.',
            'long_description' => 'Boost your search console rankings using local doorway routing maps.',
            'pseo_enabled' => true,
            'target_countries' => 'India, United States',
            'target_cities' => 'Mumbai, New York',
            'pseo_slug_template' => '{slug}-in-{city}',
            'pseo_title_template' => 'Best {service} in {city} | SEO Experts',
            'is_active' => true,
            'is_featured' => false
        ]);

        // Seed Packages
        Package::create([
            'service_id' => $webDev->id,
            'name' => 'Startup Bundle',
            'slug' => 'startup-bundle',
            'price' => 5000.00,
            'original_price' => 6000.00,
            'discount_price' => 5000.00,
            'description' => 'Perfect for small companies.',
            'features' => ['Responsive Design', 'Vite Bundle Compile', 'SQLite Setup'],
            'delivery_time' => '10 Days',
            'revisions' => '3 Revisions',
            'status' => true,
            'display_order' => 1,
        ]);

        // Seed Leads
        Lead::create([
            'name' => 'Akhil Golu',
            'email' => 'akhil@everythingeasy.in',
            'phone' => '+91 98765 43210',
            'service_requested' => 'Web Development & CMS Setup',
            'budget' => '$5,000 - $8,000',
            'country' => 'India 🇮🇳',
            'source' => 'Package Form',
            'status' => 'new',
            'notes' => 'Looking for Laravel 12 setup with full UI reusable views.'
        ]);

        Lead::create([
            'name' => 'Sarah Connor',
            'email' => 'sarah@sky.net',
            'phone' => '+1 555-098-9012',
            'service_requested' => 'SEO Audit & Optimization',
            'budget' => '$1,500 - $3,000',
            'country' => 'United States 🇺🇸',
            'source' => 'Google Search',
            'status' => 'in_discussion',
            'notes' => 'Wants automated XML sitemap updates and IndexNow setups.'
        ]);

        // Seed Job Opening
        $job = JobPosting::create([
            'title' => 'Senior Web Developer',
            'location' => 'Remote, USA',
            'description' => 'We are looking for a Senior Web Developer with experience building modern web apps.',
            'requirements' => [
                '5+ years of web development experience',
                'Proficiency in React, Node.js, and MongoDB',
                'Strong understanding of RESTful APIs and microservices'
            ],
            'status' => true
        ]);

        // Seed Job Application
        JobApplication::create([
            'job_posting_id' => $job->id,
            'name' => 'John Watson',
            'email' => 'watson@baker.org',
            'phone' => '+1 555-901-2093',
            'experience' => '6 Years',
            'portfolio_url' => 'https://portfolio.example.com/watson',
            'resume_path' => 'storage/resumes/sample_cv.pdf',
            'cover_letter' => "Dear Hiring Team,\n\nI am writing to express my strong interest in the Senior Web Developer position...",
            'status' => 'new'
        ]);

        // Seed Orders
        $order = Order::create([
            'order_number' => 'INV-' . strtoupper(str_shuffle('ABC123XYZ9')),
            'client_name' => 'Bruce Wayne',
            'email' => 'bruce@waynecorp.com',
            'service_name' => 'Web Development & CMS Setup',
            'amount' => 5900.00,
            'tax' => 900.00,
            'discount' => 100.00,
            'status' => 'paid',
            'billing_address' => 'Wayne Tower, Gotham City'
        ]);
        $order->items()->create([
            'name' => 'Web Development & CMS Setup',
            'quantity' => 1,
            'unit_price' => 5900.00,
            'line_total' => 5900.00,
        ]);

        // Seed Testimonials
        Testimonial::create(['name' => 'Sherlock Holmes', 'company' => 'Watson Consultancy Group', 'rating' => 5, 'review' => 'EverythingEasy is incredibly fast. The JSON-LD schema generators and instant sitemaps boosted our SEO ranking significantly. Excellent UX simple layout.', 'is_active' => true, 'sort_order' => 1]);
        Testimonial::create(['name' => 'Adler Irene', 'company' => 'Opera Bohemia Inc.', 'rating' => 5, 'review' => 'Managing services packages and coupon discount checkouts has never been this simple. Reusable blade configurations saved us hundreds of dev hours.', 'is_active' => true, 'sort_order' => 2]);
        Testimonial::create(['name' => 'Mycroft Holmes', 'company' => 'Diogenes Government Registry', 'rating' => 4, 'review' => 'Simple UI setup with class-based dark mode toggles. Meets all compliance security parameters. Highly stable CMS core.', 'is_active' => false, 'sort_order' => 3]);

        // Seed Team Members
        TeamMember::create(['name' => 'Akhil Golu', 'role' => 'Senior Architect & Founder', 'bio' => '15+ years experience building Laravel CMS engines and premium dashboard solutions.', 'social_url' => 'https://linkedin.com/in/akhil', 'is_active' => true, 'sort_order' => 1]);
        TeamMember::create(['name' => 'Sarah Connor', 'role' => 'Principal SEO Engineer', 'bio' => 'Specializes in schema organization indexing and sitemaps performance audits.', 'social_url' => 'https://x.com/connor', 'is_active' => true, 'sort_order' => 2]);
        TeamMember::create(['name' => 'Diana Prince', 'role' => 'Lead UI/UX Designer', 'bio' => 'Focused on clean layouts and interactive micro-animations.', 'social_url' => 'https://instagram.com/diana', 'is_active' => true, 'sort_order' => 3]);

        // Seed FAQs
        Faq::create(['question' => 'What payment methods do you support for checkouts?', 'category' => 'pricing', 'answer' => 'We integrate Stripe, PayPal, Razorpay, and direct UPI transfers with sandbox toggles.', 'is_active' => true, 'sort_order' => 1]);
        Faq::create(['question' => 'How does the sitemap regeneration operate?', 'category' => 'technical', 'answer' => 'EverythingEasy generates sitemaps weekly or automatically index-pushes via IndexNow API.', 'is_active' => true, 'sort_order' => 2]);
        Faq::create(['question' => 'Can I customize the primary and secondary branding colors?', 'category' => 'general', 'answer' => 'Yes. Admin Settings allows toggling accent colors via full spectrum color pickers.', 'is_active' => true, 'sort_order' => 3]);
        Faq::create(['question' => 'Are legal policies compliance-ready?', 'category' => 'general', 'answer' => 'We support rich text revisions history logs for privacy and return policies.', 'is_active' => false, 'sort_order' => 4]);

        // Seed Popups
        Popup::create(['title' => 'Exit Intent Offer Overlay', 'trigger_type' => 'exit', 'content' => '<div>Wait! Get 10% off your first project.</div>', 'is_active' => true, 'impressions' => 1240, 'conversions' => 102]);
        Popup::create(['title' => 'July Festival Discount Banner', 'trigger_type' => 'delay', 'starts_at' => '2026-07-01', 'ends_at' => '2026-07-15', 'content' => '<div>July Festival Sale - 20% off!</div>', 'is_active' => true, 'impressions' => 450, 'conversions' => 56]);
        Popup::create(['title' => 'Newsletter Signup Overlay', 'trigger_type' => 'scroll', 'content' => '<div>Subscribe to our newsletter.</div>', 'is_active' => false, 'impressions' => 0, 'conversions' => 0]);

        // Seed Static Pages
        Page::create(['name' => 'Homepage Layout', 'route' => '/', 'seo_title' => 'EverythingEasy | Enterprise software simple', 'content' => 'Core landing marketing layout containing portfolio list, statistics, and email newsletters.', 'is_active' => true]);
        Page::create(['name' => 'About Us Roster', 'route' => '/about', 'seo_title' => 'About EverythingEasy Agency Team', 'content' => 'Company history, mission parameters, and executive profiles list.', 'is_active' => true]);
        Page::create(['name' => 'Contact Desk', 'route' => '/contact', 'seo_title' => 'Get in Touch with support | everythingeasy', 'content' => 'Office addresses, maps embeds, telephone, and quote fields.', 'is_active' => true]);
        Page::create(['name' => 'Frequently Asked FAQs', 'route' => '/faqs', 'seo_title' => 'Service FAQs answers', 'content' => 'Index details answering checkout queries.', 'is_active' => true]);
        Page::create(['name' => 'Careers Portal', 'route' => '/careers', 'seo_title' => 'Join the everythingeasy Team', 'content' => 'Open job listing posts.', 'is_active' => false]);
        Page::create(['name' => 'Maintenance Overlay', 'route' => '/maintenance', 'seo_title' => 'System Maintenance Underway', 'content' => 'Lock screen showing public downtime alerts.', 'is_active' => true]);

        // Seed Legal Pages
        LegalPage::create(['title' => 'Privacy Policy', 'slug' => 'privacy-policy', 'version' => 'v2.4 (Active)', 'effective_date' => '2026-07-02', 'author_role' => 'legal', 'content' => 'Add terms and legal boilerplate for the Privacy Policy here.']);
        LegalPage::create(['title' => 'Terms & Conditions', 'slug' => 'terms-conditions', 'version' => 'v2.4 (Active)', 'effective_date' => '2026-07-02', 'author_role' => 'legal', 'content' => 'Add terms and legal boilerplate for the Terms & Conditions here.']);
        LegalPage::create(['title' => 'Refund & Cancellation Policy', 'slug' => 'refund-policy', 'version' => 'v2.4 (Active)', 'effective_date' => '2026-07-02', 'author_role' => 'legal', 'content' => 'Add terms and legal boilerplate for the Refund Policy here.']);
        LegalPage::create(['title' => 'Cookie Policy', 'slug' => 'cookie-policy', 'version' => 'v2.4 (Active)', 'effective_date' => '2026-07-02', 'author_role' => 'legal', 'content' => 'Add terms and legal boilerplate for the Cookie Policy here.']);

        // Seed Social Links
        $platforms = [
            ['platform' => 'facebook', 'label' => 'Facebook', 'url' => 'https://facebook.com/everythingeasy', 'is_enabled' => true],
            ['platform' => 'instagram', 'label' => 'Instagram', 'url' => 'https://instagram.com/everythingeasy', 'is_enabled' => true],
            ['platform' => 'linkedin', 'label' => 'LinkedIn', 'url' => 'https://linkedin.com/company/everythingeasy', 'is_enabled' => true],
            ['platform' => 'twitter', 'label' => 'Twitter / X', 'url' => 'https://x.com/everythingeasy', 'is_enabled' => false],
            ['platform' => 'threads', 'label' => 'Threads', 'url' => 'https://threads.net/@everythingeasy', 'is_enabled' => false],
            ['platform' => 'pinterest', 'label' => 'Pinterest', 'url' => 'https://pinterest.com/everythingeasy', 'is_enabled' => false],
            ['platform' => 'youtube', 'label' => 'YouTube', 'url' => 'https://youtube.com/c/everythingeasy', 'is_enabled' => true],
            ['platform' => 'whatsapp', 'label' => 'WhatsApp Support Group', 'url' => 'https://chat.whatsapp.com/invite_code', 'is_enabled' => true],
            ['platform' => 'telegram', 'label' => 'Telegram channel', 'url' => 'https://t.me/everythingeasy', 'is_enabled' => false],
            ['platform' => 'discord', 'label' => 'Discord Server', 'url' => 'https://discord.gg/everythingeasy', 'is_enabled' => true],
            ['platform' => 'github', 'label' => 'GitHub Organization', 'url' => 'https://github.com/everythingeasy', 'is_enabled' => true],
        ];
        foreach ($platforms as $i => $platform) {
            SocialLink::create($platform + ['sort_order' => $i + 1]);
        }

        // Seed Locations
        Location::create(['city' => 'Dehradun', 'state' => 'Uttarakhand', 'country' => 'India']);
        Location::create(['city' => 'Mumbai', 'state' => 'Maharashtra', 'country' => 'India']);
        Location::create(['city' => 'New York', 'state' => 'New York', 'country' => 'United States']);

        // Seed default site settings
        Setting::setMany([
            'company_name' => 'EverythingEasy Solutions Pvt. Ltd.',
            'brand_name' => 'EverythingEasy',
            'tagline' => 'Enterprise Software Development & Marketing Made Simple',
            'website_url' => 'https://everythingeasy.in',
            'copyright' => '© 2026 EverythingEasy. All rights reserved.',
            'support_email' => 'support@everythingeasy.in',
            'sales_email' => 'sales@everythingeasy.in',
            'phone' => '+91 120 456 7890',
            'whatsapp' => '+91 98765 43210',
            'address' => 'Suite 404, Tech Park Sector 62, Noida, UP, India',
            'theme_primary' => '#2563eb',
            'theme_secondary' => '#1e293b',
            'maintenance_mode' => '0',
            'smtp_encryption' => 'tls',
        ], 'site');
    }
}
