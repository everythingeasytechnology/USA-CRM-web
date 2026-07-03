@props([
    'action',
    'confirm' => 'Are you sure you want to delete this? This action cannot be undone.',
    'class' => '',
])

<form method="POST" action="{{ $action }}" onsubmit="return confirm('{{ addslashes($confirm) }}')" class="{{ $class }}">
    @csrf
    @method('DELETE')
    {{ $slot }}
</form>
