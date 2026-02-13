@extends('layouts.app')

@section('title', 'Notícias - Paróquia São Paulo Apóstolo')

@section('content')
    <div class="sp-container sp-py-large">
        {{-- Hero Section --}}
        <section class="sp-hero">
            <div class="sp-hero-content">
                <h1 class="sp-hero-title"> Notícias da Paróquia</h1>
                <p class="sp-hero-subtitle">
                    Fique por dentro das últimas novidades e acontecimentos da nossa comunidade
                </p>
            </div>
        </section>

        {{-- Main Content --}}
        <section class="sp-section">
            <div class="sp-content-wrapper">
                @if($news->count() > 0)
                    {{-- Featured News (First Article if Featured) --}}
                    @php
                        $featuredNews = $news->where('featured', true)->first();
                        $regularNews = $news->where('featured', false);
                    @endphp

                    @if($featuredNews)
                        <div class="sp-featured-article sp-mb-large">
                            <div class="sp-card sp-card-featured">
                                <div class="sp-featured-image">
                                    @if($featuredNews->featured_image)
                                        <img src="{{ Storage::url($featuredNews->featured_image) }}" 
                                             alt="{{ $featuredNews->title }}" 
                                             class="sp-image-cover">
                                    @else
                                        <div class="sp-image-placeholder sp-image-placeholder-featured">
                                            <span class="sp-placeholder-icon"></span>
                                        </div>
                                    @endif
                                    <div class="sp-featured-badge">
                                        <span class="sp-badge sp-badge-gold sp-badge-lg">Destaque</span>
                                    </div>
                                </div>
                                
                                <div class="sp-featured-content">
                                    <div class="sp-article-meta">
                                        <span class="sp-meta-item">
                                             {{ $featuredNews->published_at->format('d/m/Y') }}
                                        </span>
                                        <span class="sp-meta-divider">•</span>
                                        <span class="sp-meta-item">
                                             {{ $featuredNews->user->name }}
                                        </span>
                                    </div>
                                    
                                    <h2 class="sp-featured-title">
                                        <a href="{{ route('news.show', $featuredNews->id) }}" class="sp-link-primary">
                                            {{ $featuredNews->title }}
                                        </a>
                                    </h2>
                                    
                                    <div class="sp-featured-summary">
                                        @if($featuredNews->summary)
                                            <p>{{ $featuredNews->summary }}</p>
                                        @else
                                            <p>{{ Str::limit($featuredNews->content, 200) }}</p>
                                        @endif
                                    </div>
                                    
                                    <a href="{{ route('news.show', $featuredNews->id) }}" 
                                       class="sp-btn sp-btn-primary sp-btn-lg">
                                         Ler Notícia Completa
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Regular News Grid --}}
                    @if($regularNews->count() > 0)
                        <div class="sp-news-grid">
                            @foreach($regularNews as $article)
                                <article class="sp-news-card">
                                    <div class="sp-card sp-card-hover">
                                        <div class="sp-news-image">
                                            @if($article->featured_image)
                                                <img src="{{ Storage::url($article->featured_image) }}" 
                                                     alt="{{ $article->title }}" 
                                                     class="sp-image-cover">
                                            @else
                                                <div class="sp-image-placeholder">
                                                    <span class="sp-placeholder-icon"></span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="sp-card-content">
                                            <div class="sp-article-meta sp-mb-3">
                                                <span class="sp-meta-item">
                                                     {{ $article->published_at->format('d/m/Y') }}
                                                </span>
                                                <span class="sp-meta-divider">•</span>
                                                <span class="sp-meta-item">
                                                     {{ $article->user->name }}
                                                </span>
                                            </div>
                                            
                                            <h3 class="sp-news-title">
                                                <a href="{{ route('news.show', $article->id) }}" class="sp-link-primary">
                                                    {{ $article->title }}
                                                </a>
                                            </h3>
                                            
                                            <div class="sp-news-summary">
                                                @if($article->summary)
                                                    <p>{{ Str::limit($article->summary, 120) }}</p>
                                                @else
                                                    <p>{{ Str::limit($article->content, 120) }}</p>
                                                @endif
                                            </div>
                                            
                                            <a href="{{ route('news.show', $article->id) }}" 
                                               class="sp-btn sp-btn-outline sp-btn-sm sp-mt-4">
                                                Ler mais →
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif

                    {{-- Pagination --}}
                    @if($news->hasPages())
                        <div class="sp-pagination-wrapper">
                            {{ $news->links() }}
                        </div>
                    @endif
                @else
                    {{-- Empty State --}}
                    <div class="sp-empty-state sp-text-center">
                        <div class="sp-empty-icon"></div>
                        <h3 class="sp-empty-title">Nenhuma notícia encontrada</h3>
                        <p class="sp-empty-description">
                            Volte em breve para conferir as novidades da nossa paróquia. 
                            Nossa equipe está sempre trabalhando para mantê-lo informado!
                        </p>
                        <a href="{{ route('home') }}" class="sp-btn sp-btn-primary sp-mt-6">
                             Voltar à Página Inicial
                        </a>
                    </div>
                @endif
            </div>
        </section>

        {{-- Call to Action --}}
        <section class="sp-section">
            <div class="sp-content-wrapper">
                <div class="sp-card sp-text-center" style="background: var(--sp-ivory); border-left: 4px solid var(--sp-gold);">
                    <div class="sp-card-content">
                        <h3 class="sp-title-lg sp-mb-4" style="color: var(--sp-red);">� Mantenha-se Informado</h3>
                        <p class="sp-text-lg sp-mb-6" style="color: var(--sp-gray-dark);">
                            Quer ficar sempre por dentro das novidades da paróquia? 
                            Siga-nos nas redes sociais e participe da nossa comunidade!
                        </p>
                        <div class="sp-flex sp-justify-center sp-gap-4">
                            <a href="#" class="sp-btn sp-btn-primary">
                                 Redes Sociais
                            </a>
                            <a href="{{ route('groups.index') }}" class="sp-btn sp-btn-outline">
                                 Participar de Grupos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Custom Styles for News --}}
    <style>
        /* Featured Article */
        .sp-featured-article {
            margin-bottom: var(--space-8);
        }

        .sp-card-featured {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            overflow: hidden;
            min-height: 400px;
        }

        .sp-featured-image {
            position: relative;
            overflow: hidden;
        }

        .sp-featured-image .sp-image-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition-all);
        }

        .sp-card-featured:hover .sp-featured-image .sp-image-cover {
            transform: scale(1.05);
        }

        .sp-image-placeholder-featured {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--sp-red) 0%, var(--sp-gold) 100%);
        }

        .sp-image-placeholder-featured .sp-placeholder-icon {
            font-size: 4rem;
            color: var(--sp-white);
        }

        .sp-featured-badge {
            position: absolute;
            top: var(--space-4);
            right: var(--space-4);
        }

        .sp-featured-content {
            padding: var(--space-8);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .sp-featured-title {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.2;
            color: var(--sp-red-dark);
            margin: var(--space-4) 0;
        }

        .sp-featured-summary {
            font-size: 1.125rem;
            color: var(--sp-gray-dark);
            line-height: 1.6;
            margin-bottom: var(--space-6);
        }

        /* News Grid */
        .sp-news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: var(--space-6);
        }

        .sp-news-card {
            height: 100%;
        }

        .sp-news-card .sp-card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .sp-news-image {
            height: 200px;
            overflow: hidden;
        }

        .sp-news-image .sp-image-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition-all);
        }

        .sp-card-hover:hover .sp-news-image .sp-image-cover {
            transform: scale(1.05);
        }

        .sp-image-placeholder {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--sp-teal) 0%, var(--sp-blue) 100%);
        }

        .sp-placeholder-icon {
            font-size: 3rem;
            color: var(--sp-white);
        }

        .sp-news-title {
            font-size: 1.25rem;
            font-weight: 600;
            line-height: 1.3;
            margin-bottom: var(--space-3);
        }

        .sp-news-title a {
            color: var(--sp-red-dark);
            text-decoration: none;
            transition: var(--transition-all);
        }

        .sp-news-title a:hover {
            color: var(--sp-red);
        }

        .sp-news-summary {
            color: var(--sp-gray);
            line-height: 1.5;
            flex: 1;
        }

        /* Article Meta */
        .sp-article-meta {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: 0.875rem;
            color: var(--sp-gray);
        }

        .sp-meta-item {
            display: flex;
            align-items: center;
            gap: var(--space-1);
        }

        .sp-meta-divider {
            color: var(--sp-gray-light);
        }

        /* Pagination */
        .sp-pagination-wrapper {
            margin-top: var(--space-8);
            display: flex;
            justify-content: center;
        }

        /* Empty State */
        .sp-empty-state {
            padding: var(--space-8) var(--space-4);
        }

        .sp-empty-icon {
            font-size: 5rem;
            color: var(--sp-gray-light);
            margin-bottom: var(--space-6);
        }

        .sp-empty-title {
            font-size: 1.875rem;
            font-weight: 600;
            color: var(--sp-red-dark);
            margin-bottom: var(--space-4);
        }

        .sp-empty-description {
            font-size: 1.125rem;
            color: var(--sp-gray);
            max-width: 600px;
            margin: 0 auto var(--space-6);
            line-height: 1.6;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sp-card-featured {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .sp-featured-content {
                padding: var(--space-6);
            }

            .sp-featured-title {
                font-size: 1.5rem;
            }

            .sp-featured-summary {
                font-size: 1rem;
                margin-bottom: var(--space-4);
            }

            .sp-news-grid {
                grid-template-columns: 1fr;
            }

            .sp-featured-badge {
                top: var(--space-2);
                right: var(--space-2);
            }
        }

        @media (max-width: 480px) {
            .sp-news-grid {
                gap: var(--space-4);
            }
            
            .sp-news-image {
                height: 180px;
            }
            
            .sp-featured-title {
                font-size: 1.25rem;
            }
        }
    </style>
@endsection