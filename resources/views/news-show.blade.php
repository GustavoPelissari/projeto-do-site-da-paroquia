@extends('layout')

@section('title', $news->title . ' - Paróquia São Paulo Apóstolo')

@section('content')
<!-- Hero Section -->
<x-hero 
    title="{{ $news->title }}" 
    subtitle="Notícias da Paróquia São Paulo Apóstolo" 
    titleSize="2.5rem" 
    subtitleSize="1.1rem" 
/>

<!-- Breadcrumbs -->
<div class="container mt-4">
    <x-breadcrumbs :items="[
        ['label' => 'Notícias', 'url' => route('news'), 'icon' => 'newspaper'],
        ['label' => $news->title]
    ]" />
</div>

<!-- Conteúdo da Notícia -->
<section class="section-paroquia">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <article class="card-paroquia">
                    @if($news->featured_image)
                        <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->title }}" class="card-img-top" style="max-height: 400px; object-fit: cover;">
                    @endif
                    
                    <div class="card-body p-4 p-md-5">
                        <!-- Metadados -->
                        <div class="d-flex flex-wrap gap-3 mb-4 pb-3 border-bottom text-muted">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-calendar3 me-2"></i>
                                <span>{{ $news->published_at ? $news->published_at->format('d/m/Y') : $news->created_at->format('d/m/Y') }}</span>
                            </div>
                            
                            @if($news->author)
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person me-2"></i>
                                    <span>{{ $news->author->name }}</span>
                                </div>
                            @endif
                            
                            @if($news->parishGroup)
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-people me-2"></i>
                                    <span>{{ $news->parishGroup->name }}</span>
                                </div>
                            @endif

                            @if($news->featured)
                                <div class="ms-auto">
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-star-fill me-1"></i>Destaque
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Resumo (se existir) -->
                        @if($news->excerpt)
                            <div class="lead mb-4 pb-3 border-bottom" style="color: #666; font-size: 1.125rem; line-height: 1.7;">
                                {{ $news->excerpt }}
                            </div>
                        @endif

                        <!-- Conteúdo -->
                        <div class="news-content" style="font-size: 1.05rem; line-height: 1.8; color: #333;">
                            {!! nl2br(e($news->content)) !!}
                        </div>

                        <!-- Botões de ação -->
                        <div class="mt-5 pt-4 border-top d-flex flex-column flex-sm-row gap-2 justify-content-between align-items-center">
                            <a href="{{ route('news') }}" class="btn btn-outline-success">
                                <i class="bi bi-arrow-left me-2"></i>Voltar para Notícias
                            </a>
                            
                            <div class="d-flex gap-2">
                                <!-- Compartilhar no WhatsApp -->
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($news->title . ' - ' . route('news.show', $news)) }}" 
                                   target="_blank"
                                   class="btn btn-success"
                                   title="Compartilhar no WhatsApp">
                                    <i class="bi bi-whatsapp me-1"></i>Compartilhar
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
                
                <!-- Notícias relacionadas -->
                @php
                    $relatedNews = \App\Models\News::where('status', 'published')
                        ->where('id', '!=', $news->id)
                        ->when($news->parishGroup, function($query) use ($news) {
                            return $query->where('parish_group_id', $news->parish_group_id);
                        })
                        ->latest('published_at')
                        ->take(3)
                        ->get();
                @endphp
                
                @if($relatedNews->count() > 0)
                    <div class="mt-5">
                        <h4 class="mb-4">Outras Notícias</h4>
                        <div class="row g-3">
                            @foreach($relatedNews as $item)
                                <div class="col-md-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        @if($item->featured_image)
                                            <img src="{{ asset('storage/' . $item->featured_image) }}" alt="{{ $item->title }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                        @endif
                                        <div class="card-body">
                                            <h6 class="card-title mb-2">
                                                <a href="{{ route('news.show', $item) }}" class="text-decoration-none text-dark">
                                                    {{ Str::limit($item->title, 60) }}
                                                </a>
                                            </h6>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar3 me-1"></i>
                                                {{ $item->published_at ? $item->published_at->format('d/m/Y') : $item->created_at->format('d/m/Y') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
