@props([
    'name',
    'title' => null,
    'maxW' => 'md',
])

@php
    $maxWClasses = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
    ][$maxW] ?? 'max-w-md';
@endphp

<div 
    x-data="{ show: false }"
    x-on:open-drawer.window="if ($event.detail === '{{ $name }}') show = true"
    x-on:close-drawer.window="show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    class="fixed inset-0 z-50 overflow-hidden"
    style="display: none;"
>
    <!-- Background Overlay -->
    <div 
        x-show="show"
        x-transition:enter="ease-in-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in-out duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute inset-0 bg-slate-900/60 dark:backdrop-blur-xs transition-opacity"
        @click="show = false"
    ></div>

    <!-- Drawer Slider Positioner -->
    <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
        <div 
            x-show="show"
            x-transition:enter="transform transition ease-in-out duration-300 sm:duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-300 sm:duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="w-screen {{ $maxWClasses }} pointer-events-auto"
        >
            <div class="flex h-full flex-col bg-white dark:bg-slate-900 border-l border-slate-200 dark:border-slate-800 shadow-2xl">
                <!-- Drawer Header -->
                <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                    @if ($title)
                        <h2 class="text-base font-semibold leading-6 text-slate-900 dark:text-white">
                            {{ $title }}
                        </h2>
                    @else
                        <div></div>
                    @endif
                    <button 
                        type="button" 
                        @click="show = false"
                        class="rounded-lg text-slate-400 hover:text-slate-500 dark:hover:text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer"
                    >
                        <span class="sr-only">Close panel</span>
                        <x-admin.icon name="x-mark" class="w-5 h-5" />
                    </button>
                </div>

                <!-- Drawer Content (Scrollable Container) -->
                <div class="relative flex-1 overflow-y-auto px-6 py-5">
                    {{ $slot }}
                </div>

                <!-- Drawer Footer Actions -->
                @if (isset($footer))
                    <div class="px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-t border-slate-200 dark:border-slate-800 flex flex-row-reverse gap-3">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
