@props([
    'label' => null,
    'name',
    'value' => '1',
    'checked' => false,
    'error' => null,
    'help' => null,
])

<div class="relative flex items-start">
    <div class="flex h-6 items-center">
        <input 
            type="checkbox" 
            name="{{ $name }}" 
            id="{{ $name }}" 
            value="{{ $value }}"
            {{ old($name, $checked) ? 'checked' : '' }}
            {{ $attributes->merge([
                'class' => 'h-4.5 w-4.5 rounded border-slate-300 dark:border-slate-700 text-blue-600 bg-white dark:bg-slate-900 focus:ring-blue-500 cursor-pointer focus-ring'
            ]) }}
        />
    </div>
    
    @if ($label || $help)
        <div class="ml-3 text-sm leading-6">
            @if ($label)
                <label for="{{ $name }}" class="font-medium text-slate-700 dark:text-slate-300">
                    {{ $label }}
                </label>
            @endif
            @if ($help)
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    {{ $help }}
                </p>
            @endif
            @if ($error)
                <p class="mt-1 text-xs text-red-600 dark:text-red-400">
                    {{ $error }}
                </p>
            @endif
        </div>
    @endif
</div>
