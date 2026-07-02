@props([
    'currentPage' => 1,
    'totalPages' => 10,
    'totalResults' => 100,
    'perPage' => 10,
])

@php
    $start = (($currentPage - 1) * $perPage) + 1;
    $end = min($currentPage * $perPage, $totalResults);
@endphp

<div class="flex items-center justify-between border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-3 sm:px-6 mt-4">
    <!-- Mobile Pagination -->
    <div class="flex flex-1 justify-between sm:hidden">
        <x-admin.button variant="secondary" size="sm" :disabled="$currentPage <= 1">
            Previous
        </x-admin.button>
        <x-admin.button variant="secondary" size="sm" :disabled="$currentPage >= $totalPages">
            Next
        </x-admin.button>
    </div>

    <!-- Desktop Pagination -->
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
        <!-- Result count message -->
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Showing
                <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $start }}</span>
                to
                <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $end }}</span>
                of
                <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $totalResults }}</span>
                results
            </p>
        </div>
        
        <!-- Pagination controls -->
        <div>
            <nav class="isolate inline-flex -space-x-px rounded-md shadow-xs" aria-label="Pagination">
                <!-- Previous Button -->
                <button 
                    type="button" 
                    @disabled($currentPage <= 1)
                    class="relative inline-flex items-center rounded-l-md px-2 py-2 text-slate-400 border border-slate-200 dark:border-slate-850 hover:bg-slate-50 dark:hover:bg-slate-800/50 disabled:opacity-50 disabled:pointer-events-none cursor-pointer focus:z-20 focus:outline-none"
                >
                    <span class="sr-only">Previous</span>
                    <x-admin.icon name="chevron-left" class="h-5 w-5" />
                </button>
                
                <!-- Page Numbers -->
                @for ($i = 1; $i <= min($totalPages, 5); $i++)
                    <button 
                        type="button"
                        class="relative inline-flex items-center border px-4 py-2 text-sm font-semibold focus:z-20 cursor-pointer focus:outline-none {{ $currentPage === $i 
                            ? 'z-10 bg-blue-600 border-blue-600 text-white dark:bg-blue-500 dark:border-blue-500' 
                            : 'border-slate-200 dark:border-slate-850 text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800/50' 
                        }}"
                    >
                        {{ $i }}
                    </button>
                @endfor
                
                @if ($totalPages > 5)
                    <span class="relative inline-flex items-center border border-slate-200 dark:border-slate-850 px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300">...</span>
                    <button 
                        type="button"
                        class="relative inline-flex items-center border border-slate-200 dark:border-slate-850 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800/50 cursor-pointer focus:outline-none"
                    >
                        {{ $totalPages }}
                    </button>
                @endif

                <!-- Next Button -->
                <button 
                    type="button" 
                    @disabled($currentPage >= $totalPages)
                    class="relative inline-flex items-center rounded-r-md px-2 py-2 text-slate-400 border border-slate-200 dark:border-slate-850 hover:bg-slate-50 dark:hover:bg-slate-800/50 disabled:opacity-50 disabled:pointer-events-none cursor-pointer focus:z-20 focus:outline-none"
                >
                    <span class="sr-only">Next</span>
                    <x-admin.icon name="chevron-right" class="h-5 w-5" />
                </button>
            </nav>
        </div>
    </div>
</div>
