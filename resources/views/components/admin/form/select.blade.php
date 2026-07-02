@props([
    'label' => null,
    'name',
    'options' => [],
    'selected' => null,
    'required' => false,
    'error' => null,
    'help' => null,
    'placeholder' => null,
])

<div class="w-full">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <select 
            name="{{ $name }}" 
            id="{{ $name }}" 
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge([
                'class' => 'block w-full rounded-lg border px-3.5 py-2.5 text-sm focus-ring bg-white dark:bg-slate-900 cursor-pointer appearance-none ' . 
                ($error 
                    ? 'border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500/20 dark:border-red-900/50 dark:text-red-300' 
                    : 'border-slate-300 text-slate-900 dark:border-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500/20')
            ]) }}
        >
            @if ($placeholder)
                <option value="" disabled {{ is_null(old($name, $selected)) ? 'selected' : '' }}>
                    {{ $placeholder }}
                </option>
            @endif
            
            {{ $slot }}
        </select>
        
        <!-- Custom Caret Icon -->
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3.5 text-slate-400">
            <x-admin.icon name="chevron-down" class="w-4 h-4" />
        </div>
    </div>

    @if ($error)
        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
            {{ $error }}
        </p>
    @elseif ($help)
        <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">
            {{ $help }}
        </p>
    @endif
</div>
