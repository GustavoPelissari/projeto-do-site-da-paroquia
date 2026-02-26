@props([
    'title',
    'subtitle' => null,
])

<div class="row justify-content-center text-center mb-5">
    <div class="col-lg-8">
        <h2 class="mb-4">{{ $title }}</h2>
        @if($subtitle)
            <p class="lead text-muted">{{ $subtitle }}</p>
        @endif
    </div>
</div>
