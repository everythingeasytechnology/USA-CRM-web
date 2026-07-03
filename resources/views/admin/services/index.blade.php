<x-layouts.admin active="services">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Services Management']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Services Management</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure company service listings, descriptions, categories, and SEO schemas.</p>
            </div>
            <div class="flex items-center gap-2.5">
                <x-admin.button variant="primary" size="sm" href="/admin/services/create">
                    <x-admin.icon name="plus" class="w-4 h-4" />
                    <span>Create Service</span>
                </x-admin.button>
            </div>
        </div>

        <!-- Filters & Bulk Actions -->
        <x-admin.card>
            <form method="GET" action="/admin/services" class="flex flex-wrap items-center justify-between gap-4">
                <!-- Search bar -->
                <div class="w-full sm:max-w-xs relative">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search services..."
                        class="w-full pl-9 pr-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg text-sm bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100"
                    />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-admin.icon name="search" class="w-4 h-4 text-slate-400" />
                    </div>
                </div>

                <!-- Category and status pickers -->
                <div class="flex items-center gap-2.5 flex-wrap">
                    <select name="category" class="text-xs bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg p-2 text-slate-700 dark:text-slate-300">
                        <option value="">All Categories</option>
                        @foreach (['web-dev' => 'Web Development', 'app-dev' => 'Mobile Application Development', 'digital-marketing' => 'Digital Marketing & Growth', 'seo-marketing' => 'SEO & Search Optimization', 'design-branding' => 'UI/UX Design & Branding', 'ai-automation' => 'AI Automation & Integration', 'cloud-hosting' => 'Cloud Hosting & Infrastructure', 'crm-erp' => 'Corporate CRM/ERP Solutions', 'strategy-consultancy' => 'Consultancy & Agency Strategy'] as $value => $label)
                            <option value="{{ $value }}" @selected(request('category') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <select name="status" class="text-xs bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg p-2 text-slate-700 dark:text-slate-300">
                        <option value="">All Statuses</option>
                        <option value="1" @selected(request('status') === '1')>Active / Published</option>
                        <option value="0" @selected(request('status') === '0')>Drafts / Disabled</option>
                    </select>
                    <x-admin.button type="submit" variant="secondary" size="sm">
                        <x-admin.icon name="filters" class="w-4 h-4" />
                        <span>Filter</span>
                    </x-admin.button>
                </div>
            </form>
        </x-admin.card>

        <!-- Services Table -->
        <x-admin.card :padding="false">
            <x-admin.table :headers="['Service Name', 'URL Slug', 'Category', 'Featured Image', 'Status', 'SEO Score', 'Actions']">
                @forelse ($services as $service)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-850/20 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-900 dark:text-white text-xs block leading-tight">{{ $service->name }}</span>
                            @if ($service->pseo_enabled)
                                <span class="inline-flex items-center gap-1.5 mt-1 text-[10px] text-blue-600 dark:text-blue-400 font-semibold bg-blue-50 dark:bg-blue-500/10 px-2 py-0.5 rounded-full border border-blue-150/10">
                                    <x-admin.icon name="seo" class="w-3 h-3" />
                                    <span>Programmatic Active</span>
                                </span>
                            @else
                                <span class="text-[10px] text-slate-400 block mt-0.5">Updated {{ $service->updated_at->diffForHumans() }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs font-mono text-slate-550 dark:text-slate-400">
                            /services/{{ $service->slug }}
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-700 dark:text-slate-300">
                            {{ $service->category }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($service->cover_image)
                                <img src="{{ asset($service->cover_image) }}" class="h-9 w-16 bg-slate-100 dark:bg-slate-800 rounded-md border border-slate-200 dark:border-slate-750 object-cover" />
                            @else
                                <div class="h-9 w-16 bg-slate-100 dark:bg-slate-800 rounded-md border border-slate-200 dark:border-slate-750 flex items-center justify-center text-[10px] text-slate-400 font-semibold uppercase">
                                    NO IMG
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <x-admin.toggle-form :action="'/admin/services/'.$service->id.'/toggle-active'" :active="$service->is_active" />
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-2xs font-bold font-mono bg-emerald-50 dark:bg-emerald-950/20 text-emerald-700 dark:text-emerald-400 border border-emerald-255/10">
                                95%
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                <x-admin.button variant="ghost" size="xs" href="/admin/services/{{ $service->id }}/edit" title="Edit Service">
                                    <x-admin.icon name="pencil" class="w-4 h-4 text-slate-500" />
                                </x-admin.button>
                                <form method="POST" action="/admin/services/{{ $service->id }}/duplicate">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center justify-center p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer" title="Duplicate Service">
                                        <x-admin.icon name="duplicate" class="w-4 h-4 text-slate-500" />
                                    </button>
                                </form>
                                <x-admin.delete-form :action="'/admin/services/'.$service->id" confirm="Delete this service permanently?">
                                    <button type="submit" class="inline-flex items-center justify-center p-1.5 rounded-lg text-red-500 hover:text-red-650 hover:bg-red-50 dark:hover:bg-red-950/30 cursor-pointer" title="Delete Service">
                                        <x-admin.icon name="trash" class="w-4 h-4" />
                                    </button>
                                </x-admin.delete-form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-xs text-slate-400">No services found.</td>
                    </tr>
                @endforelse
            </x-admin.table>

            <x-admin.pagination :currentPage="1" :totalPages="1" :totalResults="$services->count()" :perPage="max($services->count(), 1)" />
        </x-admin.card>
    </div>
</x-layouts.admin>
