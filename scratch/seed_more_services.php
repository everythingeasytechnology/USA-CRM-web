<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Service;
use App\Models\Package;

$newServices = [
    [
        'name' => 'WordPress Website Development',
        'slug' => 'wordpress-website-development',
        'category' => 'Development',
        'short_description' => 'Fast, secure, and SEO-friendly WordPress blogs, corporate sites, and WooCommerce stores. Custom themed and easy for non-technical users to edit.',
        'packages' => [
            ['name' => 'WordPress Starter', 'price' => 199, 'delivery_time' => '7 days', 'revisions' => '3 Rounds', 'features' => ['Elementor/Divi theme', '5 Key Pages', 'Contact form', 'SEO setup']],
            ['name' => 'Custom WooCommerce', 'price' => 499, 'delivery_time' => '20 days', 'revisions' => 'Unlimited', 'features' => ['WooCommerce Sync', 'Custom payment links', 'Product grid setup', 'Secure Admin access']]
        ]
    ],
    [
        'name' => 'Shopify Development',
        'slug' => 'shopify-development',
        'category' => 'Development',
        'short_description' => 'Launch your online retail storefront on Shopify. Custom theme designs, app configuration, cart optimization, and inventory integrations.',
        'packages' => [
            ['name' => 'Shopify Setup', 'price' => 299, 'delivery_time' => '10 days', 'revisions' => '5 Rounds', 'features' => ['Shopify Theme setup', 'Domain mapping', 'Up to 25 products', 'Payment links setup']],
            ['name' => 'Shopify Custom Store', 'price' => 899, 'delivery_time' => '25 days', 'revisions' => 'Unlimited', 'features' => ['Custom Liquid modifications', 'Third-party app sync', 'Speed audit optimization', 'On-page SEO setup']]
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

echo "WordPress and Shopify services seeded successfully!\n";
