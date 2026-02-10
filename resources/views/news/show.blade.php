@extends('layouts.app')

@section('title', $article->title . ' - Paróquia São Paulo Apóstolo')

@section('content')
    <div class="sp-container sp-py-large">
        {{-- Breadcrumb --}}
        <nav class="sp-breadcrumb sp-mb-6">
            <ol class="sp-breadcrumb-list">
                <li class="sp-breadcrumb-item">
                    <a href="{{ route('home') }}" class="sp-breadcrumb-link">🏠 Início</a>
                </li>
                <li class="sp-breadcrumb-divider">→</li>
                <li class="sp-breadcrumb-item">
                    <a href="{{ route('news.index') }}" class="sp-breadcrumb-link">📰 Notícias</a>
                </li>
                <li class="sp-breadcrumb-divider">→</li>
                <li class="sp-breadcrumb-item sp-breadcrumb-current">
                    {{ Str::limit($article->title, 50) }}
                </li>
            </ol>
        </nav>

        {{-- Article Content --}}
        <article class="sp-article">
            <div class="sp-article-container">
                
                {{-- Featured Image --}}
                @if($article->featured_image)
                    <div class="sp-article-hero">
                            <img src="{{ Storage::url($article->featured_image) }}" 
                                alt="{{ $article->title }}" 
                                class="sp-article-image" loading="lazy">
                        <div class="sp-article-overlay"></div>
                    </div>
                @endif
                
                {{-- Article Header --}}
                <header class="sp-article-header">
                    @if($article->featured)
                        <div class="sp-article-badge">
                            <span class="sp-badge sp-badge-gold sp-badge-lg">
                                ⭐ Notícia em Destaque
                            </span>
                        </div>
                    @endif
                    
                    <h1 class="sp-article-title">{{ $article->title }}</h1>
                    
                    <div class="sp-article-meta">
                        <div class="sp-meta-group">
                            <span class="sp-meta-item">
                                <span class="sp-meta-icon">👤</span>
                                <span class="sp-meta-text">{{ $article->user->name }}</span>
                            </span>
                            
                            <span class="sp-meta-item">
                                <span class="sp-meta-icon">📅</span>
                                <span class="sp-meta-text">{{ $article->published_at->format('d/m/Y') }}</span>
                            </span>
                            
                            <span class="sp-meta-item">
                                <span class="sp-meta-icon">�</span>
                                <span class="sp-meta-text">{{ $article->published_at->format('H:i') }}</span>
                            </span>
                        </div>
                    </div>
                    
                    {{-- Summary --}}
                    @if($article->summary)
                        <div class="sp-article-summary">
                            <div class="sp-summary-content">
                                <div class="sp-summary-icon">💡</div>
                                <p class="sp-summary-text">{{ $article->summary }}</p>
                            </div>
                        </div>
                    @endif
                </header>

                {{-- Article Body --}}
                <div class="sp-article-body">
                    <div class="sp-article-content">
                        {!! nl2br(e($article->content)) !!}
                    </div>
                </div>

                {{-- Article Footer --}}
                <footer class="sp-article-footer">
                    <div class="sp-article-info">
                        @if($article->updated_at != $article->created_at)
                            <span class="sp-article-date">
                                📝 Última atualização: {{ $article->updated_at->format('d/m/Y \à\s H:i') }}
                            </span>
                        @else
                            <span class="sp-article-date">
                                📅 Publicado em {{ $article->created_at->format('d/m/Y \à\s H:i') }}
                            </span>
                        @endif
                    </div>
                    
                    <div class="sp-article-actions">
                        <a href="{{ route('news.index') }}" class="sp-btn sp-btn-primary sp-btn-lg">
                            ← Voltar às Notícias
                        </a>
                        <button onclick="window.print()" class="sp-btn sp-btn-outline sp-btn-lg">
                            🖨️ Imprimir
                        </button>
                    </div>
                </footer>
            </div>
        </article>

        {{-- Related News --}}
        @php
            $related_news = \App\Models\News::published()
                ->where('id', '!=', $article->id)
                ->latest()
                ->take(3)
                ->get();
        @endphp

        @if($related_news->count() > 0)
            <section class="sp-section sp-mt-large">
                <div class="sp-content-wrapper">
                    <div class="sp-section-header sp-text-center sp-mb-8">
                        <h2 class="sp-section-title">📰 Outras Notícias</h2>
                        <p class="sp-section-description">
                            Continue acompanhando as novidades da nossa paróquia
                        </p>
                    </div>
                    
                    <div class="sp-related-grid">
                        @foreach($related_news as $related)
                            <article class="sp-related-card">
                                <div class="sp-card sp-card-hover">
                                    <div class="sp-related-image">
                                        @if($related->featured_image)
                                                <img src="{{ Storage::url($related->featured_image) }}" 
                                                    alt="{{ $related->title }}" 
                                                    class="sp-image-cover" loading="lazy">
                                        @else
                                            <div class="sp-image-placeholder">
                                                <span class="sp-placeholder-icon">📰</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="sp-card-content">
                                        <div class="sp-related-meta">
                                            📅 {{ $related->published_at->format('d/m/Y') }}
                                        </div>
                                        
                                        <h3 class="sp-related-title">
                                            <a href="{{ route('news.show', $related->id) }}" class="sp-link-primary">
                                                {{ $related->title }}
                                            </a>
                                        </h3>
                                        
                                        <div class="sp-related-summary">
                                            @if($related->summary)
                                                <p>{{ Str::limit($related->summary, 100) }}</p>
                                            @else
                                                <p>{{ Str::limit($related->content, 100) }}</p>
                                            @endif
                                        </div>
                                        
                                        <a href="{{ route('news.show', $related->id) }}" 
                                           class="sp-btn sp-btn-outline sp-btn-sm sp-mt-4">
                                            Ler mais →
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- Call to Action --}}
        <section class="sp-section">
            <div class="sp-content-wrapper">
                <div class="sp-card sp-text-center" style="background: var(--sp-cream); border-left: 4px solid var(--sp-teal);">
                    <div class="sp-card-content">
                        <h3 class="sp-title-lg sp-mb-4" style="color: var(--sp-red);">📢 Participe da Nossa Comunidade</h3>
                        <p class="sp-text-lg sp-mb-6" style="color: var(--sp-gray-dark);">
                            Gostou desta notícia? Venha fazer parte da nossa comunidade paroquial!
                        </p>
                        <div class="sp-flex sp-justify-center sp-gap-4">
                            <a href="{{ route('groups.index') }}" class="sp-btn sp-btn-primary">
                                👥 Ver Grupos
                            </a>
                            <a href="{{ route('events.index') }}" class="sp-btn sp-btn-outline">
                                📅 Ver Eventos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Custom Styles for Article --}}
    <style>
        /* Breadcrumb */
        .sp-breadcrumb {
            padding: var(--space-4) 0;
        }

        .sp-breadcrumb-list {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: 0.875rem;
        }

        .sp-breadcrumb-link {
            color: var(--sp-teal);
            text-decoration: none;
            transition: var(--transition-all);
        }

        .sp-breadcrumb-link:hover {
            color: var(--sp-red);
        }

        .sp-breadcrumb-divider {
            color: var(--sp-gray-light);
        }

        .sp-breadcrumb-current {
            color: var(--sp-gray);
            font-weight: 500;
        }

        /* Article Layout */
        .sp-article {
            background: var(--sp-white);
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .sp-article-container {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Hero Image */
        .sp-article-hero {
            position: relative;
            height: 400px;
            overflow: hidden;
        }

        .sp-article-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sp-article-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(transparent, rgba(0,0,0,0.1));
        }

        /* Article Header */
        .sp-article-header {
            padding: var(--space-8);
            padding-bottom: var(--space-6);
        }

        .sp-article-badge {
            margin-bottom: var(--space-4);
        }

        .sp-article-title {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.2;
            color: var(--sp-red-dark);
            margin-bottom: var(--space-6);
        }

        .sp-article-meta {
            margin-bottom: var(--space-6);
        }

        .sp-meta-group {
            display: flex;
            flex-wrap: wrap;
            gap: var(--space-4);
        }

        .sp-meta-item {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: 0.875rem;
            color: var(--sp-gray);
        }

        .sp-meta-icon {
            font-size: 1rem;
            color: var(--sp-teal);
        }

        /* Summary */
        .sp-article-summary {
            background: var(--sp-teal-50);
            border-left: 4px solid var(--sp-teal);
            border-radius: var(--border-radius-lg);
            padding: var(--space-6);
        }

        .sp-summary-content {
            display: flex;
            gap: var(--space-4);
            align-items: flex-start;
        }

        .sp-summary-icon {
            font-size: 1.5rem;
            color: var(--sp-teal);
            flex-shrink: 0;
        }

        .sp-summary-text {
            font-size: 1.125rem;
            font-weight: 500;
            color: var(--sp-teal-dark);
            line-height: 1.6;
            margin: 0;
        }

        /* Article Body */
        .sp-article-body {
            padding: 0 var(--space-8) var(--space-6);
        }

        .sp-article-content {
            font-size: 1.125rem;
            line-height: 1.8;
            color: var(--sp-gray-dark);
        }

        .sp-article-content p {
            margin-bottom: var(--space-4);
        }

        /* Article Footer */
        .sp-article-footer {
            padding: var(--space-6) var(--space-8) var(--space-8);
            border-top: 1px solid var(--sp-gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: var(--space-4);
        }

        .sp-article-date {
            font-size: 0.875rem;
            color: var(--sp-gray);
        }

        .sp-article-actions {
            display: flex;
            gap: var(--space-3);
        }

        /* Related News */
        .sp-related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--space-6);
        }

        .sp-related-image {
            height: 200px;
            overflow: hidden;
        }

        .sp-related-meta {
            font-size: 0.875rem;
            color: var(--sp-gray);
            margin-bottom: var(--space-3);
        }

        .sp-related-title {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: var(--space-3);
            line-height: 1.3;
        }

        .sp-related-title a {
            color: var(--sp-red-dark);
            text-decoration: none;
        }

        .sp-related-summary {
            color: var(--sp-gray);
            line-height: 1.5;
            margin-bottom: var(--space-4);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sp-article-title {
                font-size: 2rem;
            }

            .sp-article-header,
            .sp-article-body,
            .sp-article-footer {
                padding-left: var(--space-6);
                padding-right: var(--space-6);
            }

            .sp-article-hero {
                height: 250px;
            }

            .sp-article-footer {
                flex-direction: column;
                align-items: stretch;
                gap: var(--space-4);
            }

            .sp-article-actions {
                justify-content: center;
            }

            .sp-meta-group {
                justify-content: center;
            }

            .sp-related-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .sp-article-title {
                font-size: 1.75rem;
            }

            .sp-article-header,
            .sp-article-body,
            .sp-article-footer {
                padding-left: var(--space-4);
                padding-right: var(--space-4);
            }

            .sp-summary-content {
                flex-direction: column;
                gap: var(--space-2);
            }

            .sp-article-actions {
                flex-direction: column;
            }
        }

        /* Print Styles */
        @media print {
            .sp-breadcrumb,
            .sp-article-actions,
            .sp-section:last-child {
                display: none;
            }

            .sp-article {
                box-shadow: none;
                border: 1px solid #ccc;
            }

            .sp-article-content {
                font-size: 12pt;
                line-height: 1.6;
            }
        }
    </style>
@endsection