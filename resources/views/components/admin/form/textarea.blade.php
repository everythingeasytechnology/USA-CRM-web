@props([
    'label' => null,
    'name',
    'placeholder' => null,
    'value' => null,
    'rows' => 4,
    'required' => false,
    'error' => null,
    'help' => null,
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

    <textarea 
        name="{{ $name }}" 
        id="{{ $name }}" 
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge([
            'class' => 'block w-full rounded-lg border px-3.5 py-2.5 text-sm focus-ring ' . 
            ($error 
                ? 'border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500/20 dark:border-red-900/50 dark:text-red-300' 
                : 'border-slate-300 bg-white text-slate-900 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:placeholder-slate-500 focus:border-blue-500 focus:ring-blue-500/20')
        ]) }}
    >{{ old($name, $value) }}</textarea>

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
