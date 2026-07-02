@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none cursor-pointer';
    
    $variants = [
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white border border-transparent shadow-xs focus:ring-blue-500 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-400 focus:ring-offset-white dark:focus:ring-offset-slate-900',
        
        'secondary' => 'bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 shadow-xs focus:ring-blue-500 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-200 dark:border-slate-700 dark:focus:ring-slate-400 focus:ring-offset-white dark:focus:ring-offset-slate-900',
        
        'danger' => 'bg-red-600 hover:bg-red-700 text-white border border-transparent shadow-xs focus:ring-red-500 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-400 focus:ring-offset-white dark:focus:ring-offset-slate-900',
        
        'ghost' => 'bg-transparent hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-100 focus:ring-slate-500 border border-transparent',
        
        'link' => 'bg-transparent text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 focus:ring-blue-500 underline underline-offset-4 p-0 border-0 shadow-none focus:ring-0',
    ];
    
    $sizes = [
        'xs' => 'text-xs px-2.5 py-1.5 gap-1.5',
        'sm' => 'text-sm px-3 py-2 gap-1.5',
        'md' => 'text-sm px-4 py-2.5 gap-2',
        'lg' => 'text-base px-5 py-3 gap-2.5',
    ];
    
    $variantClass = $variants[$variant] ?? $variants['primary'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $classes = "{$baseClasses} {$variantClass} {$sizeClass}";
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
