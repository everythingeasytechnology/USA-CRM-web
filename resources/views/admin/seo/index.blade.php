<x-layouts.admin active="seo">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'SEO Operations Control']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6" x-data="{ activeTab: 'general' }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">SEO Operations & Meta Config</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure structured JSON-LD schemas, manage 301 redirects, monitor 404 broken queries, and compile robots.txt files.</p>
            </div>
            
            <div class="flex items-center gap-1 border border-slate-200 dark:border-slate-800 rounded-lg p-1 bg-slate-50 dark:bg-slate-900/50 text-xs">
                <button type="button" @click="activeTab = 'general'" :class="activeTab === 'general' ? 'bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-2xs font-semibold' : 'text-slate-505'" class="px-3 py-1.5 rounded-md cursor-pointer">
                    Sitemaps & Robots
                </button>
                <button type="button" @click="activeTab = 'redirects'" :class="activeTab === 'redirects' ? 'bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-2xs font-semibold' : 'text-slate-505'" class="px-3 py-1.5 rounded-md cursor-pointer">
                    Redirects Manager
                </button>
                <button type="button" @click="activeTab = 'locations'" :class="activeTab === 'locations' ? 'bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-2xs font-semibold' : 'text-slate-505'" class="px-3 py-1.5 rounded-md cursor-pointer">
                    Locations Database
                </button>
                <button type="button" @click="activeTab = 'monitor'" :class="activeTab === 'monitor' ? 'bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-2xs font-semibold' : 'text-slate-505'" class="px-3 py-1.5 rounded-md cursor-pointer flex items-center gap-1.5">
                    <span>404 Monitor</span>
                    <span class="px-1.5 py-0.5 rounded-full bg-red-100 dark:bg-red-500/10 text-red-650 text-3xs">{{ $notFoundLogs->count() }}</span>
                </button>
            </div>
        </div>

        <!-- Tab 1: Sitemaps & Robots -->
        <div x-show="activeTab === 'general'" class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <x-admin.card title="robots.txt Text Editor">
                        <form action="#save-robots" @submit.prevent="alert('robots.txt saved!')">
                            <x-admin.form.textarea name="robots_content" placeholder="User-agent: *&#10;Allow: /&#10;Disallow: /admin/" :rows="6" value="User-agent: *&#10;Allow: /&#10;Disallow: /admin/&#10;&#10;Sitemap: https://everythingeasy.in/sitemap.xml" />
                            <div class="flex justify-end mt-4">
                                <x-admin.button type="submit" variant="primary" size="sm">Save robots.txt</x-admin.button>
                            </div>
                        </form>
                    </x-admin.card>

                    <!-- Schemas -->
                    <x-admin.card title="JSON-LD Schema Manager">
                        <div class="space-y-4 text-xs">
                            <p class="text-slate-500 leading-normal">Generate Structured Data markup to rank search indexing nodes with Rich Snippets.</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="p-3 border border-slate-200 dark:border-slate-800 bg-slate-50/20 dark:bg-slate-900/10 rounded-xl flex justify-between items-center">
                                    <div>
                                        <span class="font-bold text-slate-900 dark:text-white block">Organization Schema</span>
                                        <span class="text-[10px] text-slate-400 mt-0.5 block">Configures brand logo and social links</span>
                                    </div>
                                    <x-admin.button variant="secondary" size="xs" @click="alert('Edit Organization Schema')">Edit</x-admin.button>
                                </div>
                                <div class="p-3 border border-slate-200 dark:border-slate-800 bg-slate-50/20 dark:bg-slate-900/10 rounded-xl flex justify-between items-center">
                                    <div>
                                        <span class="font-bold text-slate-900 dark:text-white block">Local Business Schema</span>
                                        <span class="text-[10px] text-slate-400 mt-0.5 block">Specifies head address and coordinate nodes</span>
                                    </div>
                                    <x-admin.button variant="secondary" size="xs" @click="alert('Edit Local Business Schema')">Edit</x-admin.button>
                                </div>
                            </div>
                        </div>
                    </x-admin.card>
                </div>

                <div class="space-y-6">
                    <x-admin.card title="Sitemap Control Panel">
                        <div class="space-y-4 text-xs">
                            <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-850">
                                <span class="text-slate-500">XML Sitemap Link:</span>
                                <a href="#xml" class="font-mono text-blue-600 hover:underline">/sitemap.xml</a>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-850">
                                <span class="text-slate-500">HTML Sitemap Link:</span>
                                <a href="#html" class="font-mono text-blue-600 hover:underline">/sitemap-index.html</a>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-slate-500">Last Regenerated:</span>
                                <span class="font-mono text-slate-700 dark:text-slate-300">12 hours ago</span>
                            </div>
                            
                            <hr class="border-slate-100 dark:border-slate-800" />
                            
                            <x-admin.button variant="primary" class="w-full justify-center" @click="alert('Sitemaps successfully updated!')">
                                <x-admin.icon name="sync" class="w-4 h-4 mr-1.5" />
                                <span>Regenerate Sitemaps</span>
                            </x-admin.button>
                        </div>
                    </x-admin.card>
                </div>
            </div>
        </div>

        <!-- Tab 2: Redirects Manager -->
        <div x-show="activeTab === 'redirects'" class="space-y-6" style="display: none;">
            <x-admin.card title="Route Redirect Log Rules" subtitle="Manage HTTP 301 (Permanent) or 302 (Temporary) URL changes to protect backlink page authority.">
                <x-slot:actions>
                    <x-admin.button type="button" variant="primary" size="xs" @click="$dispatch('open-modal', 'redirect-modal')">
                        <x-admin.icon name="plus" class="w-4.5 h-4.5 mr-1" />
                        <span>Add Redirect</span>
                    </x-admin.button>
                </x-slot:actions>

                <x-admin.table :headers="['Request URL Path', 'Destination Target Path', 'HTTP Code', 'Status', 'Actions']">
                    @forelse ($redirects as $redirect)
                        <tr>
                            <td class="px-6 py-4 font-mono text-xs font-semibold text-slate-850 dark:text-slate-205">{{ $redirect->from_path }}</td>
                            <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $redirect->to_path }}</td>
                            <td class="px-6 py-4 text-xs font-bold text-emerald-600">{{ $redirect->status_code }} ({{ $redirect->status_code == 301 ? 'Perm' : 'Temp' }})</td>
                            <td class="px-6 py-4"><x-admin.badge :variant="$redirect->is_active ? 'success' : 'neutral'">{{ $redirect->is_active ? 'Active' : 'Disabled' }}</x-admin.badge></td>
                            <td class="px-6 py-4">
                                <x-admin.delete-form :action="'/admin/seo/redirects/'.$redirect->id" confirm="Delete this redirect?">
                                    <button type="submit" class="inline-flex items-center justify-center p-1.5 rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-950/30 cursor-pointer"><x-admin.icon name="trash" class="w-4 h-4" /></button>
                                </x-admin.delete-form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-12 text-center text-xs text-slate-400">No redirects configured yet.</td></tr>
                    @endforelse
                </x-admin.table>
            </x-admin.card>

            <x-admin.modal name="redirect-modal" title="Add Redirect Rule" maxW="md">
                <form id="redirect-create-form" action="/admin/seo/redirects" method="POST" class="space-y-4">
                    @csrf
                    <x-admin.form.input name="from_path" label="Request URL Path" placeholder="/old-services/web-dev" :required="true" />
                    <x-admin.form.input name="to_path" label="Destination Target Path" placeholder="/services/website-development" :required="true" />
                    <x-admin.form.select name="status_code" label="HTTP Status Code">
                        <option value="301">301 (Permanent)</option>
                        <option value="302">302 (Temporary)</option>
                    </x-admin.form.select>
                </form>
                <x-slot:footer>
                    <x-admin.button type="submit" form="redirect-create-form" variant="primary" size="sm">Save Redirect</x-admin.button>
                    <x-admin.button type="button" variant="secondary" size="sm" @click="$dispatch('close-modal')">Cancel</x-admin.button>
                </x-slot:footer>
            </x-admin.modal>
        </div>

        <!-- Tab 3: 404 Monitor -->
        <div x-show="activeTab === 'monitor'" class="space-y-6" style="display: none;">
            <x-admin.card title="Broken Link Queries Monitor" subtitle="Monitors user requests hitting dead pages, helping clear internal crawl links.">
                <x-admin.table :headers="['Dead URL Path', 'Client Referrer Link', 'Hits Count', 'Last Request Date', 'Actions']">
                    @forelse ($notFoundLogs as $log)
                        <tr>
                            <td class="px-6 py-4 font-mono text-xs font-semibold text-slate-900 dark:text-white">{{ $log->url_path }}</td>
                            <td class="px-6 py-4 text-xs text-slate-400">{{ $log->referrer ?: 'Direct Entry' }}</td>
                            <td class="px-6 py-4 text-xs font-mono font-bold text-slate-850 dark:text-slate-200">{{ $log->hit_count }}</td>
                            <td class="px-6 py-4 text-xs text-slate-500">{{ $log->last_hit_at?->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 flex gap-1.5">
                                <form method="POST" action="/admin/seo/404-logs/{{ $log->id }}/convert">
                                    @csrf
                                    <button type="submit" class="text-xs font-medium px-3 py-2 rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer">Redirect URL</button>
                                </form>
                                <x-admin.delete-form :action="'/admin/seo/404-logs/'.$log->id" confirm="Remove this log entry?">
                                    <button type="submit" class="inline-flex items-center justify-center p-1.5 rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-950/30 cursor-pointer"><x-admin.icon name="trash" class="w-4 h-4" /></button>
                                </x-admin.delete-form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-12 text-center text-xs text-slate-400">No 404 hits logged yet.</td></tr>
                    @endforelse
                </x-admin.table>
            </x-admin.card>
        </div>

        <!-- Tab 4: Locations Database -->
        <div x-show="activeTab === 'locations'" class="space-y-6" style="display: none;">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- CSV Upload dropzone -->
                <div class="space-y-6">
                    <x-admin.card title="Upload Locations (CSV)" subtitle="Bulk import cities, states, and countries in one click.">
                        <form action="/admin/seo/locations/import" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <label class="block border-2 border-dashed border-slate-200 dark:border-slate-850 rounded-lg p-5 text-center cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-850 transition-colors">
                                <x-admin.icon name="upload" class="w-8 h-8 text-slate-400 mx-auto" />
                                <span class="text-xs font-semibold text-slate-600 dark:text-slate-350 block mt-2">Select locations CSV file</span>
                                <span class="text-[10px] text-slate-400 block mt-0.5">Columns: city, state, country (Max 5MB)</span>
                                <input type="file" name="file" accept=".csv" required class="hidden" onchange="this.closest('label').querySelector('span').textContent = this.files[0]?.name || 'Select locations CSV file'">
                            </label>

                            <x-admin.button type="submit" variant="primary" class="w-full justify-center">
                                Upload & Seed Database
                            </x-admin.button>
                        </form>
                    </x-admin.card>

                    <!-- Statistics card -->
                    <x-admin.card title="Database Metrics">
                        <div class="space-y-3 text-xs">
                            <div class="flex justify-between py-1.5 border-b border-slate-100 dark:border-slate-850">
                                <span class="text-slate-500">Total Countries:</span>
                                <span class="font-bold text-slate-800 dark:text-slate-200">{{ $locations->pluck('country')->unique()->count() }}</span>
                            </div>
                            <div class="flex justify-between py-1.5 border-b border-slate-100 dark:border-slate-850">
                                <span class="text-slate-500">Total States:</span>
                                <span class="font-bold text-slate-800 dark:text-slate-200">{{ $locations->pluck('state')->filter()->unique()->count() }}</span>
                            </div>
                            <div class="flex justify-between py-1.5">
                                <span class="text-slate-500">Total Active Cities:</span>
                                <span class="font-bold text-slate-800 dark:text-slate-200">{{ $locations->where('is_active', true)->count() }}</span>
                            </div>
                        </div>
                    </x-admin.card>
                </div>

                <!-- Locations list table -->
                <div class="lg:col-span-2 space-y-6">
                    <x-admin.card title="Cities Directory Logs" subtitle="Add or remove active targeting endpoints.">
                        <x-slot:actions>
                            <x-admin.button type="button" variant="secondary" size="xs" @click="$dispatch('open-modal', 'location-modal')">
                                <x-admin.icon name="plus" class="w-4 h-4 mr-1" />
                                <span>Add Location</span>
                            </x-admin.button>
                        </x-slot:actions>

                        <x-admin.table :headers="['City Name', 'State Mapped', 'Country Mapped', 'Actions']">
                            @forelse ($locations as $location)
                                <tr>
                                    <td class="px-6 py-4 text-xs font-bold text-slate-900 dark:text-white">{{ $location->city }}</td>
                                    <td class="px-6 py-4 text-xs text-slate-650 dark:text-slate-350">{{ $location->state }}</td>
                                    <td class="px-6 py-4 text-xs text-slate-500 font-semibold">{{ $location->country }}</td>
                                    <td class="px-6 py-4">
                                        <x-admin.delete-form :action="'/admin/seo/locations/'.$location->id" confirm="Delete this location?">
                                            <button type="submit" class="inline-flex items-center justify-center p-1.5 rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-950/30 cursor-pointer"><x-admin.icon name="trash" class="w-4 h-4" /></button>
                                        </x-admin.delete-form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-6 py-12 text-center text-xs text-slate-400">No locations added yet.</td></tr>
                            @endforelse
                        </x-admin.table>
                    </x-admin.card>
                </div>

                <x-admin.modal name="location-modal" title="Add Location" maxW="md">
                    <form id="location-create-form" action="/admin/seo/locations" method="POST" class="space-y-4">
                        @csrf
                        <x-admin.form.input name="city" label="City" :required="true" />
                        <x-admin.form.input name="state" label="State / Region" />
                        <x-admin.form.input name="country" label="Country" :required="true" />
                    </form>
                    <x-slot:footer>
                        <x-admin.button type="submit" form="location-create-form" variant="primary" size="sm">Save Location</x-admin.button>
                        <x-admin.button type="button" variant="secondary" size="sm" @click="$dispatch('close-modal')">Cancel</x-admin.button>
                    </x-slot:footer>
                </x-admin.modal>
            </div>
        </div>
    </div>
</x-layouts.admin>
