@props([
    'align' => 'right',
    'contentClasses' => ''
])

@php
    $alignClass = $align === 'left' ? 'dropdown-menu-start' : 'dropdown-menu-end';
@endphp

<div class="dropdown">
    <div class="d-inline-block" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ $trigger }}
    </div>
    <div class="dropdown-menu {{ $alignClass }} shadow-sm {{ $contentClasses }}">
        {{ $content }}
    </div>
</div>
