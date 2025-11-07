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
                        <img src="{{ Storage::url($news->featured_image) }}" alt="{{ $news->title }}" class="card-img-top" style="max-height: 400px; object-fit: cover;">
                    @endif
                    
                    <div class="card-body">
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

                            @if($news->featured)
                                <div class="ms-auto">
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-star-fill me-1"></i>Destaque
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Resumo (se existir) -->
                        @if($news->summary)
                            <div class="lead mb-4 pb-3 border-bottom" style="color: #666;">
                                {{ $news->summary }}
                            </div>
                        @endif

                        <!-- Conteúdo -->
                        <div class="news-content">
                            {!! nl2br(e($news->content)) !!}
                        </div>

                        <!-- Meta Description para SEO -->
                        @if($news->meta_description)
                            <meta name="description" content="{{ $news->meta_description }}">
                        @endif

                        <!-- Botão Voltar -->
                        <div class="mt-4 pt-3 border-top">
                            <a href="{{ route('news') }}" class="btn btn-outline-success">
                                <i class="bi bi-arrow-left me-2"></i>Voltar para Notícias
                            </a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
@endsection
