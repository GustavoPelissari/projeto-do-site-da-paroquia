@props(['type' => 'info', 'dismissible' => true])

<div class="alert alert-{{ $type }} {{ $dismissible ? 'alert-dismissible' : '' }} fade show d-flex align-items-start border-start border-4 shadow-sm" 
     role="alert"
     style="border-left-color: var(--bs-{{ $type }}) !important;">

    <div class="me-3">
        @if($type === 'success')
            <i class="bi bi-check-circle-fill text-success" style="font-size: 1.25rem;"></i>
        @elseif($type === 'error' || $type === 'danger')
            <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 1.25rem;"></i>
        @elseif($type === 'warning')
            <i class="bi bi-exclamation-circle-fill text-warning" style="font-size: 1.25rem;"></i>
        @else
            <i class="bi bi-info-circle-fill text-info" style="font-size: 1.25rem;"></i>
        @endif
    </div>

    <div class="flex-grow-1">
        {{ $slot }}
    </div>

    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>