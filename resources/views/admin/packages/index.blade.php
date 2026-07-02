<x-layouts.admin active="packages">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Pricing Packages']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Packages & Pricing</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure pricing packages, features checklist, discounts, and badges for each service.</p>
            </div>
            <div class="flex items-center gap-2.5">
                <x-admin.button variant="primary" size="sm" href="/admin/packages/create">
                    <x-admin.icon name="plus" class="w-4 h-4" />
                    <span>Create Package</span>
                </x-admin.button>
            </div>
        </div>

        <!-- Filters & Bulk Actions -->
        <x-admin.card>
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="w-full sm:max-w-xs relative">
                    <input 
                        type="text" 
                        placeholder="Search packages..." 
                        class="w-full pl-9 pr-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg text-sm bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100"
                    />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-admin.icon name="search" class="w-4 h-4 text-slate-400" />
                    </div>
                </div>

                <div class="flex items-center gap-2.5 flex-wrap">
                    <select class="text-xs bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg p-2 text-slate-700 dark:text-slate-300">
                        <option value="">All Services</option>
                        <option value="web-dev">Website Development</option>
                        <option value="seo">SEO Optimization</option>
                        <option value="app-dev">App Development</option>
                    </select>
                    <x-admin.button variant="secondary" size="sm">
                        <x-admin.icon name="filters" class="w-4 h-4" />
                        <span>Filter</span>
                    </x-admin.button>
                </div>
            </div>
        </x-admin.card>

        <!-- Packages Table -->
        <x-admin.card :padding="false">
            <x-admin.table :headers="['Package / Code', 'Related Service', 'Starting Price', 'Original Price', 'Badge', 'Status', 'Actions']">
                @php
                    $packages = \App\Models\Package::with('service')->get();
                @endphp

                @forelse ($packages as $pkg)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-850/20 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-900 dark:text-white text-xs block">{{ $pkg->name }}</span>
                            <span class="text-[10px] text-slate-400 block mt-0.5">Order index: {{ $loop->iteration }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs font-semibold text-slate-700 dark:text-slate-350">
                            {{ $pkg->service->name ?? 'Service' }}
                        </td>
                        <td class="px-6 py-4 text-xs font-mono font-bold text-slate-850 dark:text-slate-200">
                            ${{ number_format($pkg->price, 2) }}
                        </td>
                        <td class="px-6 py-4 text-xs font-mono text-slate-450 dark:text-slate-500 line-through">
                            {{ $pkg->original_price ? '$' . number_format($pkg->original_price, 2) : '—' }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($pkg->discount_price > 0)
                                <x-admin.badge variant="success">Sale</x-admin.badge>
                            @else
                                <span class="text-[10px] text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <x-admin.form.toggle name="pkg_active_{{ $loop->index }}" :value="true" />
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                <x-admin.button variant="ghost" size="xs" href="/admin/packages/create" title="Edit Package">
                                    <x-admin.icon name="pencil" class="w-4 h-4 text-slate-500" />
                                </x-admin.button>
                                <x-admin.button variant="ghost" size="xs" @click="alert('Package duplicated successfully!')" title="Duplicate Package">
                                    <x-admin.icon name="duplicate" class="w-4 h-4 text-slate-500" />
                                </x-admin.button>
                                <x-admin.button variant="ghost" size="xs" class="text-red-500 hover:text-red-650 hover:bg-red-50 dark:hover:bg-red-950/30" @click="alert('Delete Confirmation')" title="Delete Package">
                                    <x-admin.icon name="trash" class="w-4 h-4" />
                                </x-admin.button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-xs text-slate-400">
                            No packages created yet.
                        </td>
                    </tr>
                @endforelse
            </x-admin.table>
            
            <x-admin.pagination :currentPage="1" :totalPages="3" :totalResults="15" :perPage="5" />
        </x-admin.card>
    </div>
</x-layouts.admin>
