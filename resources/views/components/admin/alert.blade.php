@props([
    'variant' => 'info',
    'title' => null,
    'dismissible' => true,
])

@php
    $variants = [
        'success' => [
            'bg' => 'bg-emerald-50 dark:bg-emerald-950/20',
            'border' => 'border-emerald-200 dark:border-emerald-800/30',
            'text' => 'text-emerald-800 dark:text-emerald-300',
            'icon' => 'check',
            'iconColor' => 'text-emerald-500',
        ],
        'danger' => [
            'bg' => 'bg-red-50 dark:bg-red-950/20',
            'border' => 'border-red-200 dark:border-red-800/30',
            'text' => 'text-red-800 dark:text-red-300',
            'icon' => 'exclamation-triangle',
            'iconColor' => 'text-red-500',
        ],
        'warning' => [
            'bg' => 'bg-amber-50 dark:bg-amber-950/20',
            'border' => 'border-amber-200 dark:border-amber-800/30',
            'text' => 'text-amber-800 dark:text-amber-300',
            'icon' => 'exclamation-triangle',
            'iconColor' => 'text-amber-500',
        ],
        'info' => [
            'bg' => 'bg-blue-50 dark:bg-blue-950/20',
            'border' => 'border-blue-200 dark:border-blue-800/30',
            'text' => 'text-blue-800 dark:text-blue-300',
            'icon' => 'info',
            'iconColor' => 'text-blue-500',
        ],
    ];
    
    $style = $variants[$variant] ?? $variants['info'];
@endphp

<div 
    x-data="{ show: true }" 
    x-show="show" 
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="flex p-4 rounded-lg border {{ $style['bg'] }} {{ $style['border'] }} {{ $style['text'] }} shadow-xs" 
    role="alert"
>
    <!-- Icon -->
    <div class="flex-shrink-0 mr-3">
        <x-admin.icon name="{{ $style['icon'] }}" class="w-5 h-5 {{ $style['iconColor'] }}" />
    </div>

    <!-- Content -->
    <div class="flex-1">
        @if ($title)
            <h3 class="text-sm font-semibold mb-1">
                {{ $title }}
            </h3>
        @endif
        <div class="text-sm">
            {{ $slot }}
        </div>
    </div>

    <!-- Dismiss Button -->
    @if ($dismissible)
        <div class="flex-shrink-0 ml-3">
            <button 
                type="button" 
                @click="show = false" 
                class="inline-flex rounded-md p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-slate-900 cursor-pointer"
                class="opacity-60 hover:opacity-100"
            >
                <span class="sr-only">Dismiss</span>
                <x-admin.icon name="x-mark" class="w-4 h-4" />
            </button>
        </div>
    @endif
</div>
