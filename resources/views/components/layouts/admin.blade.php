<!DOCTYPE html>
<html 
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ 
        darkMode: localStorage.getItem('darkMode') === 'true', 
        mobileSidebarOpen: false 
    }"
    x-init="
        $watch('darkMode', val => { 
            localStorage.setItem('darkMode', val); 
            if (val) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        });
        if (darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    "
    class="h-full scroll-smooth"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'EverythingEasy Admin')</title>

    <!-- Preconnect Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Vite Styles & Scripts Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-50 dark:bg-slate-950 font-sans text-slate-900 dark:text-slate-100 antialiased selection:bg-blue-500/30">

    <div class="min-h-full flex">
        
        <!-- Desktop Fixed Sidebar -->
        <div class="hidden lg:flex lg:w-64 lg:flex-col lg:fixed lg:inset-y-0 z-30">
            <x-admin.sidebar :active="$active ?? 'dashboard'" />
        </div>

        <!-- Mobile Drawer Sidebar (Alpine Overlay) -->
        <div 
            x-show="mobileSidebarOpen" 
            class="relative z-50 lg:hidden" 
            role="dialog" 
            aria-modal="true"
            style="display: none;"
        >
            <!-- Backdrop -->
            <div 
                x-show="mobileSidebarOpen"
                x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-slate-900/80"
                @click="mobileSidebarOpen = false"
            ></div>

            <!-- Slider Wrapper -->
            <div class="fixed inset-0 flex">
                <div 
                    x-show="mobileSidebarOpen"
                    x-transition:enter="transition ease-in-out duration-300 transform"
                    x-transition:enter-start="-translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in-out duration-300 transform"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="-translate-x-full"
                    class="relative mr-16 flex w-full max-w-xs flex-1"
                >
                    <!-- Close button -->
                    <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                        <button 
                            type="button" 
                            @click="mobileSidebarOpen = false" 
                            class="-m-2.5 p-2.5 text-white cursor-pointer"
                        >
                            <span class="sr-only">Close sidebar</span>
                            <x-admin.icon name="x-mark" class="w-6 h-6" />
                        </button>
                    </div>

                    <!-- Sidebar content render -->
                    <div class="w-full">
                        <x-admin.sidebar :active="$active ?? 'dashboard'" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Page Layout Panel Container -->
        <div class="flex flex-col flex-1 lg:pl-64 min-w-0">
            <!-- Header Nav -->
            <x-admin.header />

            <!-- Content Area -->
            <main class="flex-1 py-6 px-4 sm:px-6 lg:px-8">
                <!-- Breadcrumbs container slot -->
                @if (isset($breadcrumbs))
                    <div class="mb-5">
                        {{ $breadcrumbs }}
                    </div>
                @endif

                <!-- Page core content -->
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Reusable Command Palette / Search Modal (Global) -->
    <x-admin.modal name="search-modal" title="Anti Gravity Search" maxW="lg">
        <div x-data="{ searchQuery: '' }" class="space-y-4">
            <!-- Search Input Box -->
            <div class="relative">
                <input 
                    type="text" 
                    x-model="searchQuery" 
                    placeholder="Type page name or search parameter (e.g. SEO, Leads)..." 
                    class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg focus-ring text-slate-800 dark:text-slate-100 placeholder-slate-400"
                    x-init="$el.focus()"
                />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <x-admin.icon name="search" class="w-5 h-5 text-slate-400" />
                </div>
            </div>

            <!-- Helper label/status -->
            <div class="text-2xs font-bold text-slate-400 uppercase tracking-wider">
                Quick Navigation Suggestions
            </div>

            <!-- List suggestions -->
            <div class="divide-y divide-slate-100 dark:divide-slate-800/60 max-h-60 overflow-y-auto">
                <!-- Suggestion Item -->
                <a href="#settings" class="flex items-center justify-between p-3 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-850 transition-colors">
                    <div class="flex items-center gap-3">
                        <x-admin.icon name="settings" class="w-4.5 h-4.5 text-slate-400" />
                        <span class="text-xs font-semibold text-slate-850 dark:text-slate-200">Go to Website Settings</span>
                    </div>
                    <kbd class="text-[10px] text-slate-400 border border-slate-200 dark:border-slate-800 px-1 py-0.5 rounded-sm">S</kbd>
                </a>
                
                <!-- Suggestion Item -->
                <a href="#leads" class="flex items-center justify-between p-3 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-850 transition-colors">
                    <div class="flex items-center gap-3">
                        <x-admin.icon name="leads" class="w-4.5 h-4.5 text-slate-400" />
                        <span class="text-xs font-semibold text-slate-850 dark:text-slate-200">View Recent Leads</span>
                    </div>
                    <kbd class="text-[10px] text-slate-400 border border-slate-200 dark:border-slate-800 px-1 py-0.5 rounded-sm">L</kbd>
                </a>

                <!-- Suggestion Item -->
                <a href="#seo" class="flex items-center justify-between p-3 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-850 transition-colors">
                    <div class="flex items-center gap-3">
                        <x-admin.icon name="seo" class="w-4.5 h-4.5 text-slate-400" />
                        <span class="text-xs font-semibold text-slate-850 dark:text-slate-200">Open SEO Schema Manager</span>
                    </div>
                    <kbd class="text-[10px] text-slate-400 border border-slate-200 dark:border-slate-800 px-1 py-0.5 rounded-sm">E</kbd>
                </a>

                <!-- Suggestion Item -->
                <a href="#media" class="flex items-center justify-between p-3 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-850 transition-colors">
                    <div class="flex items-center gap-3">
                        <x-admin.icon name="media" class="w-4.5 h-4.5 text-slate-400" />
                        <span class="text-xs font-semibold text-slate-850 dark:text-slate-200">Open Media Library</span>
                    </div>
                    <kbd class="text-[10px] text-slate-400 border border-slate-200 dark:border-slate-800 px-1 py-0.5 rounded-sm">M</kbd>
                </a>
            </div>

            <!-- Footer indicator keys -->
            <div class="flex justify-between items-center text-3xs text-slate-450 border-t border-slate-100 dark:border-slate-800 pt-3 select-none">
                <span>Navigate with <kbd>↑</kbd> <kbd>↓</kbd></span>
                <span>Press <kbd>ESC</kbd> to close</span>
            </div>
        </div>
    </x-admin.modal>

    <!-- Global Key Bindings for Cmd+K search trigger -->
    <script>
        window.addEventListener('keydown', (e) => {
            if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault();
                window.dispatchEvent(new CustomEvent('open-modal', { detail: 'search-modal' }));
            }
        });
    </script>
</body>
</html>
