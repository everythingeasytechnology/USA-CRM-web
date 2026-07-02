@props([
    'label' => null,
    'name',
    'value' => false,
    'help' => null,
])

<div class="flex items-start justify-between gap-4">
    <div class="flex-1">
        @if ($label)
            <label for="{{ $name }}" class="text-sm font-medium text-slate-700 dark:text-slate-300">
                {{ $label }}
            </label>
        @endif
        @if ($help)
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                {{ $help }}
            </p>
        @endif
    </div>
    
    <div 
        x-data="{ enabled: {{ old($name, $value) ? 'true' : 'false' }} }" 
        class="flex items-center"
    >
        <input 
            type="hidden" 
            name="{{ $name }}" 
            :value="enabled ? '1' : '0'"
        />
        
        <button 
            type="button" 
            @click="enabled = !enabled" 
            :class="enabled ? 'bg-blue-600 dark:bg-blue-500' : 'bg-slate-200 dark:bg-slate-800'"
            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-slate-900"
            role="switch" 
            :aria-checked="enabled.toString()"
        >
            <span 
                :class="enabled ? 'translate-x-5' : 'translate-x-0'"
                class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow-sm ring-0 transition duration-200 ease-in-out"
            ></span>
        </button>
    </div>
</div>
