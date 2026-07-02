@props([
    'items' => [] // Array of arrays: [['label' => 'Dashboard', 'url' => '/admin'], ['label' => 'Settings']]
])

<nav class="flex" aria-label="Breadcrumb">
    <ol role="list" class="flex items-center space-x-2.5">
        <!-- Dashboard Home Base Link -->
        <li>
            <div>
                <a href="/admin" class="text-slate-400 hover:text-slate-500 dark:hover:text-slate-350 transition-colors">
                    <x-admin.icon name="home" class="h-4.5 w-4.5 flex-shrink-0" />
                    <span class="sr-only">Home</span>
                </a>
            </div>
        </li>

        <!-- Dynamically rendered breadcrumb paths -->
        @foreach ($items as $item)
            <li>
                <div class="flex items-center">
                    <x-admin.icon name="chevron-right" class="h-4 w-4 flex-shrink-0 text-slate-300 dark:text-slate-700" />
                    
                    @if (isset($item['url']) && !$loop->last)
                        <a 
                            href="{{ $item['url'] }}" 
                            class="ml-2.5 text-sm font-medium text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 transition-colors"
                        >
                            {{ $item['label'] }}
                        </a>
                    @else
                        <span 
                            class="ml-2.5 text-sm font-medium text-slate-800 dark:text-slate-100" 
                            aria-current="page"
                        >
                            {{ $item['label'] }}
                        </span>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>
