<x-layouts.admin active="legal">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Legal Compliance Panels']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6" x-data="{ selectedPolicy: 'privacy-policy' }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Legal Pages Compliance</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Review terms of use, privacy policies, refunds, return policies, and accessibility disclosures.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            
            <!-- Left panel: Document Selector Menu -->
            <div>
                <x-admin.card :padding="false">
                    <nav class="p-3 space-y-1 text-xs" aria-label="Legal Documents Menu">
                        <button
                            type="button"
                            @click="selectedPolicy = 'privacy-policy'"
                            :class="selectedPolicy === 'privacy-policy' ? 'bg-blue-600/10 text-blue-400 font-semibold' : 'text-slate-650 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-800/60'"
                            class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-left cursor-pointer transition-colors"
                        >
                            <x-admin.icon name="pages" class="w-4.5 h-4.5" />
                            <span>Privacy Policy</span>
                        </button>
                        <button
                            type="button"
                            @click="selectedPolicy = 'terms-conditions'"
                            :class="selectedPolicy === 'terms-conditions' ? 'bg-blue-600/10 text-blue-400 font-semibold' : 'text-slate-650 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-800/60'"
                            class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-left cursor-pointer transition-colors"
                        >
                            <x-admin.icon name="pages" class="w-4.5 h-4.5" />
                            <span>Terms & Conditions</span>
                        </button>
                        <button
                            type="button"
                            @click="selectedPolicy = 'refund-policy'"
                            :class="selectedPolicy === 'refund-policy' ? 'bg-blue-600/10 text-blue-400 font-semibold' : 'text-slate-650 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-800/60'"
                            class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-left cursor-pointer transition-colors"
                        >
                            <x-admin.icon name="pages" class="w-4.5 h-4.5" />
                            <span>Refund & Cancellation</span>
                        </button>
                        <button
                            type="button"
                            @click="selectedPolicy = 'cookie-policy'"
                            :class="selectedPolicy === 'cookie-policy' ? 'bg-blue-600/10 text-blue-400 font-semibold' : 'text-slate-650 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-800/60'"
                            class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-left cursor-pointer transition-colors"
                        >
                            <x-admin.icon name="pages" class="w-4.5 h-4.5" />
                            <span>Cookie Policy</span>
                        </button>
                    </nav>
                </x-admin.card>
            </div>

            <!-- Right panel: Document Editor Form -->
            <div class="lg:col-span-3">
                @foreach ($legalPages as $slug => $doc)
                    <div x-show="selectedPolicy === '{{ $slug }}'" @if(!$loop->first) style="display: none;" @endif>
                        <form action="/admin/legal/{{ $doc->id }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <x-admin.card title="Document Properties">
                                <div class="space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <x-admin.form.input name="legal_title" label="Document Title" :value="$doc->title" :required="true" />
                                        <x-admin.form.input name="legal_slug_display" label="URL Slug" :value="$doc->slug" :readonly="true" />
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <x-admin.form.input name="legal_version" label="Version Control ID" :value="$doc->version" />
                                        <x-admin.form.input name="legal_updated" label="Effective Date" type="date" :value="$doc->effective_date?->format('Y-m-d')" />
                                        <x-admin.form.select name="legal_author" label="Author Role">
                                            <option value="legal" @selected($doc->author_role === 'legal')>Compliance Officer</option>
                                            <option value="admin" @selected($doc->author_role === 'admin')>Administrator</option>
                                        </x-admin.form.select>
                                    </div>

                                    <!-- Rich text body -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Document Body</label>
                                        <textarea name="legal_body" rows="10" class="block w-full rounded-lg border border-slate-300 dark:border-slate-800 bg-white dark:bg-slate-900 p-3 text-xs text-slate-850 dark:text-slate-200 focus-ring" placeholder="Add terms and legal boilerplate...">{{ $doc->content }}</textarea>
                                    </div>
                                </div>
                            </x-admin.card>

                            <!-- SEO settings card -->
                            <x-admin.card title="Compliance Search Indexing Options">
                                <div class="space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <x-admin.form.input name="legal_seo_title" label="Meta Title override" placeholder="Defaults to document name" :value="$doc->seo_title" />
                                        <x-admin.form.input name="legal_canonical" label="Canonical URL" :value="$doc->canonical" />
                                    </div>
                                    <x-admin.form.textarea name="legal_meta_desc" label="Meta Description" placeholder="Keep under 160 characters..." :rows="2" :value="$doc->meta_description" />

                                    <div class="flex items-center gap-3 mt-2">
                                        <x-admin.form.toggle name="legal_noindex" label="Apply noindex meta header" :value="$doc->noindex" help="Hides this page from public Google search queries (useful for internal terms drafts)." />
                                    </div>
                                </div>
                            </x-admin.card>

                            <div class="flex justify-end gap-3">
                                <x-admin.button type="submit" variant="primary">
                                    Publish Update
                                </x-admin.button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-layouts.admin>
