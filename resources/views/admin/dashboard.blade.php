<x-layouts.admin active="dashboard">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Dashboard Overview']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6 select-text" x-data="{ 
        maintenanceMode: false,
        cacheCleared: false,
        selectedLead: {
            name: '', email: '', phone: '', service: '', budget: '', country: '', status: '', source: '', notes: ''
        }
    }">
        
        <!-- Header Actions Banner -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">CMS Dashboard</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage company services, portfolios, leads, blogs, and SEO from one place.</p>
            </div>
            <div class="flex items-center gap-2.5">
                <x-admin.button variant="secondary" size="sm">
                    <x-admin.icon name="sync" class="w-4 h-4" />
                    <span>Refresh</span>
                </x-admin.button>
                <x-admin.button variant="primary" size="sm" @click="$dispatch('open-modal', 'quick-service-modal')">
                    <x-admin.icon name="plus" class="w-4 h-4" />
                    <span>New Service</span>
                </x-admin.button>
            </div>
        </div>

        <!-- Success Toast for Demo Alerts -->
        <div 
            x-show="cacheCleared" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed bottom-4 right-4 z-50 max-w-sm"
            style="display: none;"
        >
            <x-admin.alert variant="success" title="System Cache Cleared" :dismissible="true">
                The application cache has been flushed successfully. Front-end changes are now live.
            </x-admin.alert>
        </div>

        <!-- Metrics Stats Grid -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
            
            <!-- Stat: Leads -->
            <x-admin.card :padding="true" class="relative group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Leads</span>
                    <span class="p-1.5 rounded-lg bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-455">
                        <x-admin.icon name="leads" class="w-5 h-5" />
                    </span>
                </div>
                <div class="mt-4">
                    <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ \App\Models\Lead::count() }}</span>
                    <div class="flex items-center gap-1 mt-1 text-emerald-600 dark:text-emerald-500">
                        <x-admin.icon name="trend-up" class="w-3.5 h-3.5" />
                        <span class="text-2xs font-bold font-mono">+12.5%</span>
                    </div>
                </div>
            </x-admin.card>

            <!-- Stat: Services -->
            <x-admin.card :padding="true">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Services</span>
                    <span class="p-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-650 dark:text-slate-350">
                        <x-admin.icon name="media" class="w-5 h-5" />
                    </span>
                </div>
                <div class="mt-4">
                    <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ \App\Models\Service::count() }}</span>
                    <p class="text-2xs text-slate-450 dark:text-slate-500 mt-1">core categories</p>
                </div>
            </x-admin.card>

            <!-- Stat: Packages -->
            <x-admin.card :padding="true">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Packages</span>
                    <span class="p-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-650 dark:text-slate-350">
                        <x-admin.icon name="orders" class="w-5 h-5" />
                    </span>
                </div>
                <div class="mt-4">
                    <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ \App\Models\Package::count() }}</span>
                    <p class="text-2xs text-slate-450 dark:text-slate-500 mt-1">pricing bundles</p>
                </div>
            </x-admin.card>

            <!-- Stat: Blogs -->
            <x-admin.card :padding="true">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Blogs Published</span>
                    <span class="p-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-650 dark:text-slate-350">
                        <x-admin.icon name="blogs" class="w-5 h-5" />
                    </span>
                </div>
                <div class="mt-4">
                    <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ \App\Models\Blog::count() }}</span>
                    <div class="flex items-center gap-1 mt-1 text-slate-500 dark:text-slate-500 text-2xs">
                        <span>articles</span>
                    </div>
                </div>
            </x-admin.card>

            <!-- Stat: SEO Score -->
            <x-admin.card :padding="true" class="border-l-4 border-l-emerald-500">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">SEO Score</span>
                    <span class="p-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-450">
                        <x-admin.icon name="seo" class="w-5 h-5" />
                    </span>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="text-2xl font-bold text-slate-900 dark:text-white">92</span>
                    <span class="text-xs text-slate-400">/ 100</span>
                    <span class="ml-auto inline-flex items-center rounded-full bg-emerald-50 dark:bg-emerald-950/30 px-1.5 py-0.5 text-3xs font-bold text-emerald-700 dark:text-emerald-400">Excellent</span>
                </div>
            </x-admin.card>

            <!-- Stat: Revenue -->
            <x-admin.card :padding="true">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Revenue (Est.)</span>
                    <span class="p-1.5 rounded-lg bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-450">
                        <x-admin.icon name="orders" class="w-5 h-5" />
                    </span>
                </div>
                <div class="mt-4">
                    <span class="text-2xl font-bold text-slate-900 dark:text-white">${{ number_format(\App\Models\Order::where('status', 'paid')->sum('amount')) }}</span>
                    <div class="flex items-center gap-1 mt-1 text-emerald-600 dark:text-emerald-500">
                        <x-admin.icon name="trend-up" class="w-3.5 h-3.5" />
                        <span class="text-2xs font-bold font-mono">+8.2%</span>
                    </div>
                </div>
            </x-admin.card>

        </div>

        <!-- Charts Layout Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Chart: Website Visitors -->
            <div class="lg:col-span-2">
                <x-admin.card title="Website Visitors (Monthly)" subtitle="Visual representation of desktop and mobile unique traffic metrics.">
                    <div class="h-80 w-full relative">
                        <canvas id="visitors-chart"></canvas>
                    </div>
                </x-admin.card>
            </div>

            <!-- Chart: Leads Breakdown or Revenue Sources -->
            <div>
                <x-admin.card title="Lead Service Sources" subtitle="Breakdown of interest per service package.">
                    <div class="h-80 w-full relative flex items-center justify-center">
                        <canvas id="leads-breakdown-chart"></canvas>
                    </div>
                </x-admin.card>
            </div>

        </div>

        <!-- Quick System Control and Actions Panel -->
        <x-admin.card title="Quick Actions" subtitle="One-tap actions for system state toggles and optimizations.">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- Action: Clear Cache -->
                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/40 dark:bg-slate-900/10">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 rounded-lg">
                            <x-admin.icon name="cache" class="w-5 h-5" />
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-slate-900 dark:text-white block">Application Cache</span>
                            <span class="text-[10px] text-slate-550 dark:text-slate-500 block mt-0.5">Flush view/route caches</span>
                        </div>
                    </div>
                    <x-admin.button 
                        variant="secondary" 
                        size="xs" 
                        @click="cacheCleared = true; setTimeout(() => cacheCleared = false, 4000)"
                    >
                        Flush
                    </x-admin.button>
                </div>

                <!-- Action: Maintenance Mode Toggle -->
                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/40 dark:bg-slate-900/10">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-lg">
                            <x-admin.icon name="warning" class="w-5 h-5" />
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-slate-900 dark:text-white block">Maintenance Mode</span>
                            <span class="text-[10px] text-slate-550 dark:text-slate-500 block mt-0.5" x-text="maintenanceMode ? 'Public site is OFFLINE' : 'Public site is ONLINE'">ONLINE</span>
                        </div>
                    </div>
                    <div x-data="{ on: false }">
                        <input type="hidden" name="maintenance" :value="on ? '1' : '0'" />
                        <button 
                            type="button" 
                            @click="on = !on; maintenanceMode = on" 
                            :class="on ? 'bg-red-600' : 'bg-slate-200 dark:bg-slate-800'"
                            class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                        >
                            <span 
                                :class="on ? 'translate-x-4' : 'translate-x-0'"
                                class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow-xs transition duration-200 ease-in-out"
                            ></span>
                        </button>
                    </div>
                </div>

                <!-- Action: Sitemap Generator -->
                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/40 dark:bg-slate-900/10">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-lg">
                            <x-admin.icon name="seo" class="w-5 h-5" />
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-slate-900 dark:text-white block">XML & HTML Sitemap</span>
                            <span class="text-[10px] text-slate-550 dark:text-slate-500 block mt-0.5">Auto generated weekly</span>
                        </div>
                    </div>
                    <x-admin.button variant="secondary" size="xs">
                        Build
                    </x-admin.button>
                </div>

                <!-- Action: System Backups -->
                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/40 dark:bg-slate-900/10">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 rounded-lg">
                            <x-admin.icon name="settings" class="w-5 h-5" />
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-slate-900 dark:text-white block">Full Database Backup</span>
                            <span class="text-[10px] text-slate-550 dark:text-slate-500 block mt-0.5">Last copy: 12h ago</span>
                        </div>
                    </div>
                    <x-admin.button variant="secondary" size="xs">
                        Run
                    </x-admin.button>
                </div>

            </div>
        </x-admin.card>

        <!-- Main Dashboard Data Section: Recent Leads and Blog Posts -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            
            <!-- Left Panel (2 cols): Recent Leads Table -->
            <div class="xl:col-span-2">
                <x-admin.card title="Recent Leads" subtitle="Latest inquiries matching service forms. Click any row to open slide drawer.">
                    <x-slot:actions>
                        <x-admin.button variant="secondary" size="xs">
                            <x-admin.icon name="adjustments-horizontal" class="w-4 h-4" />
                            <span>Filter</span>
                        </x-admin.button>
                        <x-admin.button variant="secondary" size="xs">
                            Export CSV
                        </x-admin.button>
                    </x-slot:actions>
                    
                    <x-admin.table :headers="['Client / Contact', 'Service Requested', 'Budget', 'Origin', 'Status', 'Actions']">
                        @php
                            $recentLeads = \App\Models\Lead::latest()->take(5)->get();
                        @endphp
                        
                        @forelse ($recentLeads as $lead)
                            <tr 
                                class="hover:bg-slate-50/80 dark:hover:bg-slate-850/30 transition-colors cursor-pointer group"
                                @click="
                                    selectedLead = {
                                        name: '{{ addslashes($lead->name) }}',
                                        email: '{{ addslashes($lead->email) }}',
                                        phone: '{{ addslashes($lead->phone) }}',
                                        service: '{{ addslashes($lead->service_requested) }}',
                                        budget: '{{ addslashes($lead->budget) }}',
                                        country: '{{ addslashes($lead->country) }}',
                                        status: '{{ addslashes($lead->status) }}',
                                        source: '{{ addslashes($lead->source) }}',
                                        notes: '{{ addslashes($lead->notes) }}'
                                    };
                                    $dispatch('open-drawer', 'lead-drawer');
                                "
                            >
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-900 dark:text-white text-xs">{{ $lead->name }}</div>
                                    <div class="text-[10px] text-slate-550 dark:text-slate-400 font-mono mt-0.5">{{ $lead->email }}</div>
                                    <div class="text-[10px] text-slate-450 font-mono mt-0.5">{{ $lead->phone }}</div>
                                </td>
                                <td class="px-6 py-4 text-xs font-medium text-slate-700 dark:text-slate-300">
                                    {{ $lead->service_requested }}
                                </td>
                                <td class="px-6 py-4 text-xs font-mono font-bold text-slate-800 dark:text-slate-200">
                                    {{ $lead->budget }}
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500 dark:text-slate-400">
                                    {{ $lead->source }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($lead->status === 'new')
                                        <x-admin.badge variant="info">New Enquiry</x-admin.badge>
                                    @elseif ($lead->status === 'in_discussion')
                                        <x-admin.badge variant="warning">In Discussion</x-admin.badge>
                                    @elseif ($lead->status === 'pending')
                                        <x-admin.badge variant="warning">Pending</x-admin.badge>
                                    @elseif ($lead->status === 'completed')
                                        <x-admin.badge variant="success">Completed</x-admin.badge>
                                    @elseif ($lead->status === 'fake')
                                        <x-admin.badge variant="danger">Fake / Spam</x-admin.badge>
                                    @else
                                        <x-admin.badge variant="neutral">{{ $lead->status }}</x-admin.badge>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <x-admin.button variant="ghost" size="xs" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                        <x-admin.icon name="eye" class="w-4 h-4" />
                                    </x-admin.button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-xs text-slate-400">
                                    No sales leads recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </x-admin.table>
                    
                    <x-admin.pagination :currentPage="1" :totalPages="10" :totalResults="100" :perPage="4" />
                </x-admin.card>
            </div>

            <!-- Right Panel (1 col): Recent Blog Posts / Status Toggles -->
            <div>
                <x-admin.card title="Recent Blog Posts" subtitle="Manage status indexation in search consoles.">
                    <x-slot:actions>
                        <x-admin.button variant="ghost" size="xs">
                            View All
                        </x-admin.button>
                    </x-slot:actions>

                    <div class="space-y-4">
                        @php
                            $recentBlogs = \App\Models\Blog::latest()->take(3)->get();
                        @endphp
                        
                        @forelse ($recentBlogs as $blog)
                            <div class="p-3.5 border border-slate-100 dark:border-slate-800 rounded-xl flex items-center justify-between gap-3 bg-slate-50/20 dark:bg-slate-900/10">
                                <div class="min-w-0">
                                    <span class="text-2xs font-semibold text-blue-600 dark:text-blue-400 block mb-0.5">{{ $blog->category }}</span>
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ $blog->title }}</h4>
                                    <span class="text-[10px] text-slate-550 mt-1 block">Read time: {{ $blog->read_time }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-admin.button 
                                        variant="ghost" 
                                        size="xs" 
                                        class="text-red-500 hover:bg-red-50 hover:text-red-700 dark:hover:bg-red-950/20 cursor-pointer"
                                        @click="alert('Delete blog triggered')"
                                    >
                                        <x-admin.icon name="trash" class="w-4.5 h-4.5" />
                                    </x-admin.button>
                                </div>
                            </div>
                        @empty
                            <div class="text-xs text-slate-400 text-center py-8">
                                No blog posts created yet.
                            </div>
                        @endforelse
                    </div>
                </x-admin.card>

                <!-- Activity Feed timeline widget -->
                <x-admin.card title="Recent Activity" subtitle="Updates from Anti Gravity CMS background logs." class="mt-6">
                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            <!-- Timeline node -->
                            <li class="relative pb-6">
                                <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-slate-200 dark:bg-slate-800" aria-hidden="true"></span>
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center text-blue-600 ring-4 ring-white dark:ring-slate-900">
                                            <x-admin.icon name="seo" class="w-4 h-4" />
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0 pt-1.5">
                                        <p class="text-xs text-slate-600 dark:text-slate-400">
                                            Auto Sitemap generated & index request dispatched to <a href="#seo" class="font-semibold text-blue-600 hover:underline">Google Console</a>.
                                        </p>
                                        <span class="text-3xs text-slate-400 mt-1 block">3 hours ago</span>
                                    </div>
                                </div>
                            </li>

                            <!-- Timeline node -->
                            <li class="relative pb-6">
                                <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-slate-200 dark:bg-slate-800" aria-hidden="true"></span>
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-600 ring-4 ring-white dark:ring-slate-900">
                                            <x-admin.icon name="orders" class="w-4 h-4" />
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0 pt-1.5">
                                        <p class="text-xs text-slate-600 dark:text-slate-400">
                                            Order invoice generated for Stripe checkout ID <code class="font-mono text-slate-900 dark:text-slate-200 text-3xs bg-slate-100 dark:bg-slate-800 px-1 py-0.5 rounded-sm">#inv_908a2</code>.
                                        </p>
                                        <span class="text-3xs text-slate-400 mt-1 block">5 hours ago</span>
                                    </div>
                                </div>
                            </li>

                            <!-- Timeline node -->
                            <li class="relative pb-2">
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 ring-4 ring-white dark:ring-slate-900">
                                            <x-admin.icon name="users" class="w-4 h-4" />
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0 pt-1.5">
                                        <p class="text-xs text-slate-600 dark:text-slate-400">
                                            Role permission level modified for Editor to support XML robots editor.
                                        </p>
                                        <span class="text-3xs text-slate-400 mt-1 block">1 day ago</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </x-admin.card>
            </div>

        </div>

        <!-- Confirm Delete Post Modal (Demo Modal) -->
        <x-admin.modal name="confirm-delete-modal" title="Delete Post Confirmation">
            <div class="text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-500/10 text-red-600 dark:text-red-400">
                    <x-admin.icon name="trash" class="w-6 h-6" />
                </div>
                <h3 class="mt-4 text-base font-bold text-slate-900 dark:text-white">Are you absolutely sure?</h3>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">This action cannot be undone. The selected blog post will be permanently deleted from the database and sitemap nodes.</p>
            </div>
            <x-slot:footer>
                <x-admin.button variant="danger" size="sm" @click="$dispatch('close-modal')">Yes, Delete</x-admin.button>
                <x-admin.button variant="secondary" size="sm" @click="$dispatch('close-modal')">Cancel</x-admin.button>
            </x-slot:footer>
        </x-admin.modal>

        <!-- Create Service Modal Form (Demo Form Modal) -->
        <x-admin.modal name="quick-service-modal" title="Create New CMS Service" maxW="xl">
            <form action="#create-service" class="space-y-4" @submit.prevent="$dispatch('close-modal')">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-admin.form.input name="service_name" label="Service Name" placeholder="e.g. Website Development" :required="true" />
                    <x-admin.form.input name="service_slug" label="Slug URL" placeholder="e.g. website-development" :required="true" help="Unique identifier for service URLs" />
                </div>
                
                <x-admin.form.select name="service_category" label="Service Category" placeholder="Select a Category..." :required="true">
                    <option value="development">Web Development</option>
                    <option value="seo">SEO & Marketing</option>
                    <option value="branding">Branding & Graphic Design</option>
                    <option value="consultancy">Consultancy & Strategy</option>
                </x-admin.form.select>
                
                <x-admin.form.textarea name="service_desc" label="Short Description" placeholder="Explain the service benefits briefly in 2-3 lines..." :rows="3" :required="true" />
                
                <div class="border-t border-slate-200 dark:border-slate-800 pt-4">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-3">SEO Optimization (Optional)</span>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-admin.form.input name="seo_title" label="Meta SEO Title" placeholder="e.g. Custom Web Development Packages" />
                        <x-admin.form.input name="canonical" label="Canonical URL Override" placeholder="e.g. https://everythingeasy.in/services" />
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-2">
                    <x-admin.form.toggle name="is_featured" label="Featured Service" help="Display highlighted on home landing page cards." />
                    <x-admin.form.toggle name="is_active" label="Publish Instantly" :value="true" help="Immediately enable sitemap links and public visibility." />
                </div>
                
                <x-slot:footer>
                    <x-admin.button type="submit" variant="primary" size="sm">Create Service</x-admin.button>
                    <x-admin.button type="button" variant="secondary" size="sm" @click="$dispatch('close-modal')">Cancel</x-admin.button>
                </x-slot:footer>
            </form>
        </x-admin.modal>

        <!-- Lead Info Slide-over Details Drawer (Demo Drawer) -->
        <x-admin.drawer name="lead-drawer" title="Lead Enquiry Details" maxW="lg">
            <div class="space-y-6">
                <!-- Contact info panel -->
                <div class="p-4 border border-slate-100 dark:border-slate-800 rounded-xl bg-slate-50/20 dark:bg-slate-900/10">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-full bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-lg" x-text="selectedLead.name.split(' ').map(n=>n[0]).join('')">
                            AG
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white" x-text="selectedLead.name">Akhil Golu</h3>
                            <span class="text-2xs text-slate-550 dark:text-slate-400" x-text="selectedLead.email">akhil@everythingeasy.in</span>
                        </div>
                    </div>
                    <div class="mt-4 grid grid-cols-2 gap-3 text-xs border-t border-slate-100 dark:border-slate-800 pt-3">
                        <div>
                            <span class="text-slate-500 block">Phone</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200" x-text="selectedLead.phone">+91 98765 43210</span>
                        </div>
                        <div>
                            <span class="text-slate-500 block">Country</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200" x-text="selectedLead.country">India 🇮🇳</span>
                        </div>
                    </div>
                </div>

                <!-- Inquiry specs -->
                <div class="space-y-4">
                    <div>
                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">Service Requested</span>
                        <div class="p-3 border border-slate-200 dark:border-slate-800 rounded-lg text-sm bg-white dark:bg-slate-900 text-slate-850 dark:text-slate-200" x-text="selectedLead.service">
                            Web Development & CMS Setup
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">Declared Budget</span>
                            <div class="p-3 border border-slate-200 dark:border-slate-800 rounded-lg text-sm bg-white dark:bg-slate-900 font-mono font-bold text-slate-850 dark:text-slate-200" x-text="selectedLead.budget">
                                $5,000 - $8,000
                            </div>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">Inquiry Source</span>
                            <div class="p-3 border border-slate-200 dark:border-slate-800 rounded-lg text-sm bg-white dark:bg-slate-900 text-slate-850 dark:text-slate-200" x-text="selectedLead.source">
                                Package Form
                            </div>
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">Custom Notes / Requirements</span>
                        <div class="p-3 border border-slate-200 dark:border-slate-800 rounded-lg text-xs bg-slate-50/50 dark:bg-slate-900/50 text-slate-700 dark:text-slate-300 leading-relaxed" x-text="selectedLead.notes">
                            No special requirements.
                        </div>
                    </div>
                </div>

                <!-- Assignment/Status select tools -->
                <div class="border-t border-slate-200 dark:border-slate-800 pt-4">
                    <span class="text-xs font-semibold text-slate-500 uppercase block mb-3">Staff Assignment & Status</span>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-admin.form.select name="lead_status_update" label="Lead Status" placeholder="Select status...">
                            <option value="new">New Enquiry</option>
                            <option value="in_discussion">In Discussion</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="fake">Fake / Spam</option>
                            <option value="lost">Lost / Archived</option>
                        </x-admin.form.select>
                        <x-admin.form.select name="staff_assignment" label="Assign Staff Member" placeholder="Unassigned...">
                            <option value="sales1">Sarah Connor (Sales Lead)</option>
                            <option value="sales2">Diana Prince (Key Accounts)</option>
                            <option value="writer">Akhil Golu (Arch Lead)</option>
                        </x-admin.form.select>
                    </div>
                </div>
            </div>
            
            <x-slot:footer>
                <x-admin.button variant="primary" size="sm" @click="$dispatch('close-drawer')">Save Updates</x-admin.button>
                <x-admin.button variant="secondary" size="sm" @click="$dispatch('close-drawer')">Close</x-admin.button>
            </x-slot:footer>
        </x-admin.drawer>

    </div>

    <!-- Chart.js Visualization Integrator Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const initCharts = () => {
                if (typeof window.Chart === 'undefined') {
                    setTimeout(initCharts, 100);
                    return;
                }

                // Global charts configuration defaults
                Chart.defaults.font.family = 'Inter, sans-serif';
                Chart.defaults.color = document.documentElement.classList.contains('dark') ? '#94a3b8' : '#64748b';
                
                // Chart 1: Website Visitors (Line Graph)
                const ctx1 = document.getElementById('visitors-chart');
                if (ctx1) {
                    const gradient1 = ctx1.getContext('2d').createLinearGradient(0, 0, 0, 300);
                    gradient1.addColorStop(0, 'rgba(37, 99, 235, 0.22)');
                    gradient1.addColorStop(1, 'rgba(37, 99, 235, 0.01)');

                    const gradient2 = ctx1.getContext('2d').createLinearGradient(0, 0, 0, 300);
                    gradient2.addColorStop(0, 'rgba(148, 163, 184, 0.15)');
                    gradient2.addColorStop(1, 'rgba(148, 163, 184, 0.01)');

                    new Chart(ctx1, {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            datasets: [
                                {
                                    label: 'Unique Visitors',
                                    data: [14200, 16500, 15100, 18200, 21400, 24600, 23200, 26900, 28100, 27500, 31000, 34500],
                                    borderColor: '#2563eb',
                                    borderWidth: 2,
                                    fill: true,
                                    backgroundColor: gradient1,
                                    tension: 0.35,
                                    pointRadius: 3,
                                    pointHoverRadius: 6,
                                },
                                {
                                    label: 'Bounce Sessions',
                                    data: [5200, 6100, 5800, 7200, 8100, 9300, 8900, 10200, 10800, 9800, 11400, 12100],
                                    borderColor: '#94a3b8',
                                    borderWidth: 1.5,
                                    borderDash: [5, 5],
                                    fill: true,
                                    backgroundColor: gradient2,
                                    tension: 0.35,
                                    pointRadius: 0,
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        boxWidth: 12,
                                        usePointStyle: true,
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    grid: {
                                        color: document.documentElement.classList.contains('dark') ? 'rgba(51, 65, 85, 0.3)' : 'rgba(226, 232, 240, 0.8)',
                                    },
                                    border: {
                                        dash: [5, 5]
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                }

                // Chart 2: Lead Sources (Bar Chart / Doughnut)
                const ctx2 = document.getElementById('leads-breakdown-chart');
                if (ctx2) {
                    @php
                        $webDevChartCount = \App\Models\Lead::where('service_requested', 'like', '%Web%')->count();
                        $seoChartCount = \App\Models\Lead::where('service_requested', 'like', '%SEO%')->count();
                        $brandingChartCount = \App\Models\Lead::where('service_requested', 'like', '%Brand%')->orWhere('service_requested', 'like', '%Design%')->count();
                        $aiChartCount = \App\Models\Lead::where('service_requested', 'like', '%AI%')->orWhere('service_requested', 'like', '%Automation%')->count();
                    @endphp
                    new Chart(ctx2, {
                        type: 'doughnut',
                        data: {
                            labels: ['Web Dev', 'SEO Optim', 'Branding', 'AI Automation'],
                            datasets: [{
                                label: 'Enquiries Count',
                                data: [{{ $webDevChartCount }}, {{ $seoChartCount }}, {{ $brandingChartCount }}, {{ $aiChartCount }}],
                                backgroundColor: [
                                    '#2563eb', // Web Dev (blue)
                                    '#3b82f6', // SEO (light blue)
                                    '#60a5fa', // Branding (sky blue)
                                    '#93c5fd'  // AI (soft blue)
                                ],
                                borderHoverWidth: 0,
                                borderWidth: 4,
                                borderColor: document.documentElement.classList.contains('dark') ? '#0f172a' : '#ffffff',
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        boxWidth: 8,
                                        usePointStyle: true,
                                        padding: 15
                                    }
                                }
                            },
                            cutout: '72%'
                        }
                    });
                }
            };
            
            // Trigger load check
            initCharts();
            
            // Watch dark mode trigger events to update chart grid/label colors automatically
            window.addEventListener('click', () => {
                setTimeout(() => {
                    const isDark = document.documentElement.classList.contains('dark');
                    Chart.defaults.color = isDark ? '#94a3b8' : '#64748b';
                }, 10);
            });
        });
    </script>
</x-layouts.admin>
