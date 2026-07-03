<x-layouts.admin active="pages">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Static Pages Layouts']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6" x-data="{ selectedPage: { id: null, name: '', route: '', title: '', desc: '', status: true } }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Static Pages Management</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure meta tags, hero banners, and active sitemap index parameters for core marketing pages.</p>
            </div>
        </div>

        <!-- Static pages layout logs -->
        <x-admin.card :padding="false">
            <x-admin.table :headers="['Page Name', 'Route Path', 'SEO Meta Title', 'Status', 'Actions']">
                @foreach ($pages as $page)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-850/20 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-900 dark:text-white text-xs block leading-tight">{{ $page->name }}</span>
                            <span class="text-[9px] text-slate-400 block mt-0.5">Updated {{ $page->updated_at->diffForHumans() }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs font-mono text-slate-650 dark:text-slate-400">
                            {{ $page->route }}
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-700 dark:text-slate-350 max-w-xs truncate">
                            {{ $page->seo_title }}
                        </td>
                        <td class="px-6 py-4">
                            <x-admin.toggle-form :action="'/admin/pages/'.$page->id.'/toggle-active'" :active="$page->is_active" />
                        </td>
                        <td class="px-6 py-4">
                            <x-admin.button
                                type="button"
                                variant="secondary"
                                size="xs"
                                @click="
                                    selectedPage = {
                                        id: {{ $page->id }},
                                        name: '{{ addslashes($page->name) }}',
                                        route: '{{ $page->route }}',
                                        title: '{{ addslashes($page->seo_title ?? '') }}',
                                        desc: '{{ addslashes($page->content ?? '') }}',
                                        status: {{ $page->is_active ? 'true' : 'false' }}
                                    };
                                    $dispatch('open-drawer', 'edit-page-drawer');
                                "
                            >
                                <x-admin.icon name="pencil" class="w-3.5 h-3.5 mr-1" />
                                <span>SEO Config</span>
                            </x-admin.button>
                        </td>
                    </tr>
                @endforeach
            </x-admin.table>
        </x-admin.card>

        <!-- Edit page slide-over drawer -->
        <x-admin.drawer name="edit-page-drawer" title="Static Page Page Builder">
            <div class="space-y-6">
                <!-- Page spec panel -->
                <div class="p-4 border border-slate-100 dark:border-slate-800 rounded-xl bg-slate-50/20 dark:bg-slate-900/10">
                    <span class="text-2xs font-semibold text-slate-500 uppercase block mb-1">Editing Layout</span>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white" x-text="selectedPage.name"></h3>
                    <span class="text-xs font-mono text-slate-500 mt-1 block" x-text="'Route path: ' + selectedPage.route"></span>
                </div>

                <form :action="selectedPage.id ? '/admin/pages/' + selectedPage.id : ''" method="POST" enctype="multipart/form-data" id="page-update-form" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <x-admin.form.input name="seo_meta_title" label="SEO Page Title" x-bind:value="selectedPage.title" :required="true" />
                    <x-admin.form.textarea name="seo_meta_desc" label="SEO Meta Description" placeholder="Keep under 160 characters..." :rows="3" />

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Hero Section Header Banner</label>
                        <label class="block border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-lg p-5 text-center cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-850 transition-colors">
                            <x-admin.icon name="upload" class="w-8 h-8 text-slate-400 mx-auto" />
                            <span class="text-xs font-semibold text-slate-650 dark:text-slate-350 block mt-2">Upload Hero Background Asset</span>
                            <input type="file" name="hero_image" accept="image/*" class="hidden" onchange="this.closest('label').querySelector('span').textContent = this.files[0]?.name || 'Upload Hero Background Asset'">
                        </label>
                    </div>

                    <x-admin.form.textarea name="mock_content" label="HTML Content Blocks" x-bind:value="selectedPage.desc" :rows="4" />
                </form>
            </div>

            <x-slot:footer>
                <x-admin.button type="submit" form="page-update-form" variant="primary" size="sm">Save Configuration</x-admin.button>
                <x-admin.button type="button" variant="secondary" size="sm" @click="$dispatch('close-drawer')">Cancel</x-admin.button>
            </x-slot:footer>
        </x-admin.drawer>

    </div>
</x-layouts.admin>
