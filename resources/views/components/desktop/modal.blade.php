@php use Illuminate\Support\Str; @endphp

@props([
    'name',
    'maxWidth' => 'lg'
])

@php
    $sizeClass = [
        'sm' => 'modal-sm',
        'md' => '',
        'lg' => 'modal-lg',
        'xl' => 'modal-xl',
        '2xl' => 'modal-xl'
    ][$maxWidth] ?? '';
    $modalId = 'modal-' . Str::slug($name, '-');
@endphp

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true" aria-modal="true" role="dialog" aria-labelledby="{{ $modalId }}-label" aria-label="{{ $name }}">
    <div class="modal-dialog {{ $sizeClass }} modal-dialog-centered">
        <div class="modal-content">
            <div id="{{ $modalId }}-label" class="visually-hidden">{{ $name }}</div>
            {{ $slot }}
        </div>
    </div>
</div>
