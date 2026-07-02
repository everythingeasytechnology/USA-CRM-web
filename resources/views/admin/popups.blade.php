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
                $popups = [
                    ['name' => 'Exit Intent Offer Overlay', 'type' => 'Exit Intent Trigger', 'schedule' => 'Active Indefinitely', 'hits' => 1240, 'conversions' => '8.2%', 'status' => true],
                    ['name' => 'July Festival Discount Banner', 'type' => 'Time Delay (5 seconds)', 'schedule' => 'July 01 - July 15', 'hits' => 450, 'conversions' => '12.4%', 'status' => true],
                    ['name' => 'Newsletter Signup Overlay', 'type' => 'Scroll percentage (50%)', 'schedule' => 'Draft / Inactive', 'hits' => 0, 'conversions' => '—', 'status' => false],
                ];
            @endphp

            @foreach ($popups as $popup)
                <x-admin.card :title="$popup['name']" :subtitle="'Trigger: ' . $popup['type']">
                    <x-slot:actions>
                        <x-admin.form.toggle name="pop_active_{{ $loop->index }}" :value="$popup['status']" />
                    </x-slot:actions>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-3 gap-2 text-center border-b border-slate-100 dark:border-slate-800 pb-4">
                            <div>
                                <span class="text-[10px] text-slate-450 block uppercase font-bold tracking-wide">Schedule</span>
                                <span class="text-xs font-semibold text-slate-700 dark:text-slate-350 block mt-1 truncate" title="{{ $popup['schedule'] }}">{{ $popup['schedule'] }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-450 block uppercase font-bold tracking-wide">Impressions</span>
                                <span class="text-xs font-mono font-bold text-slate-700 dark:text-slate-300 block mt-1">{{ $popup['hits'] }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-455 block uppercase font-bold tracking-wide">Conv. Rate</span>
                                <span class="text-xs font-mono font-bold text-emerald-600 block mt-1">{{ $popup['conversions'] }}</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-end gap-2.5">
                            <x-admin.button variant="secondary" size="xs" @click="$dispatch('open-modal', 'popup-modal')">Edit Rule</x-admin.button>
                            <x-admin.button variant="ghost" size="xs" class="text-red-500 hover:bg-red-50" @click="alert('Delete')"><x-admin.icon name="trash" class="w-4 h-4" /></x-admin.button>
                        </div>
                    </div>
                </x-admin.card>
            @endforeach
        </div>

        <!-- Popup Modal Form -->
        <x-admin.modal name="popup-modal" title="Manage Popup Rule" maxW="md">
            <form action="#save-popup" class="space-y-4" @submit.prevent="$dispatch('close-modal')">
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
                
                <x-slot:footer>
                    <x-admin.button type="submit" variant="primary" size="sm">Save Campaign</x-admin.button>
                    <x-admin.button type="button" variant="secondary" size="sm" @click="$dispatch('close-modal')">Cancel</x-admin.button>
                </x-slot:footer>
            </form>
        </x-admin.modal>
    </div>
</x-layouts.admin>
