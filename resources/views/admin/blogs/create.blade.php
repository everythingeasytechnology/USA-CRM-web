<x-layouts.admin active="blogs">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[
            ['label' => 'Blog Management', 'url' => '/admin/blogs'],
            ['label' => 'Write Article']
        ]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Write New Article</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Compose blog posts, assign categories, and configure Open Graph schema cards.</p>
        </div>

        <form action="/admin/blogs" method="POST" class="space-y-6" @submit.prevent="alert('Blog article saved successfully!'); window.location='/admin/blogs'">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main columns -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Article Body Editor -->
                    <x-admin.card title="Article Content Builder">
                        <div class="space-y-4">
                            <x-admin.form.input name="title" label="Article Title" placeholder="e.g. 5 Principles of Clean Web Design Layouts" :required="true" />
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-admin.form.input name="slug" label="Article URL Slug" placeholder="e.g. 5-principles-of-clean-web-design" :required="true" />
                                <x-admin.form.select name="category_id" label="Primary Category" :required="true">
                                    <option value="1">Web Development</option>
                                    <option value="2">SEO Insights</option>
                                    <option value="3">Digital Growth</option>
                                </x-admin.form.select>
                            </div>

                            <x-admin.form.textarea name="summary" label="Excerpt / Short Summary" placeholder="Short intro displayed on blog index summaries (keep under 200 characters)..." :rows="2" :required="true" />
                            
                            <!-- Rich Text Editor Placeholder -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Article Body (Markdown / HTML)</label>
                                <!-- Mock Editor toolbar -->
                                <div class="border border-slate-350 dark:border-slate-800 rounded-lg overflow-hidden bg-white dark:bg-slate-900">
                                    <div class="bg-slate-50 dark:bg-slate-850 px-3 py-2 border-b border-slate-300 dark:border-slate-800 flex flex-wrap gap-2 text-slate-500">
                                        <button type="button" class="p-1 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-md font-bold text-xs" onclick="alert('Bold formatted')">B</button>
                                        <button type="button" class="p-1 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-md italic text-xs" onclick="alert('Italic formatted')">I</button>
                                        <button type="button" class="p-1 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-md underline text-xs" onclick="alert('Underline formatted')">U</button>
                                        <span class="border-r border-slate-300 dark:border-slate-700 mx-1"></span>
                                        <button type="button" class="p-1 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-md text-xs font-mono" onclick="alert('Code Block inserted')">&lt;/&gt;</button>
                                        <button type="button" class="p-1 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-md text-xs" onclick="alert('Link inserted')">Link</button>
                                        <button type="button" class="p-1 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-md text-xs" onclick="alert('Image block triggered')">Image</button>
                                    </div>
                                    <textarea name="body" rows="12" class="block w-full border-0 px-3.5 py-3 text-sm focus:ring-0 bg-transparent dark:bg-transparent text-slate-900 dark:text-slate-100 placeholder-slate-450 focus:outline-none" placeholder="Begin typing your rich text article body content here..."></textarea>
                                </div>
                            </div>
                        </div>
                    </x-admin.card>

                    <!-- SEO settings -->
                    <x-admin.card title="SEO & Schema Meta Tags">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-admin.form.input name="seo_title" label="SEO Title Tag" placeholder="e.g. 5 Principles of Clean Web Design | EverythingEasy" />
                                <x-admin.form.input name="canonical" label="Canonical URL Override" />
                            </div>
                            <x-admin.form.textarea name="meta_description" label="Meta Description" placeholder="Keep under 160 characters..." :rows="2" />
                            <x-admin.form.input name="meta_keywords" label="Meta Keywords (Comma separated)" placeholder="web design rules, user experience principles" />
                            
                            <hr class="border-slate-200 dark:border-slate-800" />
                            <x-admin.form.textarea name="article_schema" label="JSON-LD Article Schema Override" placeholder="JSON block schema mapping..." :rows="4" />
                        </div>
                    </x-admin.card>
                </div>

                <!-- Right sidebar: Config and Images -->
                <div class="space-y-6">
                    <!-- Config settings -->
                    <x-admin.card title="Publish Configs">
                        <div class="space-y-4">
                            <x-admin.form.input name="author" label="Author Name" value="Akhil Golu" :required="true" />
                            <div class="grid grid-cols-2 gap-4">
                                <x-admin.form.input name="read_time" label="Reading Time" value="5" help="In minutes" />
                                <x-admin.form.input name="publish_date" type="date" label="Publish Date" value="2026-07-02" />
                            </div>
                            
                            <hr class="border-slate-200 dark:border-slate-800" />
                            
                            <x-admin.form.toggle name="status" label="Publish Instantly" :value="true" />
                            <x-admin.form.toggle name="is_featured" label="Pin Article to Featured" help="Pinned to the top of the blog directory pages." />
                        </div>
                    </x-admin.card>

                    <!-- Article Image Cover -->
                    <x-admin.card title="Featured Cover Image">
                        <div>
                            <div class="border-2 border-dashed border-slate-250 dark:border-slate-850 rounded-lg p-6 text-center cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-900/50 transition-colors">
                                <x-admin.icon name="upload" class="w-10 h-10 text-slate-400 mx-auto" />
                                <span class="text-xs font-semibold text-slate-650 dark:text-slate-350 block mt-2">Click to upload header cover</span>
                                <span class="text-[10px] text-slate-400 block mt-0.5">JPEG, WebP or PNG format (Max 4MB)</span>
                            </div>
                        </div>
                    </x-admin.card>

                    <!-- Save Actions -->
                    <div class="sticky top-20 flex gap-3">
                        <x-admin.button type="submit" variant="primary" class="flex-1">
                            Save Article
                        </x-admin.button>
                        <x-admin.button type="button" variant="secondary" href="/admin/blogs">
                            Cancel
                        </x-admin.button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</x-layouts.admin>
