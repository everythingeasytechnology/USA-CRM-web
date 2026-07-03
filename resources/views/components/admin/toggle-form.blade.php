@props([
    'action',
    'active' => false,
    'method' => 'PATCH',
])

<form method="POST" action="{{ $action }}">
    @csrf
    @method($method)
    <button
        type="submit"
        role="switch"
        aria-checked="{{ $active ? 'true' : 'false' }}"
        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-slate-900 {{ $active ? 'bg-blue-600 dark:bg-blue-500' : 'bg-slate-200 dark:bg-slate-800' }}"
    >
        <span
            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow-sm ring-0 transition duration-200 ease-in-out {{ $active ? 'translate-x-5' : 'translate-x-0' }}"
        ></span>
    </button>
</form>
