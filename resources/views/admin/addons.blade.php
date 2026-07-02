<x-layouts.admin active="addons">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Package Add-ons']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6" x-data="{ openCreateModal: false }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Package Add-ons</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure optional add-ons that clients can select during order checkouts.</p>
            </div>
            <div class="flex items-center gap-2.5">
                <x-admin.button variant="primary" size="sm" @click="$dispatch('open-modal', 'addon-modal')">
                    <x-admin.icon name="plus" class="w-4 h-4" />
                    <span>Create Add-on</span>
                </x-admin.button>
            </div>
        </div>

        <!-- Add-ons Listing Card -->
        <x-admin.card :padding="false">
            <x-admin.table :headers="['Add-on Name', 'Price', 'Description', 'Sort Order', 'Status', 'Actions']">
                @php
                    $addons = \App\Models\Addon::all();
                @endphp

                @forelse ($addons as $addon)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-850/20 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-900 dark:text-white text-xs block">{{ $addon->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs font-mono font-bold text-slate-850 dark:text-slate-200">
                            ${{ number_format($addon->price, 2) }}
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-550 dark:text-slate-400 max-w-sm truncate">
                            Checkout addon item.
                        </td>
                        <td class="px-6 py-4 text-xs font-mono text-slate-650 dark:text-slate-455">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4">
                            <x-admin.form.toggle name="addon_status_{{ $loop->index }}" :value="$addon->is_active" />
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                <x-admin.button variant="ghost" size="xs" @click="$dispatch('open-modal', 'addon-modal')" title="Edit Add-on">
                                    <x-admin.icon name="pencil" class="w-4 h-4 text-slate-500" />
                                </x-admin.button>
                                <x-admin.button variant="ghost" size="xs" class="text-red-500 hover:text-red-650 hover:bg-red-50 dark:hover:bg-red-950/30" @click="alert('Delete Confirmation')" title="Delete Add-on">
                                    <x-admin.icon name="trash" class="w-4 h-4" />
                                </x-admin.button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-xs text-slate-400">
                            No checkout addons configured yet.
                        </td>
                    </tr>
                @endforelse
            </x-admin.table>
            
            <x-admin.pagination :currentPage="1" :totalPages="2" :totalResults="10" :perPage="5" />
        </x-admin.card>

        <!-- Create/Edit Modal Component -->
        <x-admin.modal name="addon-modal" title="Manage Checkout Add-on" maxW="md">
            <form action="#save-addon" class="space-y-4" @submit.prevent="$dispatch('close-modal')">
                <x-admin.form.input name="addon_title" label="Add-on Name" placeholder="e.g. Dedicated VPS Hosting Setup" :required="true" />
                
                <div class="grid grid-cols-2 gap-4">
                    <x-admin.form.input name="addon_price" label="Billing Price" placeholder="e.g. $99 or $49/mo" :required="true" />
                    <x-admin.form.input name="addon_sort" label="Display Order" type="number" value="1" />
                </div>
                
                <x-admin.form.textarea name="addon_desc" label="Brief Description" placeholder="Explain what is included in this add-on..." :rows="3" />
                
                <div class="flex items-center gap-3">
                    <x-admin.form.toggle name="addon_status_active" label="Enabled / Visible" :value="true" />
                </div>
                
                <x-slot:footer>
                    <x-admin.button type="submit" variant="primary" size="sm">Save Add-on</x-admin.button>
                    <x-admin.button type="button" variant="secondary" size="sm" @click="$dispatch('close-modal')">Cancel</x-admin.button>
                </x-slot:footer>
            </form>
        </x-admin.modal>
    </div>
</x-layouts.admin>
