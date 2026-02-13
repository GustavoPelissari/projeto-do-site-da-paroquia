@extends('admin.layout')

@section('title', 'Painel Administrativo - Paróquia São Paulo Apóstolo')

@section('content')
    <div class="sp-container sp-py-large">
        {{-- Hero Section --}}
        <section class="sp-hero sp-mb-large">
            <div class="sp-hero-content">
                <h1 class="sp-hero-title">📊 Painel Administrativo</h1>
                <p class="sp-hero-subtitle">
                    Visão geral das atividades e gerenciamento da paróquia
                </p>
            </div>
        </section>

        {{-- Estatísticas Principais --}}
        <section class="sp-section">
            <div class="sp-content-wrapper">
                <div class="sp-grid sp-grid-4">
                    {{-- Card Notícias --}}
                    <div class="sp-stat-card" style="border-left: 4px solid var(--sp-blue);">
                        <div class="sp-stat-header">
                            <div class="sp-stat-icon sp-stat-icon-blue">📰</div>
                            <div class="sp-stat-info">
                                <div class="sp-stat-value">{{ $stats['news_count'] }}</div>
                                <div class="sp-stat-label">Total de Notícias</div>
                                <div class="sp-stat-meta sp-stat-meta-success">
                                    ✅ {{ $stats['published_news'] }} publicadas
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card Eventos --}}
                    <div class="sp-stat-card" style="border-left: 4px solid var(--sp-teal);">
                        <div class="sp-stat-header">
                            <div class="sp-stat-icon sp-stat-icon-teal">📅</div>
                            <div class="sp-stat-info">
                                <div class="sp-stat-value">{{ $stats['events_count'] }}</div>
                                <div class="sp-stat-label">Total de Eventos</div>
                                <div class="sp-stat-meta sp-stat-meta-info">
                                    📌 {{ $stats['upcoming_events'] }} próximos
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card Grupos --}}
                    <div class="sp-stat-card" style="border-left: 4px solid var(--sp-purple);">
                        <div class="sp-stat-header">
                            <div class="sp-stat-icon sp-stat-icon-purple">👥</div>
                            <div class="sp-stat-info">
                                <div class="sp-stat-value">{{ $stats['groups_count'] }}</div>
                                <div class="sp-stat-label">Grupos Ativos</div>
                                <div class="sp-stat-meta sp-stat-meta-neutral">
                                    🏛️ Comunidades
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card Missas --}}
                    <div class="sp-stat-card" style="border-left: 4px solid var(--sp-red);">
                        <div class="sp-stat-header">
                            <div class="sp-stat-icon sp-stat-icon-red">⛪</div>
                            <div class="sp-stat-info">
                                <div class="sp-stat-value">{{ $stats['masses_count'] }}</div>
                                <div class="sp-stat-label">Horários de Missa</div>
                                <div class="sp-stat-meta sp-stat-meta-neutral">
                                    🕐 Semanais
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Seções de Conteúdo Recente --}}
        <section class="sp-section">
            <div class="sp-content-wrapper">
                <div class="sp-grid sp-grid-2">
                    
                    {{-- Notícias Recentes --}}
                    <div class="sp-card">
                        <div class="sp-card-header">
                            <div class="sp-flex sp-justify-between sp-items-center">
                                <h3 class="sp-card-title">📰 Notícias Recentes</h3>
                                <a href="{{ route('admin.news.index') }}" class="sp-btn sp-btn-outline sp-btn-sm">
                                    Ver todas →
                                </a>
                            </div>
                        </div>
                        <div class="sp-card-content">
                            @if($recent_news->count() > 0)
                                <div class="sp-list sp-list-divided">
                                    @foreach($recent_news as $news)
                                        <div class="sp-list-item">
                                            <div class="sp-list-content">
                                                <h4 class="sp-list-title">{{ $news->title }}</h4>
                                                <div class="sp-list-meta">
                                                    <span class="sp-text-sm">
                                                        👤 {{ $news->user->name }} • 
                                                        📅 {{ $news->created_at->format('d/m/Y H:i') }}
                                                    </span>
                                                </div>
                                                <div class="sp-badge sp-badge-{{ $news->status === 'published' ? 'success' : 'warning' }} sp-mt-2">
                                                    @if($news->status === 'published')
                                                        ✅ Publicado
                                                    @else
                                                        📝 Rascunho
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="sp-list-action">
                                                <a href="{{ route('admin.news.edit', $news) }}" class="sp-btn sp-btn-secondary sp-btn-sm">
                                                    ✏️ Editar
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="sp-empty-state">
                                    <div class="sp-empty-icon">📰</div>
                                    <h4 class="sp-empty-title">Nenhuma notícia encontrada</h4>
                                    <p class="sp-empty-description">Comece criando sua primeira notícia para a comunidade.</p>
                                    <a href="{{ route('admin.news.create') }}" class="sp-btn sp-btn-primary">
                                        ➕ Criar Notícia
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Próximos Eventos --}}
                    <div class="sp-card">
                        <div class="sp-card-header">
                            <div class="sp-flex sp-justify-between sp-items-center">
                                <h3 class="sp-card-title">📅 Próximos Eventos</h3>
                                <a href="{{ route('admin.events.index') }}" class="sp-btn sp-btn-outline sp-btn-sm">
                                    Ver todos →
                                </a>
                            </div>
                        </div>
                        <div class="sp-card-content">
                            @if($upcoming_events->count() > 0)
                                <div class="sp-list sp-list-divided">
                                    @foreach($upcoming_events as $event)
                                        <div class="sp-list-item">
                                            <div class="sp-list-content">
                                                <h4 class="sp-list-title">{{ $event->title }}</h4>
                                                <div class="sp-list-meta">
                                                    <span class="sp-text-sm">
                                                        🕐 {{ $event->start_date->format('d/m/Y H:i') }} • 
                                                        📍 {{ $event->location ?: 'Local a definir' }}
                                                    </span>
                                                </div>
                                                <div class="sp-badge sp-badge-info sp-mt-2">
                                                    📌 {{ ucfirst($event->status) }}
                                                </div>
                                            </div>
                                            <div class="sp-list-action">
                                                <a href="{{ route('admin.events.edit', $event) }}" class="sp-btn sp-btn-secondary sp-btn-sm">
                                                    ✏️ Editar
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="sp-empty-state">
                                    <div class="sp-empty-icon">📅</div>
                                    <h4 class="sp-empty-title">Nenhum evento próximo</h4>
                                    <p class="sp-empty-description">Programe os próximos eventos da comunidade.</p>
                                    <a href="{{ route('admin.events.create') }}" class="sp-btn sp-btn-primary">
                                        ➕ Criar Evento
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Ações Rápidas --}}
        <section class="sp-section">
            <div class="sp-content-wrapper">
                <div class="sp-card" style="background: var(--sp-ivory); border-left: 4px solid var(--sp-gold);">
                    <div class="sp-card-header">
                        <h3 class="sp-card-title" style="color: var(--sp-red);">⚡ Ações Rápidas</h3>
                        <p class="sp-card-description">
                            Acesso direto às funcionalidades mais utilizadas
                        </p>
                    </div>
                    <div class="sp-card-content">
                        <div class="sp-action-grid">
                            {{-- Nova Notícia --}}
                            <a href="{{ route('admin.news.create') }}" class="sp-action-card sp-action-card-blue">
                                <div class="sp-action-icon">📝</div>
                                <div class="sp-action-content">
                                    <h4 class="sp-action-title">Nova Notícia</h4>
                                    <p class="sp-action-description">Publicar informações importantes</p>
                                </div>
                                <div class="sp-action-arrow">→</div>
                            </a>
                            
                            {{-- Novo Evento --}}
                            <a href="{{ route('admin.events.create') }}" class="sp-action-card sp-action-card-teal">
                                <div class="sp-action-icon">�</div>
                                <div class="sp-action-content">
                                    <h4 class="sp-action-title">Novo Evento</h4>
                                    <p class="sp-action-description">Agendar atividades da paróquia</p>
                                </div>
                                <div class="sp-action-arrow">→</div>
                            </a>
                            
                            {{-- Novo Grupo --}}
                            <a href="{{ route('admin.groups.create') }}" class="sp-action-card sp-action-card-purple">
                                <div class="sp-action-icon">👥</div>
                                <div class="sp-action-content">
                                    <h4 class="sp-action-title">Novo Grupo</h4>
                                    <p class="sp-action-description">Criar comunidades paroquiais</p>
                                </div>
                                <div class="sp-action-arrow">→</div>
                            </a>
                            
                            {{-- Nova Missa --}}
                            <a href="{{ route('admin.masses.create') }}" class="sp-action-card sp-action-card-red">
                                <div class="sp-action-icon">⛪</div>
                                <div class="sp-action-content">
                                    <h4 class="sp-action-title">Nova Missa</h4>
                                    <p class="sp-action-description">Configurar horários litúrgicos</p>
                                </div>
                                <div class="sp-action-arrow">→</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Custom Styles para Painel --}}
    <style>
        /* Stat Cards */
        .sp-stat-card {
            background: var(--sp-white);
            border-radius: var(--border-radius-lg);
            padding: var(--space-6);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--sp-gray-200);
            transition: var(--transition-all);
        }

        .sp-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .sp-stat-header {
            display: flex;
            align-items: center;
            gap: var(--space-4);
        }

        .sp-stat-icon {
            font-size: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 5rem;
            height: 5rem;
            border-radius: var(--border-radius-lg);
            background: var(--sp-gray-50);
        }

        .sp-stat-icon-blue { background: #dbeafe; color: #2563eb; }
        .sp-stat-icon-teal { background: #ccfbf1; color: #0d9488; }
        .sp-stat-icon-purple { background: #ede9fe; color: #7c3aed; }
        .sp-stat-icon-red { background: var(--sp-red-50); color: var(--sp-red); }

        .sp-stat-info {
            flex: 1;
        }

        .sp-stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--sp-red-dark);
            line-height: 1;
            margin-bottom: var(--space-1);
        }

        .sp-stat-label {
            font-size: 1rem;
            font-weight: 500;
            color: var(--sp-gray);
            margin-bottom: var(--space-2);
        }

        .sp-stat-meta {
            font-size: 0.875rem;
            padding: var(--space-1) var(--space-2);
            border-radius: var(--border-radius);
            font-weight: 500;
        }

        .sp-stat-meta-success { background: #dcfce7; color: #166534; }
        .sp-stat-meta-info { background: #dbeafe; color: #1e40af; }
        .sp-stat-meta-neutral { background: var(--sp-gray-100); color: var(--sp-gray-dark); }

        /* List Items */
        .sp-list {
            display: flex;
            flex-direction: column;
        }

        .sp-list-divided .sp-list-item:not(:last-child) {
            border-bottom: 1px solid var(--sp-gray-200);
            padding-bottom: var(--space-4);
            margin-bottom: var(--space-4);
        }

        .sp-list-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: var(--space-4);
        }

        .sp-list-content {
            flex: 1;
        }

        .sp-list-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--sp-red-dark);
            margin-bottom: var(--space-2);
            line-height: 1.4;
        }

        .sp-list-meta {
            color: var(--sp-gray);
            margin-bottom: var(--space-2);
        }

        .sp-list-action {
            flex-shrink: 0;
        }

        /* Empty States */
        .sp-empty-state {
            text-align: center;
            padding: var(--space-8) var(--space-4);
        }

        .sp-empty-icon {
            font-size: 4rem;
            margin-bottom: var(--space-4);
            opacity: 0.5;
        }

        .sp-empty-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--sp-gray-dark);
            margin-bottom: var(--space-2);
        }

        .sp-empty-description {
            color: var(--sp-gray);
            margin-bottom: var(--space-6);
        }

        /* Action Grid */
        .sp-action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: var(--space-4);
        }

        .sp-action-card {
            display: flex;
            align-items: center;
            gap: var(--space-4);
            padding: var(--space-5);
            background: var(--sp-white);
            border: 2px solid var(--sp-gray-200);
            border-radius: var(--border-radius-lg);
            text-decoration: none;
            transition: var(--transition-all);
            position: relative;
            overflow: hidden;
        }

        .sp-action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--card-accent-color);
            transition: var(--transition-all);
        }

        .sp-action-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
            border-color: var(--card-accent-color);
        }

        .sp-action-card:hover::before {
            width: 8px;
        }

        .sp-action-card-blue { --card-accent-color: #2563eb; }
        .sp-action-card-teal { --card-accent-color: var(--sp-teal); }
        .sp-action-card-purple { --card-accent-color: #7c3aed; }
        .sp-action-card-red { --card-accent-color: var(--sp-red); }

        .sp-action-icon {
            font-size: 2.5rem;
            flex-shrink: 0;
        }

        .sp-action-content {
            flex: 1;
        }

        .sp-action-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--sp-red-dark);
            margin-bottom: var(--space-1);
        }

        .sp-action-description {
            font-size: 0.875rem;
            color: var(--sp-gray);
        }

        .sp-action-arrow {
            font-size: 1.5rem;
            color: var(--card-accent-color);
            transition: var(--transition-all);
        }

        .sp-action-card:hover .sp-action-arrow {
            transform: translateX(4px);
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .sp-grid-4 {
                grid-template-columns: 1fr 1fr;
            }
            
            .sp-grid-2 {
                grid-template-columns: 1fr;
            }
            
            .sp-action-grid {
                grid-template-columns: 1fr;
            }
            
            .sp-stat-card {
                padding: var(--space-4);
            }
            
            .sp-stat-header {
                flex-direction: column;
                text-align: center;
                gap: var(--space-3);
            }
            
            .sp-stat-icon {
                width: 4rem;
                height: 4rem;
                font-size: 2.5rem;
            }
            
            .sp-stat-value {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .sp-grid-4 {
                grid-template-columns: 1fr;
            }
            
            .sp-list-item {
                flex-direction: column;
                align-items: stretch;
                gap: var(--space-3);
            }
            
            .sp-list-action {
                align-self: flex-start;
            }
        }
    </style>
@endsection