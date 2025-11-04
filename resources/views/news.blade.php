@extends('layout')

@section('title', 'Notícias - Paróquia São Paulo Apóstolo')

@section('content')
<!-- Hero Section -->
<section class="hero-paroquia animate-on-scroll" style="min-height: 40vh;">
    <div class="hero-content">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="mb-4" style="font-size: 2.5rem; font-weight: 700; color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">
                        Notícias da Paróquia
                    </h1>
                    <p class="lead mb-4" style="font-size: 1.1rem; opacity: 0.95; color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">
                        Mantenha-se informado sobre tudo que acontece em nossa comunidade
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Breadcrumbs -->
<div class="container mt-4">
    <x-breadcrumbs :items="[
        ['label' => 'Notícias', 'icon' => 'newspaper']
    ]" />
</div>

<!-- Notícias -->
<section class="section-paroquia animate-on-scroll">
    <div class="container">
        @if($news->total() > 0)
            <div class="row g-4">
                @foreach($news as $item)
                <div class="col-lg-6 col-xl-4">
                    <div class="card-paroquia h-100">
                        @if($item->featured_image)
                            <img src="{{ asset('storage/' . $item->featured_image) }}" alt="{{ $item->title }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg, var(--sp-vermelho-manto) 0%, var(--sp-vermelho-bordô) 100%);">
                                <i class="bi bi-newspaper text-white" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3 text-muted">
                                <i class="bi bi-calendar3 me-2"></i>
                                <small>{{ $item->published_at ? $item->published_at->format('d/m/Y') : $item->created_at->format('d/m/Y') }}</small>
                                @if($item->parishGroup)
                                    <span class="badge bg-success ms-auto">
                                        <i class="bi bi-people"></i> {{ $item->parishGroup->name }}
                                    </span>
                                @endif
                            </div>
                            
                            <h5 class="card-title text-vermelho">{{ $item->title }}</h5>
                            
                            @if($item->excerpt)
                                <p class="card-text flex-grow-1">{{ Str::limit($item->excerpt, 150) }}</p>
                            @else
                                <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($item->content), 150) }}</p>
                            @endif
                            
                            <div class="mt-auto">
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#newsModal{{ $item->id }}">
                                    <i class="bi bi-eye me-1"></i>Ler Completa
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Modal para notícia completa -->
                <div class="modal fade" id="newsModal{{ $item->id }}" tabindex="-1" aria-labelledby="newsModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-vermelho" id="newsModalLabel{{ $item->id }}">{{ $item->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if($item->featured_image)
                                    <img src="{{ asset('storage/' . $item->featured_image) }}" alt="{{ $item->title }}" class="img-fluid rounded mb-3">
                                @endif
                                
                                <div class="d-flex align-items-center mb-3 text-muted">
                                    <i class="bi bi-calendar3 me-2"></i>
                                    <small>{{ $item->published_at ? $item->published_at->format('d/m/Y \à\s H:i') : $item->created_at->format('d/m/Y \à\s H:i') }}</small>
                                    @if($item->parishGroup)
                                        <span class="badge bg-success ms-auto">
                                            <i class="bi bi-people"></i> {{ $item->parishGroup->name }}
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="content">
                                    {!! nl2br(e($item->content)) !!}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Paginação -->
            @if($news->hasPages())
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center">
                    {{ $news->links() }}
                </div>
            </div>
            @endif
        @else
            <div class="row">
                <div class="col-12">
                    <div class="card-paroquia text-center py-5">
                        <div class="card-body">
                            <i class="bi bi-newspaper icon-lg mb-4" style="font-size: 4rem; opacity: 0.5;"></i>
                            <h3 class="text-vermelho mb-3">Nenhuma notícia disponível</h3>
                            <p class="text-muted">Ainda não há notícias publicadas. Volte em breve para conferir as novidades da nossa paróquia!</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Seção de chamada para ação -->
<section class="section-paroquia" style="background: rgba(139, 21, 56, 0.03);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="card-paroquia p-5">
                    <h3 class="text-vermelho mb-3">
                        <i class="bi bi-bell me-2"></i>
                        Mantenha-se Conectado
                    </h3>
                    <p class="mb-4">
                        Não perca nenhuma novidade! Participe da nossa comunidade e acompanhe todos os eventos e atividades.
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="{{ route('groups') }}" class="btn btn-success">
                            <i class="bi bi-people me-1"></i>Conhecer Pastorais
                        </a>
                        <a href="{{ route('events') }}" class="btn btn-warning">
                            <i class="bi bi-calendar-event me-1"></i>Ver Eventos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.content {
    line-height: 1.8;
    font-size: 1.05rem;
}

.content p {
    margin-bottom: 1rem;
}

.modal-content {
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.modal-header {
    border-bottom: 1px solid rgba(139, 21, 56, 0.1);
    background: rgba(139, 21, 56, 0.03);
}

.pagination {
    --bs-pagination-active-bg: var(--sp-vermelho-manto);
    --bs-pagination-active-border-color: var(--sp-vermelho-manto);
}
</style>
@endpush