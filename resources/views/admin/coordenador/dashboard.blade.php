@extends('admin.layout')

@section('title', 'Painel do Coordenador - Coroinhas')

@push('styles')
<style>
    .coordinator-hero {
        background: linear-gradient(135deg, var(--sp-teal-dark) 0%, var(--sp-teal) 100%);
        color: var(--sp-white);
        padding: var(--space-xl) var(--space-6);
        border-radius: var(--radius-xl);
        margin: var(--space-6);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-2xl);
    }
    
    .coordinator-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="cross" patternUnits="userSpaceOnUse" width="20" height="20"><path d="M10,2 L10,18 M2,10 L18,10" stroke="rgba(255,255,255,0.1)" stroke-width="1" fill="none"/></pattern></defs><rect width="100" height="100" fill="url(%23cross)"/></svg>');
        opacity: 0.3;
    }
    
    .coordinator-welcome {
        position: relative;
        z-index: 2;
        text-align: center;
    }
    
    .coordinator-title {
        font-size: var(--text-3xl);
        font-weight: var(--font-bold);
        margin-bottom: var(--space-md);
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    
    .coordinator-subtitle {
        font-size: var(--text-lg);
        color: var(--sp-gold-light);
        font-weight: var(--font-medium);
        margin-bottom: var(--space-lg);
    }
    
    .coordinator-quote {
        font-style: italic;
        font-size: var(--text-base);
        opacity: 0.9;
        border-left: 3px solid var(--sp-gold);
        padding-left: var(--space-md);
        margin: var(--space-lg) auto;
        max-width: 600px;
        font-family: var(--font-secondary);
    }
    
    /* Cards de estatísticas para coordenador */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: var(--space-6);
        margin: var(--space-6);
    }
    
    .stat-card {
        background: var(--sp-white);
        border-radius: var(--radius-xl);
        padding: var(--space-6);
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--sp-gray-200);
        transition: all var(--duration-300) ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--sp-teal);
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }
    
    .stat-header {
        display: flex;
        align-items: center;
        gap: var(--space-md);
        margin-bottom: var(--space-md);
    }
    
    .stat-icon {
        font-size: var(--text-2xl);
        width: 60px;
        height: 60px;
        background: var(--sp-teal);
        border-radius: var(--radius-full);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-md);
        color: var(--sp-white);
    }
    
    .stat-title {
        font-size: var(--text-lg);
        font-weight: var(--font-semibold);
        color: var(--sp-teal-dark);
    }
    
    .stat-number {
        font-size: var(--text-4xl);
        font-weight: var(--font-bold);
        color: var(--sp-teal);
        margin-bottom: var(--space-sm);
    }
    
    .stat-description {
        color: var(--sp-gray-600);
        font-size: var(--text-sm);
    }
    
    /* Seções de visualização */
    .view-section {
        margin: var(--space-6);
        background: var(--sp-white);
        border-radius: var(--radius-xl);
        padding: var(--space-6);
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--sp-gray-200);
    }
    
    .section-title {
        font-size: var(--text-xl);
        font-weight: var(--font-bold);
        color: var(--sp-teal-dark);
        margin-bottom: var(--space-lg);
        display: flex;
        align-items: center;
        gap: var(--space-md);
    }
    
    .section-icon {
        font-size: var(--text-2xl);
    }
    
    .item-list {
        display: flex;
        flex-direction: column;
        gap: var(--space-4);
    }
    
    .item {
        padding: var(--space-4);
        background: var(--sp-gray-50);
        border-radius: var(--radius-lg);
        border-left: 4px solid var(--sp-teal);
    }
    
    .item-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: var(--space-2);
    }
    
    .item-title {
        font-weight: var(--font-medium);
        color: var(--sp-gray-700);
    }
    
    .item-date {
        font-size: var(--text-sm);
        color: var(--sp-gray-500);
    }
    
    .item-description {
        font-size: var(--text-sm);
        color: var(--sp-gray-600);
        line-height: var(--leading-relaxed);
    }
    
    .no-items {
        text-align: center;
        padding: var(--space-8);
        color: var(--sp-gray-500);
    }
    
    /* Responsividade */
    @media (max-width: 768px) {
        .coordinator-hero {
            margin: var(--space-4);
            padding: var(--space-lg) var(--space-4);
        }
        
        .coordinator-title {
            font-size: var(--text-2xl);
        }
        
        .coordinator-subtitle {
            font-size: var(--text-base);
        }
        
        .stats-grid,
        .view-section {
            margin: var(--space-4);
        }
        
        .stat-card {
            padding: var(--space-4);
        }
        
        .stat-number {
            font-size: var(--text-3xl);
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section para Coordenador -->
<div class="coordinator-hero">
    <div class="coordinator-welcome">
        <h1 class="coordinator-title">👨‍🏫 Bem-vindo, Coordenador!</h1>
        <p class="coordinator-subtitle">{{ auth()->user()->name }} - Pastoral dos Coroinhas</p>
        <blockquote class="coordinator-quote">
            "Deixai vir a mim as criancinhas e não as impeçais, porque das tais é o Reino dos céus." - Mateus 19:14
        </blockquote>
    </div>
</div>

<!-- Estatísticas dos Coroinhas -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">👦</div>
            <div class="stat-title">Total de Coroinhas</div>
        </div>
        <div class="stat-number">{{ $stats['total_coroinhas'] ?? 0 }}</div>
        <div class="stat-description">Usuários cadastrados na paróquia</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">✅</div>
            <div class="stat-title">Coroinhas Ativos</div>
        </div>
        <div class="stat-number">{{ $stats['coroinhas_ativos'] ?? 0 }}</div>
        <div class="stat-description">Com solicitação aprovada</div>
    </div>
</div>

<!-- Notícias Recentes (Somente Visualização) -->
<div class="view-section">
    <h2 class="section-title">
        <span class="section-icon">📰</span>
        Notícias Recentes da Paróquia
    </h2>
    
    <div class="item-list">
        @if($recent_news && $recent_news->count() > 0)
            @foreach($recent_news as $news)
                <div class="item">
                    <div class="item-header">
                        <span class="item-title">{{ $news->title }}</span>
                        <span class="item-date">{{ $news->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="item-description">
                        {{ $news->excerpt ?: Str::limit($news->content, 150) }}
                    </div>
                </div>
            @endforeach
        @else
            <div class="no-items">
                <h3>📰 Nenhuma notícia recente</h3>
                <p>Não há notícias publicadas recentemente.</p>
            </div>
        @endif
    </div>
</div>

<!-- Eventos Futuros (Somente Visualização) -->
<div class="view-section">
    <h2 class="section-title">
        <span class="section-icon">📅</span>
        Próximos Eventos da Paróquia
    </h2>
    
    <div class="item-list">
        @if($upcoming_events && $upcoming_events->count() > 0)
            @foreach($upcoming_events as $event)
                <div class="item">
                    <div class="item-header">
                        <span class="item-title">{{ $event->title }}</span>
                        <span class="item-date">{{ $event->start_date->format('d/m/Y') }}</span>
                    </div>
                    <div class="item-description">
                        <strong>Local:</strong> {{ $event->location ?? 'Não informado' }}<br>
                        {{ Str::limit($event->description, 150) }}
                    </div>
                </div>
            @endforeach
        @else
            <div class="no-items">
                <h3>📅 Nenhum evento próximo</h3>
                <p>Não há eventos programados no momento.</p>
            </div>
        @endif
    </div>
</div>
@endsection