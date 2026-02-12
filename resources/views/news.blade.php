@extends('layouts.public')

@section('title', 'Notícias - Paróquia São Paulo Apóstolo')
@section('description', 'Acompanhe as últimas notícias e novidades da Paróquia São Paulo Apóstolo em Umuarama - PR.')

@section('content')
<section class="py-5 bg-dark text-white text-center">
    <div class="container py-4">
        <h1 class="display-6 fw-bold mb-3">Notícias da Paróquia</h1>
        <p class="lead mb-0">Mantenha-se informado sobre tudo que acontece em nossa comunidade.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if($news->count() > 0)
            <div class="row g-4">
                @foreach($news as $item)
                <div class="col-lg-6 col-xl-4">
                    <div class="card shadow-sm h-100">
                        @if($item->image)
                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="card-img-top" style="height: 220px; object-fit: cover;">
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 220px;">
                                <i class="bi bi-newspaper fs-1 text-primary"></i>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-2 text-muted small">
                                <span>{{ $item->created_at->format('d/m/Y') }}</span>
                                @if($item->category)
                                    <span class="badge bg-secondary ms-auto">{{ $item->category }}</span>
                                @endif
                            </div>

                            <h2 class="h5 text-primary">{{ $item->title }}</h2>
                            <p class="text-muted flex-grow-1">{{ Str::limit($item->summary ?: strip_tags($item->content), 150) }}</p>

                            <div class="mt-auto">
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newsModal{{ $item->id }}">
                                    Ler Completa
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="newsModal{{ $item->id }}" tabindex="-1" aria-labelledby="newsModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title h5" id="newsModalLabel{{ $item->id }}">{{ $item->title }}</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if($item->image)
                                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="img-fluid rounded mb-3">
                                @endif

                                <p class="small text-muted mb-3">
                                    {{ $item->created_at->format('d/m/Y \\à\\s H:i') }}
                                    @if($item->category)
                                        · <span class="badge bg-secondary">{{ $item->category }}</span>
                                    @endif
                                </p>

                                <div>{!! nl2br(e($item->content)) !!}</div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($news->hasPages())
            <div class="d-flex justify-content-center mt-4">{{ $news->links() }}</div>
            @endif
        @else
            <div class="card shadow-sm text-center">
                <div class="card-body py-5">
                    <h2 class="h4 text-muted">Nenhuma notícia disponível</h2>
                    <p class="text-muted mb-0">Volte em breve para conferir as novidades da paróquia.</p>
                </div>
            </div>
        @endif
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container text-center">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h2 class="h4 text-primary mb-3">Mantenha-se Conectado</h2>
                <p class="mb-4">Acompanhe nossos eventos e participe das pastorais.</p>
                <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                    <a href="{{ route('groups') }}" class="btn btn-primary">Conhecer Pastorais</a>
                    <a href="{{ route('events') }}" class="btn btn-outline-primary">Ver Eventos</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
