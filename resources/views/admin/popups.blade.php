<x-layouts.admin active="popups">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Announcement Popups']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6" x-data="{ openModal: false }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Popup Manager</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure exit-intent overlays, discount offer banners, and email subscription schedules.</p>
            </div>
            <div class="flex items-center gap-2.5">
                <x-admin.button variant="primary" size="sm" @click="$dispatch('open-modal', 'popup-modal')">
                    <x-admin.icon name="plus" class="w-4 h-4 mr-1.5" />
                    <span>Create Popup</span>
                </x-admin.button>
            </div>
        </div>

        <!-- Popups grid cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @php
                $triggerLabels = ['exit' => 'Exit Intent Trigger', 'delay' => 'Time Delay Trigger', 'scroll' => 'Scroll Position Trigger'];
            @endphp
            @forelse ($popups as $popup)
                <x-admin.card :title="$popup->title" :subtitle="'Trigger: ' . ($triggerLabels[$popup->trigger_type] ?? $popup->trigger_type)">
                    <x-slot:actions>
                        <x-admin.toggle-form :action="'/admin/popups/'.$popup->id.'/toggle-active'" :active="$popup->is_active" />
                    </x-slot:actions>

                    <div class="space-y-4">
                        <div class="grid grid-cols-3 gap-2 text-center border-b border-slate-100 dark:border-slate-800 pb-4">
                            <div>
                                <span class="text-[10px] text-slate-450 block uppercase font-bold tracking-wide">Schedule</span>
                                <span class="text-xs font-semibold text-slate-700 dark:text-slate-350 block mt-1 truncate">
                                    {{ $popup->starts_at ? $popup->starts_at->format('M d').' - '.($popup->ends_at?->format('M d') ?? '—') : 'Active Indefinitely' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-450 block uppercase font-bold tracking-wide">Impressions</span>
                                <span class="text-xs font-mono font-bold text-slate-700 dark:text-slate-300 block mt-1">{{ $popup->impressions }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-455 block uppercase font-bold tracking-wide">Conversions</span>
                                <span class="text-xs font-mono font-bold text-emerald-600 block mt-1">{{ $popup->conversions }}</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-end gap-2.5">
                            <x-admin.button type="button" variant="secondary" size="xs" @click="$dispatch('open-modal', 'popup-edit-modal-{{ $popup->id }}')">Edit Rule</x-admin.button>
                            <x-admin.delete-form :action="'/admin/popups/'.$popup->id" confirm="Delete this popup permanently?">
                                <button type="submit" class="inline-flex items-center justify-center p-1.5 rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-950/30 cursor-pointer"><x-admin.icon name="trash" class="w-4 h-4" /></button>
                            </x-admin.delete-form>
                        </div>
                    </div>
                </x-admin.card>
            @empty
                <div class="col-span-full text-center text-xs text-slate-400 py-12">No popups configured yet.</div>
            @endforelse
        </div>

        <!-- Popup Modal Form (Create) -->
        <x-admin.modal name="popup-modal" title="Create Popup Rule" maxW="md">
            <form id="popup-create-form" action="/admin/popups" method="POST" class="space-y-4">
                @csrf
                <x-admin.form.input name="pop_title" label="Popup Campaign Title" placeholder="e.g. Exit Intent Newsletter signup" :required="true" />

                <x-admin.form.select name="pop_trigger" label="Interaction Trigger">
                    <option value="exit">Exit Intent (Desktop cursor leaves window)</option>
                    <option value="delay">Time Delay (Seconds)</option>
                    <option value="scroll">Scroll Position (%)</option>
                </x-admin.form.select>

                <div class="grid grid-cols-2 gap-4">
                    <x-admin.form.input name="pop_start" type="date" label="Campaign Start" />
                    <x-admin.form.input name="pop_end" type="date" label="Campaign End" />
                </div>

                <x-admin.form.textarea name="pop_html" label="HTML Content Banner markup" placeholder="<div>Our custom offer details...</div>" :rows="3" />

                <div class="flex items-center gap-3">
                    <x-admin.form.toggle name="pop_enabled_active" label="Enabled / Visible" :value="true" />
                </div>
            </form>
            <x-slot:footer>
                <x-admin.button type="submit" form="popup-create-form" variant="primary" size="sm">Save Campaign</x-admin.button>
                <x-admin.button type="button" variant="secondary" size="sm" @click="$dispatch('close-modal')">Cancel</x-admin.button>
            </x-slot:footer>
        </x-admin.modal>

        <!-- Edit Modals -->
        @foreach ($popups as $popup)
            <x-admin.modal name="popup-edit-modal-{{ $popup->id }}" title="Edit Popup Rule" maxW="md">
                <form id="popup-edit-form-{{ $popup->id }}" action="/admin/popups/{{ $popup->id }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <x-admin.form.input name="pop_title" label="Popup Campaign Title" :value="$popup->title" :required="true" />

                    <x-admin.form.select name="pop_trigger" label="Interaction Trigger">
                        <option value="exit" @selected($popup->trigger_type === 'exit')>Exit Intent (Desktop cursor leaves window)</option>
                        <option value="delay" @selected($popup->trigger_type === 'delay')>Time Delay (Seconds)</option>
                        <option value="scroll" @selected($popup->trigger_type === 'scroll')>Scroll Position (%)</option>
                    </x-admin.form.select>

                    <div class="grid grid-cols-2 gap-4">
                        <x-admin.form.input name="pop_start" type="date" label="Campaign Start" :value="$popup->starts_at?->format('Y-m-d')" />
                        <x-admin.form.input name="pop_end" type="date" label="Campaign End" :value="$popup->ends_at?->format('Y-m-d')" />
                    </div>

                    <x-admin.form.textarea name="pop_html" label="HTML Content Banner markup" :rows="3" :value="$popup->content" />

                    <div class="flex items-center gap-3">
                        <x-admin.form.toggle name="pop_enabled_active" label="Enabled / Visible" :value="$popup->is_active" />
                    </div>
                </form>
                <x-slot:footer>
                    <x-admin.button type="submit" form="popup-edit-form-{{ $popup->id }}" variant="primary" size="sm">Save Changes</x-admin.button>
                    <x-admin.button type="button" variant="secondary" size="sm" @click="$dispatch('close-modal')">Cancel</x-admin.button>
                </x-slot:footer>
            </x-admin.modal>
        @endforeach
    </div>
</x-layouts.admin>
