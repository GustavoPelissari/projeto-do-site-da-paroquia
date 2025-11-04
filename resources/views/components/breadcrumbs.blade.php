@props(['items'])

@if(isset($items) && count($items) > 0)
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}" class="text-decoration-none text-brand-vinho">
                <i class="bi bi-house-door"></i> Início
            </a>
        </li>
        
        @foreach($items as $index => $item)
            @if($loop->last)
                <li class="breadcrumb-item active" aria-current="page">
                    @if(isset($item['icon']))
                        <i class="bi bi-{{ $item['icon'] }}"></i>
                    @endif
                    {{ $item['label'] }}
                </li>
            @else
                <li class="breadcrumb-item">
                    <a href="{{ $item['url'] }}" class="text-decoration-none text-brand-vinho">
                        @if(isset($item['icon']))
                            <i class="bi bi-{{ $item['icon'] }}"></i>
                        @endif
                        {{ $item['label'] }}
                    </a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
@endif
