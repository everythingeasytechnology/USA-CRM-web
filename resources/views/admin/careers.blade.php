<x-layouts.admin active="careers">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Careers Portal openings & Applications']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6" x-data="{ activeTab: 'openings', openModal: false, selectedJob: { title: '', location: '', desc: '', reqs: '' }, selectedCandidate: { name: '', email: '', phone: '', exp: '', portfolio: '', resume: '', cover: '', position: '' } }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Careers & Recruitment Portal</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage public job openings, departments, locations, and review incoming candidate applications.</p>
            </div>
            
            <!-- Tab switches -->
            <div class="flex items-center gap-1.5 border border-slate-200 dark:border-slate-800 rounded-lg p-1 bg-slate-50 dark:bg-slate-900/50 text-xs">
                <button type="button" @click="activeTab = 'openings'" :class="activeTab === 'openings' ? 'bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-2xs font-semibold' : 'text-slate-505'" class="px-3 py-1.5 rounded-md cursor-pointer">
                    Active Openings
                </button>
                <button type="button" @click="activeTab = 'applications'" :class="activeTab === 'applications' ? 'bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-2xs font-semibold' : 'text-slate-505'" class="px-3 py-1.5 rounded-md cursor-pointer flex items-center gap-1.5">
                    <span>Candidate Applications</span>
                    <span class="px-1.5 py-0.5 rounded-full bg-blue-100 dark:bg-blue-500/10 text-blue-650 text-3xs">3</span>
                </button>
            </div>
        </div>

        <!-- TAB 1: Active Openings -->
        <div x-show="activeTab === 'openings'" class="space-y-6">
            <x-admin.card title="Job Vacancies Directory">
                <x-slot:actions>
                    <x-admin.button variant="primary" size="xs" @click="
                        selectedJob = { title: '', location: '', desc: '', reqs: '' };
                        $dispatch('open-modal', 'job-modal');
                    ">
                        <x-admin.icon name="plus" class="w-4 h-4 mr-1.5" />
                        <span>Post a Job Opening</span>
                    </x-admin.button>
                </x-slot:actions>

                <x-admin.table :headers="['Job Details', 'Location / Mode', 'Short Description', 'Requirements Summary', 'Status', 'Actions']">
                    @php
                        $jobs = \App\Models\JobPosting::all();
                    @endphp

                    @forelse ($jobs as $job)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-850/20 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-900 dark:text-white text-xs block leading-tight">{{ $job->title }}</span>
                                <span class="text-[9px] text-slate-400 block mt-0.5">Posted {{ $job->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold text-slate-650 dark:text-slate-350">
                                {{ $job->location }}
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500 max-w-xs truncate" title="{{ $job->description }}">
                                {{ $job->description }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-[10px] text-slate-550 dark:text-slate-400 space-y-0.5 list-disc pl-3">
                                    @if (is_array($job->requirements))
                                        @foreach ($job->requirements as $req)
                                            <div>• {{ $req }}</div>
                                        @endforeach
                                    @else
                                        @foreach (explode("\n", $job->requirements) as $req)
                                            <div>• {{ $req }}</div>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <x-admin.form.toggle name="job_status_{{ $loop->index }}" :value="$job->status" />
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-1.5">
                                    <x-admin.button 
                                        variant="ghost" 
                                        size="xs"
                                        @click="
                                            selectedJob = {
                                                title: '{{ addslashes($job->title) }}',
                                                location: '{{ addslashes($job->location) }}',
                                                desc: '{{ addslashes($job->description) }}',
                                                reqs: '{{ addslashes(is_array($job->requirements) ? implode('\n', $job->requirements) : $job->requirements) }}'
                                            };
                                            $dispatch('open-modal', 'job-modal');
                                        "
                                        title="Edit Opening"
                                    >
                                        <x-admin.icon name="pencil" class="w-4 h-4 text-slate-500" />
                                    </x-admin.button>
                                    <x-admin.button variant="ghost" size="xs" class="text-red-500 hover:bg-red-50" @click="alert('Delete opening')" title="Delete Job"><x-admin.icon name="trash" class="w-4 h-4" /></x-admin.button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-xs text-slate-400">
                                No job vacancies posted yet.
                            </td>
                        </tr>
                    @endforelse
                </x-admin.table>
            </x-admin.card>
        </div>

        <!-- TAB 2: Candidate Applications -->
        <div x-show="activeTab === 'applications'" class="space-y-6" style="display: none;">
            <x-admin.card title="Job Applications Log" subtitle="Track and audit profiles, CV downloads, and experience credentials of incoming candidates.">
                <x-admin.table :headers="['Candidate Details', 'Applied Position', 'Experience', 'Portfolio URL', 'Resume (PDF)', 'Actions']">
                    @php
                        $candidates = \App\Models\JobApplication::latest()->get();
                    @endphp

                    @forelse ($candidates as $candidate)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-850/20 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-850 dark:text-slate-205 text-xs block leading-tight">{{ $candidate->name }}</span>
                                <span class="text-[10px] text-slate-550 dark:text-slate-400 block mt-0.5 font-mono">{{ $candidate->email }}</span>
                                <span class="text-[10px] text-slate-450 block mt-0.5 font-mono">{{ $candidate->phone }}</span>
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold text-slate-700 dark:text-slate-350">
                                {{ $candidate->jobPosting->title ?? 'Position' }}
                            </td>
                            <td class="px-6 py-4 text-xs font-mono font-bold text-slate-800 dark:text-slate-200">
                                {{ $candidate->experience }}
                            </td>
                            <td class="px-6 py-4 text-xs">
                                @if($candidate->portfolio_url)
                                    <a href="{{ $candidate->portfolio_url }}" target="_blank" class="text-blue-600 hover:underline font-mono">{{ $candidate->portfolio_url }}</a>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs font-mono">
                                <a href="{{ asset($candidate->resume_path) }}" target="_blank" class="inline-flex items-center gap-1.5 text-emerald-600 hover:underline font-semibold bg-emerald-50 dark:bg-emerald-500/10 px-2 py-0.5 rounded">
                                    <x-admin.icon name="download" class="w-3.5 h-3.5" />
                                    <span>Download CV</span>
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <x-admin.button 
                                    variant="secondary" 
                                    size="xs"
                                    @click="
                                        selectedCandidate = {
                                            name: '{{ addslashes($candidate->name) }}',
                                            email: '{{ addslashes($candidate->email) }}',
                                            phone: '{{ addslashes($candidate->phone) }}',
                                            exp: '{{ addslashes($candidate->experience) }}',
                                            portfolio: '{{ addslashes($candidate->portfolio_url) }}',
                                            resume: '{{ addslashes($candidate->resume_path) }}',
                                            cover: '{{ addslashes($candidate->cover_letter) }}',
                                            position: '{{ addslashes($candidate->jobPosting->title ?? 'Position') }}'
                                        };
                                        $dispatch('open-drawer', 'candidate-drawer');
                                    "
                                >
                                    <span>Review</span>
                                </x-admin.button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-xs text-slate-400">
                                No candidate applications recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </x-admin.table>
            </x-admin.card>
        </div>

        <!-- Manage Job Modal Form -->
        <x-admin.modal name="job-modal" title="Manage Career Posting" maxW="lg">
            <form action="#save-job" class="space-y-4" @submit.prevent="$dispatch('close-modal')">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-admin.form.input name="job_title" label="Job Posting Title" placeholder="e.g. Senior Web Developer" x-bind:value="selectedJob.title" :required="true" />
                    <x-admin.form.input name="job_location" label="Location / Workspace mode" placeholder="e.g. Remote, USA" x-bind:value="selectedJob.location" :required="true" />
                </div>

                <x-admin.form.textarea name="job_desc" label="Short Job Description" placeholder="Summarize role mission parameters..." :rows="3" x-bind:value="selectedJob.desc" :required="true" />

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-350 mb-1.5 font-medium">Requirements & Core Deliverables (One per line)</label>
                    <textarea name="job_reqs" rows="5" class="block w-full rounded-lg border border-slate-300 dark:border-slate-800 bg-white dark:bg-slate-900 p-3 text-xs text-slate-850 dark:text-slate-200 focus-ring" placeholder="5+ years of web development experience&#10;Proficiency in React, Node.js, and MongoDB&#10;Strong understanding of RESTful APIs and microservices" x-bind:value="selectedJob.reqs" required></textarea>
                </div>

                <div class="flex items-center gap-3">
                    <x-admin.form.toggle name="job_published" label="Active / Open for applications" :value="true" />
                </div>

                <x-slot:footer>
                    <x-admin.button type="submit" variant="primary" size="sm">Save Posting</x-admin.button>
                    <x-admin.button type="button" variant="secondary" size="sm" @click="$dispatch('close-modal')">Cancel</x-admin.button>
                </x-slot:footer>
            </form>
        </x-admin.modal>

        <!-- Candidate Application Details Drawer -->
        <x-admin.drawer name="candidate-drawer" title="Candidate Profile & Cover Letter" maxW="lg">
            <div class="space-y-6">
                <!-- Info Header -->
                <div class="p-4 border border-slate-100 dark:border-slate-800 rounded-xl bg-slate-50/20 dark:bg-slate-900/10">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-full bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-lg" x-text="selectedCandidate.name.split(' ').map(n=>n[0]).join('')"></div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white" x-text="selectedCandidate.name"></h3>
                            <span class="text-2xs text-slate-550 dark:text-slate-400" x-text="selectedCandidate.email"></span>
                        </div>
                    </div>
                    <div class="mt-4 grid grid-cols-2 gap-3 text-xs border-t border-slate-100 dark:border-slate-800 pt-3">
                        <div>
                            <span class="text-slate-500 block">Phone</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200" x-text="selectedCandidate.phone"></span>
                        </div>
                        <div>
                            <span class="text-slate-500 block">Experience</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200" x-text="selectedCandidate.exp"></span>
                        </div>
                    </div>
                </div>

                <!-- Position & Links -->
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-2xs font-semibold text-slate-500 uppercase tracking-wide block mb-1">Applied Position</span>
                            <div class="p-3 border border-slate-200 dark:border-slate-800 rounded-lg text-xs bg-white dark:bg-slate-900 text-slate-850 dark:text-slate-200 font-semibold" x-text="selectedCandidate.position"></div>
                        </div>
                        <div>
                            <span class="text-2xs font-semibold text-slate-500 uppercase tracking-wide block mb-1">Portfolio</span>
                            <div class="p-3 border border-slate-200 dark:border-slate-800 rounded-lg text-xs bg-white dark:bg-slate-900 text-slate-850 dark:text-slate-200 truncate">
                                <a x-bind:href="selectedCandidate.portfolio" target="_blank" class="text-blue-600 hover:underline" x-text="selectedCandidate.portfolio"></a>
                            </div>
                        </div>
                    </div>

                    <!-- Cover Letter -->
                    <div>
                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">Cover Letter Message</span>
                        <div class="p-3.5 border border-slate-200 dark:border-slate-800 rounded-lg text-xs bg-slate-50/50 dark:bg-slate-900/50 text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-line" x-text="selectedCandidate.cover"></div>
                    </div>
                </div>
            </div>

            <x-slot:footer>
                <x-admin.button variant="primary" size="sm" @click="alert('Candidate status set to shortlisted!'); $dispatch('close-drawer')">Shortlist Candidate</x-admin.button>
                <x-admin.button variant="secondary" size="sm" @click="$dispatch('close-drawer')">Close</x-admin.button>
            </x-slot:footer>
        </x-admin.drawer>
    </div>
</x-layouts.admin>
