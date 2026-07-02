<x-layouts.admin active="forms">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Form Enquiries Directory']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6" x-data="{ activeTab: 'messages' }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Form Messages Directory</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Audit customer messages, newsletter signups, job applications, and configure Google reCAPTCHA.</p>
            </div>
            
            <!-- tab switches -->
            <div class="flex items-center gap-1.5 border border-slate-200 dark:border-slate-800 rounded-lg p-1 bg-slate-50 dark:bg-slate-900/50 text-xs">
                <button type="button" @click="activeTab = 'messages'" :class="activeTab === 'messages' ? 'bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-2xs font-semibold' : 'text-slate-500'" class="px-3 py-1.5 rounded-md cursor-pointer">
                    Enquiries Log
                </button>
                <button type="button" @click="activeTab = 'recaptcha'" :class="activeTab === 'recaptcha' ? 'bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-2xs font-semibold' : 'text-slate-500'" class="px-3 py-1.5 rounded-md cursor-pointer">
                    Spam Controls
                </button>
            </div>
        </div>

        <!-- Tab 1: Messages Log -->
        <div x-show="activeTab === 'messages'" class="space-y-6">
            <!-- Filters -->
            <x-admin.card>
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="w-full sm:max-w-xs relative">
                        <input 
                            type="text" 
                            placeholder="Search messages..." 
                            class="w-full pl-9 pr-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg text-sm bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100"
                        />
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-admin.icon name="search" class="w-4 h-4 text-slate-400" />
                        </div>
                    </div>
                    <select class="text-xs bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg p-2 text-slate-700 dark:text-slate-300">
                        <option value="">Form Type</option>
                        <option value="contact">Contact Form</option>
                        <option value="quote">Quote Requests</option>
                        <option value="career">Job Applications</option>
                    </select>
                </div>
            </x-admin.card>

            <!-- Table of messages -->
            <x-admin.card :padding="false">
                <x-admin.table :headers="['Sender Details', 'Form Origin', 'Subject / Summary', 'Date Received', 'Actions']">
                    @php
                        $msgs = \App\Models\ContactMessage::latest()->get();
                    @endphp

                    @forelse ($msgs as $msg)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-850/20 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-850 dark:text-slate-205 text-xs block leading-tight">{{ $msg->name }}</span>
                                <span class="text-[10px] text-slate-450 block mt-0.5">{{ $msg->email }}</span>
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold text-slate-700 dark:text-slate-350">
                                {{ ucfirst($msg->form_type) }} Form
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-550 dark:text-slate-400 max-w-xs truncate" title="{{ $msg->message }}">
                                {{ $msg->message }}
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500 font-mono">
                                {{ $msg->created_at->format('Y-m-d') }}
                            </td>
                            <td class="px-6 py-4">
                                <x-admin.button variant="secondary" size="xs" @click="alert('Sender message: ' + '{{ addslashes($msg->message) }}')">
                                    <span>Read</span>
                                </x-admin.button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-xs text-slate-400">
                                No contact message submissions recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </x-admin.table>
                
                <x-admin.pagination :currentPage="1" :totalPages="4" :totalResults="18" :perPage="4" />
            </x-admin.card>
        </div>

        <!-- Tab 2: Spam & Recaptcha Settings -->
        <div x-show="activeTab === 'recaptcha'" class="space-y-6" style="display: none;">
            <x-admin.card title="Google reCAPTCHA v3 Config">
                <form action="#save-recaptcha" class="space-y-4" @submit.prevent="alert('Spam settings saved successfully!')">
                    <x-admin.form.toggle name="recaptcha_enabled" label="Enable Google reCAPTCHA v3 Checkpoint" :value="true" help="Protects all public form entries against spam bots." />
                    
                    <hr class="border-slate-200 dark:border-slate-800" />
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-admin.form.input name="recaptcha_site" label="reCAPTCHA Site Key" value="6Ld9o8kUAAAAAD3CustomSiteKeyText" />
                        <x-admin.form.input name="recaptcha_secret" type="password" label="reCAPTCHA Secret Key" value="6Ld9o8kUAAAAAD3SecretKeyValueCustom" />
                    </div>
                    
                    <x-admin.form.input name="score_threshold" label="Minimum Spam Score Threshold" type="number" step="0.1" value="0.5" help="Values range from 0.0 (likely bot) to 1.0 (likely human)" />

                    <div class="flex justify-end">
                        <x-admin.button type="submit" variant="primary">
                            Save Settings
                        </x-admin.button>
                    </div>
                </form>
            </x-admin.card>
        </div>
    </div>
</x-layouts.admin>
