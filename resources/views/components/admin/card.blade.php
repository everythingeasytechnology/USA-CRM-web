@props([
    'title' => null,
    'subtitle' => null,
    'padding' => true,
])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-xs overflow-hidden']) }}>
    <!-- Card Header -->
    @if ($title || $subtitle || isset($actions))
        <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between gap-4 flex-wrap">
            <div>
                @if ($title)
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white leading-6">
                        {{ $title }}
                    </h3>
                @endif
                @if ($subtitle)
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
            @if (isset($actions))
                <div class="flex items-center gap-2">
                    {{ $actions }}
                </div>
            @endif
        </div>
    @endif

    <!-- Card Body -->
    <div class="{{ $padding ? 'p-6' : '' }}">
        {{ $slot }}
    </div>

    <!-- Card Footer -->
    @if (isset($footer))
        <div class="px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between gap-4">
            {{ $footer }}
        </div>
    @endif
</div>
