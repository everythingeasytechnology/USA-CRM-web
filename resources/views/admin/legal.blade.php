<x-layouts.admin active="legal">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Legal Compliance Panels']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6" x-data="{ selectedPolicy: 'privacy' }">
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
                            @click="selectedPolicy = 'privacy'" 
                            :class="selectedPolicy === 'privacy' ? 'bg-blue-600/10 text-blue-400 font-semibold' : 'text-slate-650 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-800/60'"
                            class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-left cursor-pointer transition-colors"
                        >
                            <x-admin.icon name="pages" class="w-4.5 h-4.5" />
                            <span>Privacy Policy</span>
                        </button>
                        <button 
                            type="button" 
                            @click="selectedPolicy = 'terms'" 
                            :class="selectedPolicy === 'terms' ? 'bg-blue-600/10 text-blue-400 font-semibold' : 'text-slate-650 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-800/60'"
                            class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-left cursor-pointer transition-colors"
                        >
                            <x-admin.icon name="pages" class="w-4.5 h-4.5" />
                            <span>Terms & Conditions</span>
                        </button>
                        <button 
                            type="button" 
                            @click="selectedPolicy = 'refund'" 
                            :class="selectedPolicy === 'refund' ? 'bg-blue-600/10 text-blue-400 font-semibold' : 'text-slate-650 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-800/60'"
                            class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-left cursor-pointer transition-colors"
                        >
                            <x-admin.icon name="pages" class="w-4.5 h-4.5" />
                            <span>Refund & Cancellation</span>
                        </button>
                        <button 
                            type="button" 
                            @click="selectedPolicy = 'cookie'" 
                            :class="selectedPolicy === 'cookie' ? 'bg-blue-600/10 text-blue-400 font-semibold' : 'text-slate-650 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-800/60'"
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
                <form action="#save-legal" method="POST" class="space-y-6" @submit.prevent="alert('Legal compliance document updated!')">
                    
                    <x-admin.card title="Document Properties">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-admin.form.input name="legal_title" label="Document Title" x-bind:value="selectedPolicy === 'privacy' ? 'Privacy Policy' : (selectedPolicy === 'terms' ? 'Terms & Conditions' : 'Refund & Cancellation Policy')" :required="true" />
                                <x-admin.form.input name="legal_slug" label="URL Slug" x-bind:value="selectedPolicy === 'privacy' ? 'privacy-policy' : (selectedPolicy === 'terms' ? 'terms-conditions' : 'refund-policy')" :required="true" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <x-admin.form.input name="legal_version" label="Version Control ID" value="v2.4 (Active)" />
                                <x-admin.form.input name="legal_updated" label="Effective Date" type="date" value="2026-07-02" />
                                <x-admin.form.select name="legal_author" label="Author Role">
                                    <option value="legal">Compliance Officer</option>
                                    <option value="admin">Administrator</option>
                                </x-admin.form.select>
                            </div>

                            <!-- Rich text body -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Document Body</label>
                                <textarea name="legal_body" rows="10" class="block w-full rounded-lg border border-slate-300 dark:border-slate-800 bg-white dark:bg-slate-900 p-3 text-xs text-slate-850 dark:text-slate-200 focus-ring" placeholder="Add terms and legal boilerplate..."></textarea>
                            </div>
                        </div>
                    </x-admin.card>

                    <!-- SEO settings card -->
                    <x-admin.card title="Compliance Search Indexing Options">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-admin.form.input name="legal_seo_title" label="Meta Title override" placeholder="Defaults to document name" />
                                <x-admin.form.input name="legal_canonical" label="Canonical URL" />
                            </div>
                            <x-admin.form.textarea name="legal_meta_desc" label="Meta Description" placeholder="Keep under 160 characters..." :rows="2" />
                            
                            <div class="flex items-center gap-3 mt-2">
                                <x-admin.form.toggle name="legal_noindex" label="Apply noindex meta header" help="Hides this page from public Google search queries (useful for internal terms drafts)." />
                            </div>
                        </div>
                    </x-admin.card>

                    <div class="flex justify-end gap-3">
                        <x-admin.button type="submit" variant="primary">
                            Publish Update
                        </x-admin.button>
                        <x-admin.button type="button" variant="secondary" @click="alert('Draft version saved!')">
                            Save Draft
                        </x-admin.button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-layouts.admin>
