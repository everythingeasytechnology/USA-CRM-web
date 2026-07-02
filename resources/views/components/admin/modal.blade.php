@props([
    'name',
    'title' => null,
    'maxW' => 'md',
])

@php
    $maxWClasses = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        '3xl' => 'sm:max-w-3xl',
        '4xl' => 'sm:max-w-4xl',
        '5xl' => 'sm:max-w-5xl',
        '7xl' => 'sm:max-w-7xl',
    ][$maxW] ?? 'sm:max-w-md';
@endphp

<div 
    x-data="{ show: false }"
    x-on:open-modal.window="if ($event.detail === '{{ $name }}') show = true"
    x-on:close-modal.window="show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    <!-- Backdrop Overlay -->
    <div 
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-slate-900/60 dark:backdrop-blur-xs transition-opacity"
        @click="show = false"
    ></div>

    <!-- Centered Content Positioner -->
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div 
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative transform overflow-hidden rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-left shadow-xl transition-all sm:my-8 w-full {{ $maxWClasses }}"
        >
            <!-- Modal Header -->
            <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                @if ($title)
                    <h3 class="text-base font-semibold leading-6 text-slate-900 dark:text-white">
                        {{ $title }}
                    </h3>
                @else
                    <div></div>
                @endif
                <button 
                    type="button" 
                    @click="show = false"
                    class="rounded-lg text-slate-400 hover:text-slate-500 dark:hover:text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer"
                >
                    <span class="sr-only">Close</span>
                    <x-admin.icon name="x-mark" class="w-5 h-5" />
                </button>
            </div>

            <!-- Modal Content Body -->
            <div class="px-6 py-5">
                {{ $slot }}
            </div>

            <!-- Modal Action Footer -->
            @if (isset($footer))
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-t border-slate-200 dark:border-slate-800 flex flex-row-reverse gap-3">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
