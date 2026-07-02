<x-layouts.admin active="pages">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Static Pages Layouts']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6" x-data="{ selectedPage: { name: '', route: '', title: '', desc: '', status: true } }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Static Pages Management</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure meta tags, hero banners, and active sitemap index parameters for core marketing pages.</p>
            </div>
        </div>

        <!-- Static pages layout logs -->
        <x-admin.card :padding="false">
            <x-admin.table :headers="['Page Name', 'Route Path', 'SEO Meta Title', 'SEO Score', 'Status', 'Actions']">
                @php
                    $staticPages = [
                        ['name' => 'Homepage Layout', 'route' => '/', 'title' => 'EverythingEasy | Enterprise software simple', 'score' => '94%', 'status' => true, 'desc' => 'Core landing marketing layout containing portfolio list, statistics, and email newsletters.'],
                        ['name' => 'About Us Roster', 'route' => '/about', 'title' => 'About EverythingEasy Agency Team', 'score' => '89%', 'status' => true, 'desc' => 'Company history, mission parameters, and executive profiles list.'],
                        ['name' => 'Contact Desk', 'route' => '/contact', 'title' => 'Get in Touch with support | everythingeasy', 'score' => '92%', 'status' => true, 'desc' => 'Office addresses, maps embeds, telephone, and quote fields.'],
                        ['name' => 'Frequently Asked FAQs', 'route' => '/faqs', 'title' => 'Service FAQs answers', 'score' => '81%', 'status' => true, 'desc' => 'Index details answering checkout queries.'],
                        ['name' => 'Careers Portal', 'route' => '/careers', 'title' => 'Join the everythingeasy Team', 'score' => '85%', 'status' => false, 'desc' => 'Open job listing posts.'],
                        ['name' => 'Maintenance Overlay', 'route' => '/maintenance', 'title' => 'System Maintenance Underway', 'score' => '—', 'status' => true, 'desc' => 'Lock screen showing public downtime alerts.'],
                    ];
                @endphp

                @foreach ($staticPages as $page)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-850/20 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-900 dark:text-white text-xs block leading-tight">{{ $page['name'] }}</span>
                            <span class="text-[9px] text-slate-400 block mt-0.5">Updated 1 week ago</span>
                        </td>
                        <td class="px-6 py-4 text-xs font-mono text-slate-650 dark:text-slate-400">
                            {{ $page['route'] }}
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-700 dark:text-slate-350 max-w-xs truncate">
                            {{ $page['title'] }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($page['score'] !== '—')
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-2xs font-bold font-mono bg-emerald-50 dark:bg-emerald-950/20 text-emerald-700 dark:text-emerald-400 border border-emerald-255/10">
                                    {{ $page['score'] }}
                                </span>
                            @else
                                <span class="text-xs text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <x-admin.form.toggle name="page_active_{{ $loop->index }}" :value="$page['status']" />
                        </td>
                        <td class="px-6 py-4">
                            <x-admin.button 
                                variant="secondary" 
                                size="xs"
                                @click="
                                    selectedPage = {
                                        name: '{{ $page['name'] }}',
                                        route: '{{ $page['route'] }}',
                                        title: '{{ $page['title'] }}',
                                        desc: '{{ $page['desc'] }}',
                                        status: {{ $page['status'] ? 'true' : 'false' }}
                                    };
                                    $dispatch('open-drawer', 'edit-page-drawer');
                                "
                            >
                                <x-admin.icon name="pencil" class="w-3.5 h-3.5 mr-1" />
                                <span>SEO Config</span>
                            </x-admin.button>
                        </td>
                    </tr>
                @endforeach
            </x-admin.table>
        </x-admin.card>

        <!-- Edit page slide-over drawer -->
        <x-admin.drawer name="edit-page-drawer" title="Static Page Page Builder">
            <div class="space-y-6">
                <!-- Page spec panel -->
                <div class="p-4 border border-slate-100 dark:border-slate-800 rounded-xl bg-slate-50/20 dark:bg-slate-900/10">
                    <span class="text-2xs font-semibold text-slate-500 uppercase block mb-1">Editing Layout</span>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white" x-text="selectedPage.name"></h3>
                    <span class="text-xs font-mono text-slate-500 mt-1 block" x-text="'Route path: ' + selectedPage.route"></span>
                </div>

                <div class="space-y-4">
                    <x-admin.form.input name="seo_meta_title" label="SEO Page Title" x-bind:value="selectedPage.title" :required="true" />
                    <x-admin.form.textarea name="seo_meta_desc" label="SEO Meta Description" placeholder="Keep under 160 characters..." :rows="3" />
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Hero Section Header Banner</label>
                        <div class="border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-lg p-5 text-center cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-850 transition-colors">
                            <x-admin.icon name="upload" class="w-8 h-8 text-slate-400 mx-auto" />
                            <span class="text-xs font-semibold text-slate-650 dark:text-slate-350 block mt-2">Upload Hero Background Asset</span>
                        </div>
                    </div>

                    <x-admin.form.textarea name="mock_content" label="HTML Content Blocks (Dummy)" x-bind:value="selectedPage.desc" :rows="4" />
                </div>
            </div>

            <x-slot:footer>
                <x-admin.button variant="primary" size="sm" @click="$dispatch('close-drawer')">Save Configuration</x-admin.button>
                <x-admin.button variant="secondary" size="sm" @click="$dispatch('close-drawer')">Cancel</x-admin.button>
            </x-slot:footer>
        </x-admin.drawer>

    </div>
</x-layouts.admin>
