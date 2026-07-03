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
                <x-admin.button variant="primary" size="sm" @click="$dispatch('open-modal', 'addon-create-modal')">
                    <x-admin.icon name="plus" class="w-4 h-4" />
                    <span>Create Add-on</span>
                </x-admin.button>
            </div>
        </div>

        <!-- Add-ons Listing Card -->
        <x-admin.card :padding="false">
            <x-admin.table :headers="['Add-on Name', 'Price', 'Description', 'Sort Order', 'Status', 'Actions']">
                @forelse ($addons as $addon)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-850/20 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-900 dark:text-white text-xs block">{{ $addon->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs font-mono font-bold text-slate-850 dark:text-slate-200">
                            ${{ number_format($addon->price, 2) }}
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-550 dark:text-slate-400 max-w-sm truncate">
                            {{ $addon->description ?: 'Checkout addon item.' }}
                        </td>
                        <td class="px-6 py-4 text-xs font-mono text-slate-650 dark:text-slate-455">
                            {{ $addon->sort_order }}
                        </td>
                        <td class="px-6 py-4">
                            <x-admin.toggle-form :action="'/admin/addons/'.$addon->id.'/toggle-active'" :active="$addon->is_active" />
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                <x-admin.button variant="ghost" size="xs" @click="$dispatch('open-modal', 'addon-edit-modal-{{ $addon->id }}')" title="Edit Add-on">
                                    <x-admin.icon name="pencil" class="w-4 h-4 text-slate-500" />
                                </x-admin.button>
                                <x-admin.delete-form :action="'/admin/addons/'.$addon->id" confirm="Delete this add-on permanently?">
                                    <button type="submit" class="inline-flex items-center justify-center p-1.5 rounded-lg text-red-500 hover:text-red-650 hover:bg-red-50 dark:hover:bg-red-950/30 cursor-pointer" title="Delete Add-on">
                                        <x-admin.icon name="trash" class="w-4 h-4" />
                                    </button>
                                </x-admin.delete-form>
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

            <x-admin.pagination :currentPage="1" :totalPages="1" :totalResults="$addons->count()" :perPage="max($addons->count(), 1)" />
        </x-admin.card>

        <!-- Create Modal -->
        <x-admin.modal name="addon-create-modal" title="Create Checkout Add-on" maxW="md">
            <form id="addon-create-form" action="/admin/addons" method="POST" class="space-y-4">
                @csrf
                <x-admin.form.input name="name" label="Add-on Name" placeholder="e.g. Dedicated VPS Hosting Setup" :required="true" />

                <div class="grid grid-cols-2 gap-4">
                    <x-admin.form.input name="price" label="Billing Price ($)" type="number" placeholder="e.g. 99" :required="true" />
                    <x-admin.form.input name="sort_order" label="Display Order" type="number" value="1" />
                </div>

                <x-admin.form.textarea name="description" label="Brief Description" placeholder="Explain what is included in this add-on..." :rows="3" />

                <div class="flex items-center gap-3">
                    <x-admin.form.toggle name="is_active" label="Enabled / Visible" :value="true" />
                </div>
            </form>
            <x-slot:footer>
                <x-admin.button type="submit" form="addon-create-form" variant="primary" size="sm">Save Add-on</x-admin.button>
                <x-admin.button type="button" variant="secondary" size="sm" @click="$dispatch('close-modal')">Cancel</x-admin.button>
            </x-slot:footer>
        </x-admin.modal>

        <!-- Edit Modals (one per row, server-rendered with real values) -->
        @foreach ($addons as $addon)
            <x-admin.modal name="addon-edit-modal-{{ $addon->id }}" title="Edit Checkout Add-on" maxW="md">
                <form id="addon-edit-form-{{ $addon->id }}" action="/admin/addons/{{ $addon->id }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <x-admin.form.input name="name" label="Add-on Name" :value="$addon->name" :required="true" />

                    <div class="grid grid-cols-2 gap-4">
                        <x-admin.form.input name="price" label="Billing Price ($)" type="number" :value="$addon->price" :required="true" />
                        <x-admin.form.input name="sort_order" label="Display Order" type="number" :value="$addon->sort_order" />
                    </div>

                    <x-admin.form.textarea name="description" label="Brief Description" :rows="3" :value="$addon->description" />

                    <div class="flex items-center gap-3">
                        <x-admin.form.toggle name="is_active" label="Enabled / Visible" :value="$addon->is_active" />
                    </div>
                </form>
                <x-slot:footer>
                    <x-admin.button type="submit" form="addon-edit-form-{{ $addon->id }}" variant="primary" size="sm">Save Changes</x-admin.button>
                    <x-admin.button type="button" variant="secondary" size="sm" @click="$dispatch('close-modal')">Cancel</x-admin.button>
                </x-slot:footer>
            </x-admin.modal>
        @endforeach
    </div>
</x-layouts.admin>
