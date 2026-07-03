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
            <x-admin.table :headers="['Article Title', 'Category', 'Read Time', 'Publish Date', 'Status', 'Actions']">
                @forelse ($blogs as $post)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-850/20 transition-colors">
                        <td class="px-6 py-4 max-w-xs sm:max-w-md">
                            <span class="font-bold text-slate-900 dark:text-white text-xs block truncate" title="{{ $post->title }}">{{ $post->title }}</span>
                            <span class="text-[10px] text-slate-400 block mt-0.5">/blog/{{ $post->slug }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-700 dark:text-slate-350">
                            {{ $post->category }}
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-450">
                            {{ $post->read_time }}
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-650 dark:text-slate-400">
                            {{ $post->created_at->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-4">
                            <x-admin.toggle-form :action="'/admin/blogs/'.$post->id.'/toggle-active'" :active="$post->is_published" />
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                <x-admin.button variant="ghost" size="xs" href="/admin/blogs/{{ $post->id }}/edit" title="Edit Article">
                                    <x-admin.icon name="pencil" class="w-4 h-4 text-slate-500" />
                                </x-admin.button>
                                <form method="POST" action="/admin/blogs/{{ $post->id }}/duplicate">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center justify-center p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer" title="Duplicate Article">
                                        <x-admin.icon name="duplicate" class="w-4 h-4 text-slate-500" />
                                    </button>
                                </form>
                                <x-admin.delete-form :action="'/admin/blogs/'.$post->id" confirm="Delete this article permanently?">
                                    <button type="submit" class="inline-flex items-center justify-center p-1.5 rounded-lg text-red-500 hover:text-red-650 hover:bg-red-50 dark:hover:bg-red-950/30 cursor-pointer" title="Delete Article">
                                        <x-admin.icon name="trash" class="w-4 h-4" />
                                    </button>
                                </x-admin.delete-form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-xs text-slate-400">No articles written yet.</td>
                    </tr>
                @endforelse
            </x-admin.table>

            <x-admin.pagination :currentPage="1" :totalPages="1" :totalResults="$blogs->count()" :perPage="max($blogs->count(), 1)" />
        </x-admin.card>
    </div>
</x-layouts.admin>
