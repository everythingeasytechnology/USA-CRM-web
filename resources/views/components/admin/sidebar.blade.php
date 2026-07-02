@props([
    'active' => 'dashboard'
])

@php
    $groups = [
        [
            'title' => 'Core',
            'items' => [
                ['name' => 'Dashboard', 'icon' => 'home', 'url' => '/admin', 'id' => 'dashboard'],
                ['name' => 'Media Library', 'icon' => 'media', 'url' => '/admin/media', 'id' => 'media'],
            ]
        ],
        [
            'title' => 'Operations',
            'items' => [
                ['name' => 'Lead Management', 'icon' => 'leads', 'url' => '/admin/leads', 'id' => 'leads', 'badge' => '12'],
                ['name' => 'Order Management', 'icon' => 'orders', 'url' => '/admin/orders', 'id' => 'orders', 'badge' => '3'],
                ['name' => 'Form Messages', 'icon' => 'messages', 'url' => '/admin/forms', 'id' => 'forms'],
            ]
        ],
        [
            'title' => 'Content Management',
            'items' => [
                ['name' => 'Services Management', 'icon' => 'packages', 'url' => '/admin/services', 'id' => 'services'],
                ['name' => 'Packages & Pricing', 'icon' => 'orders', 'url' => '/admin/packages', 'id' => 'packages'],
                ['name' => 'Package Add-ons', 'icon' => 'plus', 'url' => '/admin/addons', 'id' => 'addons'],
                ['name' => 'Blog Management', 'icon' => 'blogs', 'url' => '/admin/blogs', 'id' => 'blogs'],
                ['name' => 'Static Pages', 'icon' => 'pages', 'url' => '/admin/pages', 'id' => 'pages'],
                ['name' => 'Legal Pages', 'icon' => 'pages', 'url' => '/admin/legal', 'id' => 'legal'],
                ['name' => 'Careers Portal', 'icon' => 'users', 'url' => '/admin/careers', 'id' => 'careers'],
            ]
        ],
        [
            'title' => 'Growth & SEO',
            'items' => [
                ['name' => 'SEO Management', 'icon' => 'seo', 'url' => '/admin/seo', 'id' => 'seo'],
                ['name' => 'Testimonials', 'icon' => 'messages', 'url' => '/admin/testimonials', 'id' => 'testimonials'],
                ['name' => 'Team Members', 'icon' => 'users', 'url' => '/admin/team', 'id' => 'team'],
                ['name' => 'FAQ Manager', 'icon' => 'faq', 'url' => '/admin/faqs', 'id' => 'faqs'],
                ['name' => 'Newsletter List', 'icon' => 'bell', 'url' => '/admin/newsletter', 'id' => 'newsletter'],
                ['name' => 'Popups & Alerts', 'icon' => 'ai', 'url' => '/admin/popups', 'id' => 'popups'],
            ]
        ],
        [
            'title' => 'System & Settings',
            'items' => [
                ['name' => 'Website Settings', 'icon' => 'settings', 'url' => '/admin/settings', 'id' => 'settings'],
                ['name' => 'Social Links', 'icon' => 'share', 'url' => '/admin/social', 'id' => 'social'],
                ['name' => 'Payment Gateways', 'icon' => 'orders', 'url' => '/admin/payment', 'id' => 'payment'],
                ['name' => 'Users & Permissions', 'icon' => 'users', 'url' => '/admin/users', 'id' => 'users'],
                ['name' => 'System Control', 'icon' => 'sync', 'url' => '/admin/system', 'id' => 'system'],
            ]
        ]
    ];
@endphp

<div class="flex flex-col h-full bg-slate-900 border-r border-slate-800 text-slate-400 select-none">
    <!-- Brand Logo Section -->
    <div class="h-16 flex items-center justify-between px-6 border-b border-slate-800">
        <a href="/admin" class="flex items-center gap-2.5">
            <span class="h-8 w-8 rounded-lg bg-blue-600 dark:bg-blue-500 flex items-center justify-center text-white font-extrabold text-lg shadow-sm shadow-blue-500/30">
                A
            </span>
            <div class="flex flex-col">
                <span class="text-sm font-semibold text-white leading-tight">Anti Gravity</span>
                <span class="text-[10px] text-slate-500 leading-none">CMS Enterprise</span>
            </div>
        </a>
    </div>

    <!-- Scrollable Navigation Items -->
    <div class="flex-1 overflow-y-auto px-4 py-4 space-y-6">
        @foreach ($groups as $group)
            <div>
                <!-- Group Title Header -->
                <h4 class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest px-3 mb-2.5">
                    {{ $group['title'] }}
                </h4>
                
                <!-- Group List Links -->
                <nav class="space-y-1" aria-label="{{ $group['title'] }}">
                    @foreach ($group['items'] as $item)
                        @php
                            $isActive = $active === $item['id'];
                        @endphp
                        
                        <a 
                            href="{{ $item['url'] }}"
                            class="flex items-center justify-between px-3 py-2 text-sm font-medium rounded-lg transition-all duration-150 group cursor-pointer {{ $isActive 
                                ? 'bg-blue-600/10 text-blue-400 font-semibold' 
                                : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' 
                            }}"
                        >
                            <div class="flex items-center gap-3">
                                <x-admin.icon 
                                    name="{{ $item['icon'] }}" 
                                    class="w-5 h-5 flex-shrink-0 {{ $isActive ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-350' }}" 
                                />
                                <span>{{ $item['name'] }}</span>
                            </div>
                            
                            @if (isset($item['badge']))
                                <span class="px-2 py-0.5 text-2xs font-semibold rounded-full bg-slate-800 text-slate-300 group-hover:bg-slate-700">
                                    {{ $item['badge'] }}
                                </span>
                            @endif
                        </a>
                    @endforeach
                </nav>
            </div>
        @endforeach
    </div>

    <!-- User Profile Quick Bar at Bottom -->
    <div class="p-4 border-t border-slate-800 bg-slate-950/20">
        <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="h-9 w-9 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-300 font-semibold">
                    JD
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="text-xs font-semibold text-white truncate">John Doe</span>
                    <span class="text-[10px] text-slate-500 truncate">Super Admin</span>
                </div>
            </div>
            
            <a href="/admin/login" class="text-slate-500 hover:text-red-400 transition-colors p-1.5 rounded-lg hover:bg-slate-850 cursor-pointer" title="Sign Out">
                <x-admin.icon name="logout" class="w-4 h-4" />
            </a>
        </div>
    </div>
</div>
