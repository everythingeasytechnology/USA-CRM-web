<x-layouts.admin active="media">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Media Library']]" />
    </x-slot:breadcrumbs>

    <div 
        class="space-y-6" 
        x-data="{ 
            viewMode: 'grid', 
            selectedMedia: null,
            openDrawer: false
        }"
    >
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Media Library</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Upload and manage site images, PDFs, case-study brochures, and logo assets.</p>
            </div>
            <div class="flex items-center gap-2.5">
                <x-admin.button variant="primary" size="sm" @click="$dispatch('open-modal', 'upload-modal')">
                    <x-admin.icon name="upload" class="w-4 h-4 mr-1.5" />
                    <span>Upload Files</span>
                </x-admin.button>
            </div>
        </div>

        <x-admin.modal name="upload-modal" title="Upload Media File" maxW="md">
            <form id="upload-media-form" action="/admin/media" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">File</label>
                    <input type="file" name="file" required class="block w-full text-sm text-slate-700 dark:text-slate-300 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-500/10 dark:file:text-blue-400" />
                </div>
                <x-admin.form.input name="alt_text" label="Alt Text (SEO)" placeholder="Describe this file for accessibility & search engines" />
            </form>
            <x-slot:footer>
                <x-admin.button type="submit" form="upload-media-form" variant="primary" size="sm">Upload</x-admin.button>
                <x-admin.button type="button" variant="secondary" size="sm" @click="$dispatch('close-modal')">Cancel</x-admin.button>
            </x-slot:footer>
        </x-admin.modal>

        <!-- Filters Grid Toolbar -->
        <x-admin.card>
            <div class="flex flex-wrap items-center justify-between gap-4">
                <!-- Left: Search and Filters -->
                <div class="flex items-center gap-3 flex-wrap flex-1 min-w-[280px]">
                    <div class="relative flex-1 max-w-xs">
                        <input 
                            type="text" 
                            placeholder="Search files..." 
                            class="w-full pl-9 pr-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg text-sm bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100"
                        />
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-admin.icon name="search" class="w-4 h-4 text-slate-400" />
                        </div>
                    </div>
                    <select class="text-xs bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg p-2 text-slate-700 dark:text-slate-300">
                        <option value="">All Types</option>
                        <option value="images">Images Only</option>
                        <option value="pdf">PDF Documents</option>
                        <option value="video">Videos</option>
                    </select>
                </div>

                <!-- Right: Toggle Layout button -->
                <div class="flex items-center gap-1.5 border border-slate-200 dark:border-slate-800 rounded-lg p-1 bg-slate-50 dark:bg-slate-900/50">
                    <button 
                        type="button" 
                        @click="viewMode = 'grid'" 
                        :class="viewMode === 'grid' ? 'bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-2xs' : 'text-slate-450 hover:text-slate-600'"
                        class="p-1.5 rounded-md cursor-pointer transition-colors"
                        title="Grid View"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </button>
                    <button 
                        type="button" 
                        @click="viewMode = 'list'" 
                        :class="viewMode === 'list' ? 'bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-2xs' : 'text-slate-450 hover:text-slate-600'"
                        class="p-1.5 rounded-md cursor-pointer transition-colors"
                        title="List View"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </x-admin.card>

        @php
            $fmtSize = fn ($bytes) => $bytes >= 1048576 ? number_format($bytes / 1048576, 1).' MB' : number_format($bytes / 1024).' KB';
            $extOf = fn ($file) => strtolower(pathinfo($file->name, PATHINFO_EXTENSION)) ?: 'file';
        @endphp

        <!-- Grid View Mode -->
        <div x-show="viewMode === 'grid'" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
            @forelse ($files as $file)
                @php $ext = $extOf($file); @endphp
                <div
                    @click="
                        selectedMedia = {
                            id: {{ $file->id }},
                            name: '{{ addslashes($file->name) }}',
                            type: '{{ $ext }}',
                            size: '{{ $fmtSize($file->size) }}',
                            dimensions: '{{ $file->dimensions ?? '—' }}',
                            date: '{{ $file->created_at->format('Y-m-d') }}',
                            url: '{{ $file->url }}',
                            alt: '{{ addslashes($file->alt_text ?? '') }}'
                        };
                        $dispatch('open-drawer', 'media-drawer');
                    "
                    class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden shadow-2xs hover:shadow-md hover:border-blue-500 dark:hover:border-blue-500 transition-all cursor-pointer group"
                >
                    <!-- Preview Canvas -->
                    <div class="h-32 bg-slate-50 dark:bg-slate-950 flex items-center justify-center border-b border-slate-100 dark:border-slate-850 relative">
                        @if (str_starts_with($file->mime_type ?? '', 'image/'))
                            <img src="{{ $file->url }}" class="h-full w-full object-cover" />
                        @elseif ($ext === 'pdf')
                            <span class="p-2 bg-red-100 text-red-650 rounded-lg"><x-admin.icon name="document-text" class="w-6 h-6" /></span>
                        @else
                            <span class="p-2 bg-amber-100 text-amber-650 rounded-lg"><x-admin.icon name="media" class="w-6 h-6" /></span>
                        @endif
                    </div>
                    <!-- Details description footer -->
                    <div class="p-3 text-2xs">
                        <span class="font-bold text-slate-900 dark:text-white block truncate">{{ $file->name }}</span>
                        <div class="flex justify-between items-center text-slate-450 mt-1.5">
                            <span>{{ $fmtSize($file->size) }}</span>
                            <span class="uppercase text-[9px] font-bold bg-slate-100 dark:bg-slate-800 px-1 py-0.5 rounded-sm">{{ $ext }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-xs text-slate-400 py-12">No media files uploaded yet.</div>
            @endforelse
        </div>

        <!-- List View Mode -->
        <div x-show="viewMode === 'list'" style="display: none;">
            <x-admin.card :padding="false">
                <x-admin.table :headers="['File Name', 'Format Type', 'File Size', 'Dimensions', 'Created Date', 'Alt Text']">
                    @foreach ($files as $file)
                        @php $ext = $extOf($file); @endphp
                        <tr
                            class="hover:bg-slate-50/50 dark:hover:bg-slate-850/20 transition-colors cursor-pointer"
                            @click="
                                selectedMedia = {
                                    id: {{ $file->id }},
                                    name: '{{ addslashes($file->name) }}',
                                    type: '{{ $ext }}',
                                    size: '{{ $fmtSize($file->size) }}',
                                    dimensions: '{{ $file->dimensions ?? '—' }}',
                                    date: '{{ $file->created_at->format('Y-m-d') }}',
                                    url: '{{ $file->url }}',
                                    alt: '{{ addslashes($file->alt_text ?? '') }}'
                                };
                                $dispatch('open-drawer', 'media-drawer');
                            "
                        >
                            <td class="px-6 py-4 font-semibold text-xs text-slate-900 dark:text-white truncate max-w-xs">
                                {{ $file->name }}
                            </td>
                            <td class="px-6 py-4 text-2xs uppercase font-bold text-slate-500">
                                {{ $ext }}
                            </td>
                            <td class="px-6 py-4 text-xs font-mono text-slate-700 dark:text-slate-300">
                                {{ $fmtSize($file->size) }}
                            </td>
                            <td class="px-6 py-4 text-xs font-mono text-slate-500">
                                {{ $file->dimensions ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500">
                                {{ $file->created_at->format('Y-m-d') }}
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-550 dark:text-slate-400 max-w-xxs truncate">
                                {{ $file->alt_text }}
                            </td>
                        </tr>
                    @endforeach
                </x-admin.table>
            </x-admin.card>
        </div>

        <!-- Media Edit Side Drawer component -->
        <x-admin.drawer name="media-drawer" title="Media File Attributes" maxW="md">
            <div class="space-y-6" x-show="selectedMedia">
                <!-- Preview -->
                <div class="h-44 bg-slate-50 dark:bg-slate-950 rounded-xl border border-slate-200 dark:border-slate-800 flex items-center justify-center relative overflow-hidden">
                    <img x-show="selectedMedia && ['jpg','jpeg','png','webp','gif'].includes(selectedMedia.type)" x-bind:src="selectedMedia ? selectedMedia.url : ''" class="h-full w-full object-contain" />
                    <span x-show="!selectedMedia || !['jpg','jpeg','png','webp','gif'].includes(selectedMedia.type)" class="text-xs text-slate-400 uppercase font-mono font-bold select-none" x-text="selectedMedia ? selectedMedia.type : ''"></span>
                </div>

                <!-- Attributes lists -->
                <div class="p-4 border border-slate-100 dark:border-slate-850 rounded-xl bg-slate-50/30 dark:bg-slate-900/10 text-xs space-y-2">
                    <div class="flex justify-between"><span class="text-slate-450">File Name:</span><span class="font-bold text-slate-900 dark:text-white" x-text="selectedMedia ? selectedMedia.name : ''"></span></div>
                    <div class="flex justify-between"><span class="text-slate-450">File Type:</span><span class="font-bold uppercase text-slate-700 dark:text-slate-350" x-text="selectedMedia ? selectedMedia.type : ''"></span></div>
                    <div class="flex justify-between"><span class="text-slate-450">File Size:</span><span class="font-mono text-slate-750 dark:text-slate-300" x-text="selectedMedia ? selectedMedia.size : ''"></span></div>
                    <div class="flex justify-between"><span class="text-slate-450">Dimensions:</span><span class="font-mono text-slate-750 dark:text-slate-300" x-text="selectedMedia ? selectedMedia.dimensions : ''"></span></div>
                    <div class="flex justify-between"><span class="text-slate-450">Uploaded On:</span><span class="text-slate-650 dark:text-slate-400" x-text="selectedMedia ? selectedMedia.date : ''"></span></div>
                </div>

                <!-- Input fields -->
                <form :action="selectedMedia ? '/admin/media/' + selectedMedia.id : ''" method="POST" id="media-update-form" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <x-admin.form.input name="alt_text" label="Image Alt text (SEO)" x-bind:value="selectedMedia ? selectedMedia.alt : ''" help="Describe this image to search engines and screen readers" />
                    <x-admin.form.input name="name" label="Media Title" x-bind:value="selectedMedia ? selectedMedia.name : ''" />

                    <!-- Copyable URL field -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">File URL Link</label>
                        <div class="flex gap-2">
                            <input
                                type="text"
                                readonly
                                x-bind:value="selectedMedia ? selectedMedia.url : ''"
                                class="flex-1 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-lg px-3 py-2 text-xs font-mono text-slate-700 dark:text-slate-300"
                            />
                            <x-admin.button type="button" variant="secondary" size="sm" @click="navigator.clipboard.writeText(selectedMedia.url); alert('URL copied to clipboard!')">Copy</x-admin.button>
                        </div>
                    </div>
                </form>
                <form :action="selectedMedia ? '/admin/media/' + selectedMedia.id : ''" method="POST" id="media-delete-form" onsubmit="return confirm('Delete this file permanently?')">
                    @csrf
                    @method('DELETE')
                </form>
            </div>

            <x-slot:footer>
                <x-admin.button type="submit" form="media-update-form" variant="primary" size="sm">Save Metadata</x-admin.button>
                <x-admin.button type="submit" form="media-delete-form" variant="danger" size="sm" class="mr-auto">Delete File</x-admin.button>
            </x-slot:footer>
        </x-admin.drawer>

    </div>
</x-layouts.admin>
