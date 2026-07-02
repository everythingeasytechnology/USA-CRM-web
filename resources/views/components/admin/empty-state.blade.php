@props([
    'title',
    'description',
    'icon' => 'document-text',
])

<div class="flex flex-col items-center justify-center text-center p-8 border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-xl bg-slate-50/50 dark:bg-slate-900/10">
    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400">
        <x-admin.icon name="{{ $icon }}" class="w-6 h-6" />
    </div>
    
    <h3 class="mt-4 text-sm font-semibold text-slate-900 dark:text-white">
        {{ $title }}
    </h3>
    
    <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400 max-w-sm">
        {{ $description }}
    </p>
    
    @if (isset($action))
        <div class="mt-6">
            {{ $action }}
        </div>
    @endif
</div>
