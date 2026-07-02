<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Package;
use App\Models\Lead;
use App\Models\JobPosting;
use App\Models\JobApplication;
use App\Models\Order;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed default admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@everythingeasy.in',
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
            'price' => 5000.00,
            'original_price' => 6000.00,
            'discount_price' => 5000.00,
            'description' => 'Perfect for small companies.',
            'features' => ['Responsive Design', 'Vite Bundle Compile', 'SQLite Setup'],
            'delivery_time' => '10 Days',
            'revisions' => '3 Revisions',
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
        Order::create([
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
    }
}
