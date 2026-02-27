@props([
    'icon' => 'inbox',
    'title',
    'description',
])

<div class="mx-auto max-w-3xl">
    <div class="card-paroquia p-5 text-center">
            <div class="mb-4">
                <i data-lucide="{{ $icon }}" class="icon-lg public-empty-icon text-gray-500"></i>
            </div>
            <h3 class="mb-3 text-gray-600">{{ $title }}</h3>
            <p class="mb-0 text-gray-600">{{ $description }}</p>
    </div>
</div>
