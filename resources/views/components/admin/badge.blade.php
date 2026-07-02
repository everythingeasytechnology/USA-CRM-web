@props([
    'variant' => 'neutral'
])

@php
    $baseClasses = 'inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-xs font-semibold';
    
    $variants = [
        'neutral' => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
        'success' => 'bg-emerald-50 text-emerald-700 border border-emerald-200/50 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20',
        'info' => 'bg-blue-50 text-blue-700 border border-blue-200/50 dark:bg-blue-500/10 dark:text-blue-400 dark:border-blue-500/20',
        'warning' => 'bg-amber-50 text-amber-700 border border-amber-200/50 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20',
        'danger' => 'bg-red-50 text-red-700 border border-red-200/50 dark:bg-red-500/10 dark:text-red-400 dark:border-red-500/20',
    ];
    
    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['neutral']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
