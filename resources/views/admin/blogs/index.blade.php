<x-layouts.admin active="blogs">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Blog Management']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Blog Articles</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Write, schedule, categorize, and optimize editorial articles for search indexing.</p>
            </div>
            <div class="flex items-center gap-2.5">
                <x-admin.button variant="primary" size="sm" href="/admin/blogs/create">
                    <x-admin.icon name="plus" class="w-4 h-4" />
                    <span>Write Article</span>
                </x-admin.button>
            </div>
        </div>

        <!-- Filters & Search -->
        <x-admin.card>
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="w-full sm:max-w-xs relative">
                    <input 
                        type="text" 
                        placeholder="Search articles..." 
                        class="w-full pl-9 pr-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg text-sm bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100"
                    />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-admin.icon name="search" class="w-4 h-4 text-slate-400" />
                    </div>
                </div>

                <div class="flex items-center gap-2.5 flex-wrap">
                    <select class="text-xs bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg p-2 text-slate-700 dark:text-slate-300">
                        <option value="">All Categories</option>
                        <option value="tech">Web Development</option>
                        <option value="seo">SEO Insights</option>
                        <option value="marketing">Digital Growth</option>
                    </select>
                    <x-admin.button variant="secondary" size="sm">
                        <x-admin.icon name="filters" class="w-4 h-4" />
                        <span>Filter</span>
                    </x-admin.button>
                </div>
            </div>
        </x-admin.card>

        <!-- Blogs List table -->
        <x-admin.card :padding="false">
            <x-admin.table :headers="['Article Title', 'Category', 'Author & Time', 'Publish Date', 'Status', 'SEO Score', 'Actions']">
                @php
                    $blogs = [
                        ['title' => '10 Steps to Migrate to Laravel 12 Viewports', 'cat' => 'Web Development', 'author' => 'Akhil Golu', 'time' => '5 min', 'date' => '2026-07-01', 'status' => true, 'score' => '96%'],
                        ['title' => 'Understanding JSON-LD Organization Schema Rules', 'cat' => 'SEO Insights', 'author' => 'Sarah Connor', 'time' => '8 min', 'date' => '2026-06-28', 'status' => true, 'score' => '92%'],
                        ['title' => 'Designing UI Dashboards like Shopify Admin Layouts', 'cat' => 'Digital Growth', 'author' => 'Diana Prince', 'time' => '4 min', 'date' => '2026-06-25', 'status' => true, 'score' => '81%'],
                        ['title' => 'AI Automation: Resolving Client FAQ Nodes with Bots', 'cat' => 'Web Development', 'author' => 'Bruce Wayne', 'time' => '6 min', 'date' => 'Draft', 'status' => false, 'score' => '89%'],
                    ];
                @endphp

                @foreach ($blogs as $post)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-850/20 transition-colors">
                        <td class="px-6 py-4 max-w-xs sm:max-w-md">
                            <span class="font-bold text-slate-900 dark:text-white text-xs block truncate" title="{{ $post['title'] }}">{{ $post['title'] }}</span>
                            <span class="text-[10px] text-slate-400 block mt-0.5">/blog/{{ Str::slug($post['title']) }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-700 dark:text-slate-350">
                            {{ $post['cat'] }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs text-slate-800 dark:text-slate-200 block">{{ $post['author'] }}</span>
                            <span class="text-[10px] text-slate-450 block mt-0.5">{{ $post['time'] }} reading time</span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-650 dark:text-slate-400">
                            {{ $post['date'] }}
                        </td>
                        <td class="px-6 py-4">
                            <x-admin.form.toggle name="blog_active_{{ $loop->index }}" :value="$post['status']" />
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-2xs font-bold font-mono bg-emerald-50 dark:bg-emerald-950/20 text-emerald-700 dark:text-emerald-400 border border-emerald-255/10">
                                {{ $post['score'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                <x-admin.button variant="ghost" size="xs" href="/admin/blogs/create" title="Edit Article">
                                    <x-admin.icon name="pencil" class="w-4 h-4 text-slate-500" />
                                </x-admin.button>
                                <x-admin.button variant="ghost" size="xs" @click="alert('Article duplicated!')" title="Duplicate Article">
                                    <x-admin.icon name="duplicate" class="w-4 h-4 text-slate-500" />
                                </x-admin.button>
                                <x-admin.button variant="ghost" size="xs" class="text-red-500 hover:text-red-650 hover:bg-red-50 dark:hover:bg-red-950/30" @click="alert('Delete Confirmation')" title="Delete Article">
                                    <x-admin.icon name="trash" class="w-4 h-4" />
                                </x-admin.button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-admin.table>
            
            <x-admin.pagination :currentPage="1" :totalPages="3" :totalResults="12" :perPage="4" />
        </x-admin.card>
    </div>
</x-layouts.admin>
