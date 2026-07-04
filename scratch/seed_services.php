<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Service;
use App\Models\Package;

$newServices = [
    [
        'name' => 'Digital Marketing',
        'slug' => 'digital-marketing',
        'category' => 'Marketing',
        'short_description' => 'Maximize your digital footprint and conversions. From strategic marketing to social media growth, we connect your brand with high-intent buyers.',
        'packages' => [
            ['name' => 'Starter Campaign', 'price' => 199, 'delivery_time' => '10 days', 'revisions' => '3 Rounds', 'features' => ['Social Setup', '3 Posts/Week', 'Monthly Report']],
            ['name' => 'Growth Campaign', 'price' => 499, 'delivery_time' => '30 days', 'revisions' => 'Unlimited', 'features' => ['Ad Management', '8 Posts/Week', 'Audience targeting', 'Bi-weekly Call']]
        ]
    ],
    [
        'name' => 'App Development',
        'slug' => 'app-development',
        'category' => 'Development',
        'short_description' => 'Build premium native and cross-platform mobile apps for iOS and Android. Custom engineered with offline support, secure databases, and smooth animations.',
        'packages' => [
            ['name' => 'Startup MVP App', 'price' => 1200, 'delivery_time' => '30 days', 'revisions' => '5 Rounds', 'features' => ['Single Platform', 'Basic Backend API', 'Splash Screen', 'UI/UX Design']],
            ['name' => 'Professional App', 'price' => 2499, 'delivery_time' => '60 days', 'revisions' => 'Unlimited', 'features' => ['iOS & Android cross-platform', 'Database synchronization', 'Push Notifications', 'Admin Portal']]
        ]
    ],
    [
        'name' => 'Meta Ads',
        'slug' => 'meta-ads',
        'category' => 'Advertising',
        'short_description' => 'Target and capture buyers on Facebook and Instagram. High-conversion ad design, targeted copywriting, pixel tracking setup, and campaign scale-up audits.',
        'packages' => [
            ['name' => 'Launch Meta Campaign', 'price' => 299, 'delivery_time' => '7 days', 'revisions' => '3 Rounds', 'features' => ['Ad Account Setup', 'Pixel integration', '2 Ad Creatives', '1 Week management']],
            ['name' => 'Scale Meta Campaign', 'price' => 599, 'delivery_time' => '15 days', 'revisions' => 'Unlimited', 'features' => ['Advanced A/B Testing', 'Custom Lookalike Audiences', '5 Ad Creatives', 'Monthly Retainer']]
        ]
    ],
    [
        'name' => 'Google Ads',
        'slug' => 'google-ads',
        'category' => 'Advertising',
        'short_description' => 'Rank at the top of Google searches instantly. Bid optimization, high-intent keyword research, negative key filtering, and landing page audit checks.',
        'packages' => [
            ['name' => 'Google Ads Setup', 'price' => 249, 'delivery_time' => '5 days', 'revisions' => '2 Rounds', 'features' => ['Campaign Strategy', 'Keyword research', 'Negative keyword filtering', 'Ad group structure']],
            ['name' => 'Premium PPC Scale', 'price' => 699, 'delivery_time' => '30 days', 'revisions' => 'Unlimited', 'features' => ['Lead Generation Focus', 'Bid Strategy Optimization', 'Competitor keyword hijacking', 'Weekly audit report']]
        ]
    ],
    [
        'name' => 'Custom Website',
        'slug' => 'custom-website',
        'category' => 'Development',
        'short_description' => 'Sleek, bespoke, speed-optimized corporate websites coded with Jamstack, Next.js or Laravel. Completely customizable interfaces built for speed and ROI.',
        'packages' => [
            ['name' => 'Bespoke corporate site', 'price' => 499, 'delivery_time' => '14 days', 'revisions' => '5 Rounds', 'features' => ['Unique UI mockup', 'Responsive layout', 'SEO setup', 'CMS Dashboard']],
            ['name' => 'Custom E-commerce Suite', 'price' => 1499, 'delivery_time' => '30 days', 'revisions' => 'Unlimited', 'features' => ['Tailored checkout portal', 'Payment Gateways Sync', 'Inventory Tracker', 'Admin Portal Dashboard']]
        ]
    ]
];

foreach ($newServices as $sData) {
    $service = Service::updateOrCreate(
        ['slug' => $sData['slug']],
        [
            'name' => $sData['name'],
            'category' => $sData['category'],
            'short_description' => $sData['short_description'],
            'is_active' => true,
            'pseo_enabled' => true,
            'pseo_slug_template' => '{service}-in-{city}',
            'pseo_title_template' => 'Best {service} in {city}, {state} | {brand_name}',
            'pseo_desc_template' => 'Looking for professional {service} in {city}? Contact {brand_name} for affordable, top-rated agency services in {city}, {state}.'
        ]
    );

    // Delete existing packages for these to prevent duplicates on rerun
    Package::where('service_id', $service->id)->delete();

    foreach ($sData['packages'] as $pData) {
        Package::create([
            'service_id' => $service->id,
            'name' => $pData['name'],
            'price' => $pData['price'],
            'original_price' => $pData['price'] * 1.25,
            'delivery_time' => $pData['delivery_time'],
            'revisions' => $pData['revisions'],
            'features' => $pData['features']
        ]);
    }
}

echo "New services and packages seeded successfully!\n";
