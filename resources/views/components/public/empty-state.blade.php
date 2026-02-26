@props([
    'icon' => 'inbox',
    'title',
    'description',
])

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card-paroquia text-center p-5">
            <div class="mb-4">
                <i data-lucide="{{ $icon }}" class="icon-lg text-muted public-empty-icon"></i>
            </div>
            <h3 class="text-muted mb-3">{{ $title }}</h3>
            <p class="text-muted mb-0">{{ $description }}</p>
        </div>
    </div>
</div>
