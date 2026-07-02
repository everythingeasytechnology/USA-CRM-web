<x-layouts.admin active="newsletter">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Newsletter Subscribers']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Newsletter Subscribers</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Review, import, and export registered email subscriber lists for marketing campaigns.</p>
            </div>
            <div class="flex items-center gap-2.5">
                <x-admin.button variant="secondary" size="sm">
                    Import List
                </x-admin.button>
                <x-admin.button variant="primary" size="sm" @click="alert('CSV export starting...')">
                    Export Subscribers (CSV)
                </x-admin.button>
            </div>
        </div>

        <!-- Subscribers Table -->
        <x-admin.card :padding="false">
            <x-admin.table :headers="['Subscriber Email', 'Date Subscribed', 'Referral Path', 'Status', 'Actions']">
                @php
                    $subs = \App\Models\NewsletterSubscriber::latest()->get();
                @endphp

                @forelse ($subs as $sub)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-850/20 transition-colors">
                        <td class="px-6 py-4 font-semibold text-xs text-slate-900 dark:text-white font-mono">
                            {{ $sub->email }}
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-550 font-mono">
                            {{ $sub->created_at->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-650 dark:text-slate-350">
                            {{ $sub->source ?? 'Form Footer' }}
                        </td>
                        <td class="px-6 py-4">
                            <x-admin.badge variant="{{ $sub->status ? 'success' : 'danger' }}">
                                {{ $sub->status ? 'Subscribed' : 'Unsubscribed' }}
                            </x-admin.badge>
                        </td>
                        <td class="px-6 py-4">
                            <x-admin.button variant="ghost" size="xs" class="text-red-500 hover:bg-red-50" @click="alert('Unsubscribe user')">
                                <x-admin.icon name="x-mark" class="w-4 h-4" />
                            </x-admin.button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-xs text-slate-400">
                            No subscribers registered yet.
                        </td>
                    </tr>
                @endforelse
            </x-admin.table>
            
            <x-admin.pagination :currentPage="1" :totalPages="20" :totalResults="100" :perPage="4" />
        </x-admin.card>
    </div>
</x-layouts.admin>
