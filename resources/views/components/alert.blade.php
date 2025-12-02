@props(['type' => 'info', 'dismissible' => true])

@php
    $iconMap = [
        'success' => 'check-circle-fill',
        'error' => 'exclamation-triangle-fill',
        'danger' => 'exclamation-triangle-fill',
        'warning' => 'exclamation-circle-fill',
        'info' => 'info-circle-fill'
    ];
    
    $icon = $iconMap[$type] ?? 'info-circle-fill';
    $alertClass = $type === 'error' ? 'danger' : $type;
@endphp

<div class="alert alert-{{ $alertClass }} @if($dismissible) alert-dismissible @endif fade show d-flex align-items-start shadow-sm" 
     role="alert">

    <div class="me-3">
        <i class="bi bi-{{ $icon }} fs-5"></i>
    </div>

    <div class="flex-grow-1">
        {{ $slot }}
    </div>

    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
