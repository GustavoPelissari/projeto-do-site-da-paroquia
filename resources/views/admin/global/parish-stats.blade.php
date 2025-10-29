@extends('admin.layout')

@section('title', 'Estatísticas Paroquiais - Admin Global')

@push('styles')
<style>
    .parish-stats {
        padding: var(--space-6);
    }
    
    .stats-header {
        background: linear-gradient(135deg, var(--sp-teal-dark) 0%, var(--sp-teal) 100%);
        color: var(--sp-white);
        padding: var(--space-xl);
        border-radius: var(--radius-xl);
        margin-bottom: var(--space-6);
        text-align: center;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: var(--space-6);
        margin-bottom: var(--space-6);
    }
    
    .stat-card {
        background: var(--sp-white);
        border-radius: var(--radius-xl);
        padding: var(--space-6);
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--sp-gray-200);
        text-align: center;
    }
    
    .stat-icon {
        font-size: var(--text-4xl);
        margin-bottom: var(--space-4);
    }
    
    .stat-number {
        font-size: var(--text-5xl);
        font-weight: var(--font-bold);
        color: var(--sp-red);
        margin-bottom: var(--space-2);
    }
    
    .stat-label {
        font-size: var(--text-lg);
        color: var(--sp-gray-600);
        margin-bottom: var(--space-2);
    }
    
    .stat-description {
        font-size: var(--text-sm);
        color: var(--sp-gray-500);
    }
    
    .charts-section {
        background: var(--sp-white);
        border-radius: var(--radius-xl);
        padding: var(--space-6);
        box-shadow: var(--shadow-lg);
        margin-bottom: var(--space-6);
    }
    
    .section-title {
        font-size: var(--text-2xl);
        font-weight: var(--font-bold);
        color: var(--sp-red-dark);
        margin-bottom: var(--space-6);
        text-align: center;
    }
    
    .growth-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: var(--space-4);
    }
    
    .growth-item {
        background: var(--sp-gray-50);
        padding: var(--space-4);
        border-radius: var(--radius-lg);
        text-align: center;
    }
    
    .growth-percentage {
        font-size: var(--text-2xl);
        font-weight: var(--font-bold);
        color: var(--sp-teal);
    }
    
    .growth-label {
        color: var(--sp-gray-600);
        font-size: var(--text-sm);
    }
</style>
@endpush

@section('content')
<div class="parish-stats">
    <div class="stats-header">
        <h1>📈 Estatísticas Paroquiais</h1>
        <p>Visão completa do crescimento e atividades da Paróquia São Paulo Apóstolo</p>
    </div>
    
    <!-- Estatísticas Principais -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-number">{{ $stats['total_users'] ?? 0 }}</div>
            <div class="stat-label">Total de Fiéis</div>
            <div class="stat-description">Cadastrados no sistema</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">🏛️</div>
            <div class="stat-number">{{ $stats['active_groups'] ?? 0 }}</div>
            <div class="stat-label">Grupos Ativos</div>
            <div class="stat-description">Pastorais e ministérios</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">📅</div>
            <div class="stat-number">{{ $stats['total_events'] ?? 0 }}</div>
            <div class="stat-label">Eventos Realizados</div>
            <div class="stat-description">Este ano</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">📰</div>
            <div class="stat-number">{{ $stats['published_news'] ?? 0 }}</div>
            <div class="stat-label">Notícias Publicadas</div>
            <div class="stat-description">Conteúdo ativo</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">⛪</div>
            <div class="stat-number">{{ $stats['weekly_masses'] ?? 0 }}</div>
            <div class="stat-label">Missas Semanais</div>
            <div class="stat-description">Horários regulares</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">📋</div>
            <div class="stat-number">{{ $stats['pending_requests'] ?? 0 }}</div>
            <div class="stat-label">Solicitações Pendentes</div>
            <div class="stat-description">Aguardando aprovação</div>
        </div>
    </div>
    
    <!-- Crescimento Mensal -->
    <div class="charts-section">
        <h2 class="section-title">📊 Crescimento da Comunidade</h2>
        <div class="growth-stats">
            <div class="growth-item">
                <div class="growth-percentage">+{{ $growth['users_this_month'] ?? 0 }}%</div>
                <div class="growth-label">Novos usuários este mês</div>
            </div>
            
            <div class="growth-item">
                <div class="growth-percentage">+{{ $growth['groups_this_year'] ?? 0 }}</div>
                <div class="growth-label">Grupos criados este ano</div>
            </div>
            
            <div class="growth-item">
                <div class="growth-percentage">{{ $growth['events_this_month'] ?? 0 }}</div>
                <div class="growth-label">Eventos este mês</div>
            </div>
            
            <div class="growth-item">
                <div class="growth-percentage">{{ $growth['news_this_month'] ?? 0 }}</div>
                <div class="growth-label">Notícias publicadas</div>
            </div>
        </div>
    </div>
    
    <!-- Distribuição por Função -->
    <div class="charts-section">
        <h2 class="section-title">👤 Distribuição de Usuários por Função</h2>
        <div class="growth-stats">
            <div class="growth-item">
                <div class="growth-percentage">{{ $usersByRole['admin_global'] ?? 0 }}</div>
                <div class="growth-label">Admin Global</div>
            </div>
            
            <div class="growth-item">
                <div class="growth-percentage">{{ $usersByRole['administrativo'] ?? 0 }}</div>
                <div class="growth-label">Administrativos</div>
            </div>
            
            <div class="growth-item">
                <div class="growth-percentage">{{ $usersByRole['coordenador_de_pastoral'] ?? 0 }}</div>
                <div class="growth-label">Coordenadores</div>
            </div>
            
            <div class="growth-item">
                <div class="growth-percentage">{{ $usersByRole['usuario_padrao'] ?? 0 }}</div>
                <div class="growth-label">Usuários Padrão</div>
            </div>
        </div>
    </div>
</div>
@endsection
