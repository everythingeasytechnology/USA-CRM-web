<header class="sticky top-0 z-40 flex h-16 w-full shrink-0 items-center justify-between border-b border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md px-4 sm:px-6 shadow-xs select-none">
    
    <!-- Left Section: Mobile Menu & Global Search Trigger -->
    <div class="flex items-center gap-4 flex-1">
        <!-- Mobile menu toggle -->
        <button 
            type="button" 
            @click="mobileSidebarOpen = true" 
            class="text-slate-500 hover:text-slate-650 dark:hover:text-slate-350 lg:hidden cursor-pointer"
        >
            <span class="sr-only">Open sidebar</span>
            <x-admin.icon name="bars-3" class="w-6 h-6" />
        </button>

        <!-- Command Palette / Search Trigger Button -->
        <button 
            type="button" 
            @click="$dispatch('open-modal', 'search-modal')"
            class="hidden sm:flex items-center gap-2 px-3 py-1.5 text-sm text-slate-400 bg-slate-50 hover:bg-slate-100 dark:bg-slate-800/40 dark:hover:bg-slate-800/80 border border-slate-200 dark:border-slate-800 rounded-lg max-w-xs w-full text-left transition-colors cursor-pointer"
        >
            <x-admin.icon name="search" class="w-4 h-4 text-slate-400 flex-shrink-0" />
            <span class="flex-1 text-xs">Search anywhere...</span>
            <kbd class="font-sans text-[10px] bg-white border border-slate-250 dark:bg-slate-900 dark:border-slate-700 px-1.5 py-0.5 rounded-sm shadow-2xs text-slate-500">⌘K</kbd>
        </button>
    </div>

    <!-- Right Section: Tools, Theme Switcher, Notifications, Profile Dropdown -->
    <div class="flex items-center gap-4">
        
        <!-- Theme Toggle Switcher -->
        <button 
            type="button" 
            @click="darkMode = !darkMode" 
            class="p-2 text-slate-450 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-200 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer"
            aria-label="Toggle dark mode"
        >
            <!-- Moon SVG (shows in light mode) -->
            <svg x-show="!darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
            </svg>
            <!-- Sun SVG (shows in dark mode) -->
            <svg x-show="darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m0 13.5V21M4.22 4.22l1.68 1.68m12.202 12.202l1.68 1.68m-17.65 0l1.68-1.68m12.202-12.202l1.68-1.68M3 12h2.25m13.5 0H21M12 7.5a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9Z" />
            </svg>
        </button>

        <!-- Notifications Dropdown (Alpine) -->
        <div 
            x-data="{ open: false }" 
            @click.away="open = false" 
            class="relative"
        >
            <button 
                type="button" 
                @click="open = !open" 
                class="relative p-2 text-slate-450 hover:text-slate-650 dark:text-slate-400 dark:hover:text-slate-200 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer"
            >
                <span class="sr-only">Notifications</span>
                <x-admin.icon name="bell" class="w-5 h-5" />
                <span class="absolute top-1.5 right-1.5 h-2 w-2 rounded-full bg-blue-600 ring-2 ring-white dark:ring-slate-900"></span>
            </button>
            
            <!-- Dropdown Menu panel -->
            <div 
                x-show="open" 
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-2.5 w-80 origin-top-right rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg ring-1 ring-black/5 focus:outline-none"
                style="display: none;"
            >
                <div class="px-4 py-3 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-900 dark:text-white">Notifications</span>
                    <button type="button" class="text-xs font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">Mark all read</button>
                </div>
                <div class="max-h-72 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-800">
                    <a href="#leads" class="flex p-4 hover:bg-slate-50 dark:hover:bg-slate-850/50">
                        <div class="mr-3 h-8 w-8 rounded-lg bg-blue-50 dark:bg-blue-550/10 flex items-center justify-center text-blue-600">
                            <x-admin.icon name="leads" class="w-4 h-4" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-slate-800 dark:text-slate-250 truncate">New lead from Contact Form</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">Akhil Golu • 2 minutes ago</p>
                        </div>
                    </a>
                    <a href="#orders" class="flex p-4 hover:bg-slate-50 dark:hover:bg-slate-850/50">
                        <div class="mr-3 h-8 w-8 rounded-lg bg-emerald-50 dark:bg-emerald-550/10 flex items-center justify-center text-emerald-600">
                            <x-admin.icon name="orders" class="w-4 h-4" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-slate-800 dark:text-slate-250 truncate">New order placed</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">Package: SEO Maintenance Plan • 1 hour ago</p>
                        </div>
                    </a>
                    <a href="#system" class="flex p-4 hover:bg-slate-50 dark:hover:bg-slate-850/50">
                        <div class="mr-3 h-8 w-8 rounded-lg bg-amber-50 dark:bg-amber-550/10 flex items-center justify-center text-amber-600">
                            <x-admin.icon name="warning" class="w-4 h-4" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-slate-800 dark:text-slate-250 truncate">Sitemap update failed</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">Google API response timeout • 3 hours ago</p>
                        </div>
                    </a>
                </div>
                <div class="px-4 py-2 border-t border-slate-200 dark:border-slate-800 text-center">
                    <a href="#notifications" class="text-xs font-semibold text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-250">View all notifications</a>
                </div>
            </div>
        </div>

        <!-- User Profile Dropdown (Alpine) -->
        <div 
            x-data="{ open: false }" 
            @click.away="open = false" 
            class="relative"
        >
            <button 
                type="button" 
                @click="open = !open" 
                class="flex items-center gap-2 cursor-pointer focus:outline-none"
            >
                <div class="h-9 w-9 rounded-full bg-slate-100 border border-slate-250 dark:bg-slate-800 dark:border-slate-750 flex items-center justify-center text-slate-700 dark:text-slate-200 font-bold text-sm shadow-2xs">
                    AG
                </div>
            </button>
            
            <div 
                x-show="open" 
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-2.5 w-56 origin-top-right rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg ring-1 ring-black/5 focus:outline-none"
                style="display: none;"
            >
                <div class="px-4 py-3 border-b border-slate-200 dark:border-slate-800">
                    <p class="text-sm font-semibold text-slate-950 dark:text-white truncate">Akhil Golu</p>
                    <p class="text-xs text-slate-550 dark:text-slate-400 truncate mt-0.5">akhil@everythingeasy.in</p>
                </div>
                
                <!-- Role Switcher Panel -->
                <div class="px-4 py-2 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-850/20">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wide block mb-1">Active Role</span>
                    <select class="w-full text-xs font-semibold bg-white dark:bg-slate-900 border border-slate-250 dark:border-slate-700 rounded-md py-1 px-2 text-slate-700 dark:text-slate-350 focus:outline-none cursor-pointer focus:ring-1 focus:ring-blue-500">
                        <option value="admin">Administrator</option>
                        <option value="editor">Editor</option>
                        <option value="seo">SEO Manager</option>
                        <option value="writer">Content Writer</option>
                        <option value="sales">Sales Team</option>
                    </select>
                </div>
                
                <div class="py-1">
                    <a href="#settings" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-850/50">
                        <x-admin.icon name="settings" class="w-4.5 h-4.5 text-slate-450" />
                        <span>Settings</span>
                    </a>
                    <a href="#users" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-850/50">
                        <x-admin.icon name="users" class="w-4.5 h-4.5 text-slate-450" />
                        <span>Team Management</span>
                    </a>
                </div>
                <div class="py-1 border-t border-slate-200 dark:border-slate-800">
                    <a href="/admin/login" class="flex items-center gap-2 px-4 py-2 text-sm text-red-650 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/20">
                        <x-admin.icon name="logout" class="w-4.5 h-4.5" />
                        <span>Sign Out</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
