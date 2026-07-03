<x-layouts.admin active="leads">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Lead Management']]" />
    </x-slot:breadcrumbs>

    <div 
        class="space-y-6"
        x-data="{
            selectedLead: {
                id: null, name: '', email: '', phone: '', service: '', budget: '', country: '', status: '', source: '', notes: ''
            }
        }"
    >
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Lead Management</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Review contact enquiries, project scope budgets, and assign sales representatives.</p>
            </div>
            <div class="flex items-center gap-2.5">
                <x-admin.button variant="secondary" size="sm">
                    <x-admin.icon name="upload" class="w-4 h-4 mr-1.5" />
                    <span>Import CSV</span>
                </x-admin.button>
                <x-admin.button variant="primary" size="sm" @click="alert('CSV export triggered.')">
                    <span>Export CSV</span>
                </x-admin.button>
            </div>
        </div>

        <!-- Filters Toolbar -->
        <x-admin.card>
            <div class="flex flex-wrap items-center justify-between gap-4">
                <form method="GET" action="/admin/leads" class="w-full sm:max-w-xs relative">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search leads..."
                        class="w-full pl-9 pr-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg text-sm bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100"
                    />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-admin.icon name="search" class="w-4 h-4 text-slate-400" />
                    </div>
                </form>

                <form method="GET" action="/admin/leads" class="flex items-center gap-2.5 flex-wrap">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <select name="status" class="text-xs bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg p-2 text-slate-700 dark:text-slate-300">
                        <option value="">Lead Status</option>
                        <option value="new" @selected(request('status') === 'new')>New Enquiry</option>
                        <option value="in_discussion" @selected(request('status') === 'in_discussion')>In Discussion</option>
                        <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                        <option value="completed" @selected(request('status') === 'completed')>Completed</option>
                        <option value="fake" @selected(request('status') === 'fake')>Fake / Spam</option>
                    </select>
                    <x-admin.button type="submit" variant="secondary" size="sm">
                        <x-admin.icon name="filters" class="w-4 h-4" />
                        <span>Filter</span>
                    </x-admin.button>
                </form>
            </div>
        </x-admin.card>

        <!-- Leads Table -->
        <x-admin.card :padding="false">
            <x-admin.table :headers="['Client Name', 'Interested Service', 'Declared Budget', 'Country', 'Source', 'Status', 'Actions']">
                @foreach ($leads as $lead)
                    <tr
                        class="hover:bg-slate-50/50 dark:hover:bg-slate-850/20 transition-colors cursor-pointer group"
                        @click="
                            selectedLead = {
                                id: {{ $lead->id }},
                                name: '{{ addslashes($lead->name) }}',
                                email: '{{ addslashes($lead->email) }}',
                                phone: '{{ addslashes($lead->phone) }}',
                                service: '{{ addslashes($lead->service_requested) }}',
                                budget: '{{ addslashes($lead->budget) }}',
                                country: '{{ addslashes($lead->country) }}',
                                source: '{{ addslashes($lead->source) }}',
                                status: '{{ addslashes($lead->status) }}',
                                notes: '{{ addslashes($lead->notes) }}'
                            };
                            $dispatch('open-drawer', 'lead-details-drawer');
                        "
                    >
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-850 dark:text-slate-205 text-xs block leading-tight">{{ $lead->name }}</span>
                            <span class="text-[10px] text-slate-550 dark:text-slate-400 block mt-0.5 font-mono">{{ $lead->email }}</span>
                            <span class="text-[10px] text-slate-450 block mt-0.5 font-mono">{{ $lead->phone }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs font-semibold text-slate-700 dark:text-slate-350">
                            {{ $lead->service_requested }}
                        </td>
                        <td class="px-6 py-4 text-xs font-mono font-bold text-slate-800 dark:text-slate-200">
                            {{ $lead->budget }}
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-550 dark:text-slate-400">
                            {{ $lead->country }}
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500">
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
                        <td class="px-6 py-4">
                            <x-admin.button variant="ghost" size="xs" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                <x-admin.icon name="eye" class="w-4.5 h-4.5" />
                            </x-admin.button>
                        </td>
                    </tr>
                @endforeach
            </x-admin.table>
            
            <x-admin.pagination :currentPage="1" :totalPages="6" :totalResults="30" :perPage="5" />
        </x-admin.card>

        <!-- Lead details slide drawer -->
        <x-admin.drawer name="lead-details-drawer" title="Lead Enquiry Audit Sheet">
            <div class="space-y-6">
                <!-- Info header card -->
                <div class="p-4 border border-slate-100 dark:border-slate-800 rounded-xl bg-slate-50/20 dark:bg-slate-900/10 flex items-center gap-4">
                    <div class="h-11 w-11 rounded-full bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-sm" x-text="selectedLead.name.split(' ').map(n=>n[0]).join('')"></div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white" x-text="selectedLead.name"></h4>
                        <span class="text-2xs text-slate-500" x-text="selectedLead.email"></span>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <span class="text-2xs font-semibold text-slate-500 uppercase tracking-wide block mb-1">Interested Service</span>
                        <div class="p-3 border border-slate-200 dark:border-slate-800 rounded-lg text-xs bg-white dark:bg-slate-900 text-slate-850 dark:text-slate-200" x-text="selectedLead.service"></div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-2xs font-semibold text-slate-500 uppercase tracking-wide block mb-1">Budget</span>
                            <div class="p-3 border border-slate-200 dark:border-slate-800 rounded-lg text-xs font-mono font-bold bg-white dark:bg-slate-900 text-slate-850 dark:text-slate-200" x-text="selectedLead.budget"></div>
                        </div>
                        <div>
                            <span class="text-2xs font-semibold text-slate-500 uppercase tracking-wide block mb-1">Source</span>
                            <div class="p-3 border border-slate-200 dark:border-slate-800 rounded-lg text-xs bg-white dark:bg-slate-900 text-slate-850 dark:text-slate-200" x-text="selectedLead.source"></div>
                        </div>
                    </div>

                    <div>
                        <span class="text-2xs font-semibold text-slate-500 uppercase tracking-wide block mb-1">Client Notes</span>
                        <div class="p-3 border border-slate-200 dark:border-slate-800 rounded-lg text-xs bg-slate-50/50 dark:bg-slate-900/50 text-slate-700 dark:text-slate-350 leading-relaxed" x-text="selectedLead.notes"></div>
                    </div>
                </div>

                <!-- Assignment tools -->
                <form :action="'/admin/leads/' + selectedLead.id" method="POST" class="border-t border-slate-200 dark:border-slate-800 pt-4" id="lead-update-form">
                    @csrf
                    @method('PATCH')
                    <span class="text-xs font-semibold text-slate-500 block mb-3 uppercase tracking-wider">Status & Assignment</span>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-admin.form.select name="status_update" label="Milestone" x-model="selectedLead.status">
                            <option value="new">New Enquiry</option>
                            <option value="in_discussion">In Discussion</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="fake">Fake / Spam</option>
                            <option value="lost">Lost / Archived</option>
                        </x-admin.form.select>
                        <x-admin.form.select name="assigned_staff_id" label="Assign Staff Member" placeholder="Unassigned...">
                            @foreach ($staff as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </x-admin.form.select>
                    </div>
                </form>
            </div>

            <x-slot:footer>
                <x-admin.button type="submit" form="lead-update-form" variant="primary" size="sm">Save Lead</x-admin.button>
                <x-admin.button variant="secondary" size="sm" @click="$dispatch('close-drawer')">Close</x-admin.button>
            </x-slot:footer>
        </x-admin.drawer>

    </div>
</x-layouts.admin>
