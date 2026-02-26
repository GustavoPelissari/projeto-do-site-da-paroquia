@props(['status'])

@if ($status)
    <x-alert type="success">
        {{ $status }}
    </x-alert>
@endif