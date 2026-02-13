@extends('admin.layout')

@section('title', 'Painel do Padre - Admin Global')

@push('styles')
<style>
    /* Estilos melhorados para o dashboard do admin global */
    .padre-hero {
        background: linear-gradient(135deg, #8B1538 0%, #A91B47 30%, #D4AF37 100%);
        color: white;
        padding: 3rem 2rem;
        border-radius: 20px;
        margin: 1.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(139, 21, 56, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .padre-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="cross" patternUnits="userSpaceOnUse" width="25" height="25"><path d="M12.5,5 L12.5,20 M5,12.5 L20,12.5" stroke="rgba(255,255,255,0.08)" stroke-width="1.5" fill="none"/></pattern></defs><rect width="100" height="100" fill="url(%23cross)"/></svg>');
        opacity: 0.4;
    }
    
    .padre-welcome {
        position: relative;
        z-index: 2;
        text-align: center;
    }
    
    .padre-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
        background: linear-gradient(45deg, #FFFFFF, #F4D03F);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .padre-subtitle {
        font-size: 1.25rem;
        color: #F4D03F;
        font-weight: 500;
        margin-bottom: 1.5rem;
        opacity: 0.95;
    }
    
    .padre-quote {
        font-style: italic;
        font-size: 1.1rem;
        opacity: 0.9;
        border-left: 4px solid #D4AF37;
        padding: 1rem 0 1rem 1.5rem;
        margin: 1.5rem auto;
        max-width: 700px;
        font-family: 'Georgia', serif;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 0 12px 12px 0;
    }
    
    /* Grid de estatísticas melhorado */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 1.5rem;
        margin: 2rem 1.5rem;
    }
    
    .stat-card {
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #8B1538, #D4AF37);
    }
    
    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
        border-color: rgba(139, 21, 56, 0.2);
    }
    
    .stat-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .stat-icon {
        font-size: 2.5rem;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, rgba(139, 21, 56, 0.1), rgba(212, 175, 55, 0.1));
        border-radius: 16px;
        border: 2px solid rgba(139, 21, 56, 0.1);
    }
    
    .stat-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2d3748;
        line-height: 1.4;
    }
    
    .stat-number {
        font-size: 3rem;
        font-weight: 800;
        background: linear-gradient(135deg, #8B1538, #D4AF37);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0.5rem 0;
        line-height: 1;
    }
    
    .stat-description {
        font-size: 0.95rem;
        color: #718096;
        font-weight: 500;
        line-height: 1.5;
    }
    
    
    /* Seções de atividades e conteúdo melhoradas */
    .content-section {
        margin: 2rem 1.5rem;
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
    }
    
    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #8B1538, #D4AF37);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .section-icon {
        font-size: 1.5rem;
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, rgba(139, 21, 56, 0.1), rgba(212, 175, 55, 0.1));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid rgba(139, 21, 56, 0.1);
    }
    
    /* Grid de ações rápidas melhorado */
    .quick-actions {
        margin: 2rem 1.5rem;
        background: linear-gradient(145deg, #f8f9fa, #ffffff);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(212, 175, 55, 0.2);
    }
    
    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1rem;
    }
    
    .action-card {
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
        border-radius: 16px;
        padding: 1.5rem;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
    }
    
    .action-card:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 12px 32px rgba(139, 21, 56, 0.15);
        border-color: rgba(139, 21, 56, 0.2);
        text-decoration: none;
    }
    
    .action-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .action-icon {
        font-size: 2rem;
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, rgba(139, 21, 56, 0.1), rgba(212, 175, 55, 0.1));
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid rgba(139, 21, 56, 0.1);
    }
    
    .action-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2d3748;
        margin: 0;
    }
    
    .action-description {
        font-size: 0.9rem;
        color: #718096;
        line-height: 1.5;
        margin: 0;
    }
    
    /* Lista de atividades melhorada */
    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .activity-item {
        padding: 1.5rem;
        background: linear-gradient(145deg, #f8f9fa, #ffffff);
        border-radius: 16px;
        border-left: 4px solid #17a2b8;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .activity-item:hover {
        transform: translateX(8px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }
    
    .activity-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.5rem;
    }
    
    .activity-text {
        font-weight: 600;
        color: #2d3748;
        font-size: 1rem;
    }
    
    .activity-time {
        font-size: 0.85rem;
        color: #718096;
        background: rgba(139, 21, 56, 0.1);
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-weight: 500;
    }
    
    .activity-description {
        font-size: 0.9rem;
        color: #4a5568;
        line-height: 1.6;
        margin: 0;
    }
    
    /* Responsividade melhorada */
    @media (max-width: 768px) {
        .padre-hero {
            margin: 1rem;
            padding: 2rem 1.5rem;
        }
        
        .padre-title {
            font-size: 2rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
            margin: 1rem;
        }
        
        .stat-card {
            padding: 1.5rem;
        }
        
        .stat-number {
            font-size: 2.5rem;
        }
        
        .content-section,
        .quick-actions {
            margin: 1rem;
            padding: 1.5rem;
        }
        
        .actions-grid {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 480px) {
        .padre-hero {
            margin: 0.5rem;
            padding: 1.5rem 1rem;
        }
        
        .padre-title {
            font-size: 1.75rem;
        }
        
        .padre-subtitle {
            font-size: 1.1rem;
        }
        
        .stats-grid {
            margin: 0.5rem;
        }
        
        .stat-card {
            padding: 1.25rem;
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            font-size: 2rem;
        }
        
        .stat-number {
            font-size: 2.25rem;
        }
    }
    
    .action-card {
        background: var(--sp-white);
        border: 2px solid var(--sp-gold-light);
        border-radius: var(--radius-lg);
        padding: var(--space-5);
        text-align: center;
        text-decoration: none;
        color: inherit;
        transition: all var(--duration-300) ease;
    }
    
    .action-card:hover {
        transform: translateY(-2px);
        border-color: var(--sp-gold);
        box-shadow: var(--shadow-gold);
        text-decoration: none;
        color: inherit;
    }
    
    .action-icon {
        font-size: var(--text-3xl);
        margin-bottom: var(--space-md);
        display: block;
    }
    
    .action-title {
        font-size: var(--text-lg);
        font-weight: var(--font-semibold);
        color: var(--sp-red-dark);
        margin-bottom: var(--space-sm);
    }
    
    .action-description {
        color: var(--sp-gray-600);
        font-size: var(--text-sm);
    }
    
    /* Seção de atividades recentes */
    .recent-activity {
        margin: var(--space-6);
        background: var(--sp-white);
        border-radius: var(--radius-xl);
        padding: var(--space-6);
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--sp-gray-200);
    }
    
    .activity-title {
        font-size: var(--text-xl);
        font-weight: var(--font-bold);
        color: var(--sp-red-dark);
        margin-bottom: var(--space-lg);
        display: flex;
        align-items: center;
        gap: var(--space-md);
    }
    
    .activity-list {
        display: flex;
        flex-direction: column;
        gap: var(--space-4);
    }
    
    .activity-item {
        padding: var(--space-4);
        background: var(--sp-gray-50);
        border-radius: var(--radius-lg);
        border-left: 4px solid var(--sp-teal);
    }
    
    .activity-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: var(--space-2);
    }
    
    .activity-text {
        font-weight: var(--font-medium);
        color: var(--sp-gray-700);
    }
    
    .activity-time {
        font-size: var(--text-sm);
        color: var(--sp-gray-500);
    }
    
    .activity-description {
        font-size: var(--text-sm);
        color: var(--sp-gray-600);
        line-height: var(--leading-relaxed);
    }
    
    /* Responsividade */
    @media (max-width: 768px) {
        .padre-hero {
            margin: var(--space-4);
            padding: var(--space-lg) var(--space-4);
        }
        
        .padre-title {
            font-size: var(--text-2xl);
        }
        
        .padre-subtitle {
            font-size: var(--text-base);
        }
        
        .stats-grid,
        .recent-activity,
        .quick-actions {
            margin: var(--space-4);
        }
        
        .stat-card {
            padding: var(--space-4);
        }
        
        .stat-number {
            font-size: var(--text-3xl);
        }
        
        .actions-grid {
            grid-template-columns: 1fr;
        }
        
        .action-card {
            padding: var(--space-4);
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section especial para o Padre -->
<div class="padre-hero">
    <div class="padre-welcome">
        <h1 class="padre-title"> Bem-vindo, Padre {{ auth()->user()->name }}!</h1>
        <p class="padre-subtitle">Painel de Administração Global - Paróquia São Paulo Apóstolo</p>
        <blockquote class="padre-quote">
            "Combati o bom combate, terminei a corrida, guardei a fé." - 2 Timóteo 4:7
        </blockquote>
    </div>
</div>

<!-- Estatísticas Principais -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon"></div>
            <div class="stat-title">Fiéis Cadastrados</div>
        </div>
        <div class="stat-number">{{ $stats['users_count'] ?? 0 }}</div>
        <div class="stat-description">Total de membros da comunidade</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon"></div>
            <div class="stat-title">Grupos Ativos</div>
        </div>
        <div class="stat-number">{{ $stats['groups_count'] ?? 0 }}</div>
        <div class="stat-description">Pastorais e ministérios em atividade</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon"></div>
            <div class="stat-title">Horários de Missa</div>
        </div>
        <div class="stat-number">{{ $stats['masses_count'] ?? 0 }}</div>
        <div class="stat-description">Celebrações semanais ativas</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon"></div>
            <div class="stat-title">Próximos Eventos</div>
        </div>
        <div class="stat-number">{{ $stats['upcoming_events'] ?? 0 }}</div>
        <div class="stat-description">Eventos programados</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon"></div>
            <div class="stat-title">Notícias Publicadas</div>
        </div>
        <div class="stat-number">{{ $stats['published_news'] ?? 0 }}</div>
        <div class="stat-description">Conteúdo ativo no site</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon"></div>
            <div class="stat-title">Solicitações Pendentes</div>
        </div>
        <div class="stat-number">{{ $stats['pending_requests'] ?? 0 }}</div>
        <div class="stat-description">Aguardando aprovação</div>
    </div>
</div>

<!-- Ações Rápidas -->
<div class="quick-actions">
    <h2 class="section-title">
        <div class="section-icon"></div>
        Ações Rápidas - Administração Pastoral
    </h2>
    <div class="actions-grid">
        <a href="{{ route('admin.global.news.create') }}" class="action-card">
            <div class="action-header">
                <div class="action-icon">�</div>
                <div>
                    <h3 class="action-title">Nova Notícia</h3>
                    <p class="action-description">Publicar informações para a comunidade</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('admin.global.events.create') }}" class="action-card">
            <div class="action-header">
                <div class="action-icon"></div>
                <div>
                    <h3 class="action-title">Novo Evento</h3>
                    <p class="action-description">Criar evento ou celebração especial</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('admin.global.groups.index') }}" class="action-card">
            <div class="action-header">
                <div class="action-icon"></div>
                <div>
                    <h3 class="action-title">Gerenciar Grupos</h3>
                    <p class="action-description">Administrar pastorais e ministérios</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('admin.global.masses.index') }}" class="action-card">
            <div class="action-header">
                <div class="action-icon"></div>
                <div>
                    <h3 class="action-title">Horários de Missa</h3>
                    <p class="action-description">Configurar celebrações e horários</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('group-requests.index') }}" class="action-card">
            <div class="action-header">
                <div class="action-icon"></div>
                <div>
                    <h3 class="action-title">Aprovar Solicitações</h3>
                    <p class="action-description">Revisar pedidos de entrada em grupos</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('home') }}" class="action-card">
            <div class="action-header">
                <div class="action-icon"></div>
                <div>
                    <h3 class="action-title">Ver Site Público</h3>
                    <p class="action-description">Visualizar como os fiéis veem o site</p>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Atividades Recentes -->
<div class="content-section">
    <h2 class="section-title">
        <div class="section-icon"></div>
        Atividades Recentes da Paróquia
    </h2>
    
    <div class="activity-list">
        @if(isset($recent_news) && $recent_news->count() > 0)
            @foreach($recent_news->take(3) as $news)
                <div class="activity-item">
                    <div class="activity-header">
                        <span class="activity-text"> Nova notícia publicada</span>
                        <span class="activity-time">{{ $news->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="activity-description">
                        "{{ $news->title }}" por {{ $news->user->name ?? 'Sistema' }}
                    </div>
                </div>
            @endforeach
        @endif
        
        @if(isset($upcoming_events) && $upcoming_events->count() > 0)
            @foreach($upcoming_events->take(2) as $event)
                <div class="activity-item">
                    <div class="activity-header">
                        <span class="activity-text"> Próximo evento</span>
                        <span class="activity-time">{{ $event->start_date->format('d/m/Y') }}</span>
                    </div>
                    <div class="activity-description">
                        "{{ $event->title }}" - {{ $event->category ?? 'Geral' }}
                    </div>
                </div>
            @endforeach
        @endif
        
        @if((!isset($recent_news) || $recent_news->count() == 0) && (!isset($upcoming_events) || $upcoming_events->count() == 0))
            <div class="activity-item">
                <div class="activity-header">
                    <span class="activity-text"> Sistema em funcionamento</span>
                    <span class="activity-time">Agora</span>
                </div>
                <div class="activity-description">
                    O sistema está funcionando normalmente. Bem-vindo ao painel administrativo!
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
