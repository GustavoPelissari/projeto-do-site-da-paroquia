@extends('admin.layout')

@section('title', 'Dashboard Administrativo')

@section('content')
<div class="sp-admin-dashboard">
    <div class="sp-dashboard-header">
        <h1 class="sp-page-title">Dashboard Administrativo</h1>
        <p class="sp-page-subtitle">Painel de controle para funções administrativas</p>
    </div>

    <!-- Statistics Cards -->
    <div class="sp-stats-grid">
        <div class="sp-stat-card">
            <div class="sp-stat-icon sp-text-accent">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="sp-stat-content">
                <h3>{{ $stats['total_news'] }}</h3>
                <p>Total de Notícias</p>
            </div>
        </div>

        <div class="sp-stat-card">
            <div class="sp-stat-icon sp-text-primary">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="sp-stat-content">
                <h3>{{ $stats['total_events'] }}</h3>
                <p>Total de Eventos</p>
            </div>
        </div>

        <div class="sp-stat-card">
            <div class="sp-stat-icon sp-text-liturgy">
                <i class="fas fa-church"></i>
            </div>
            <div class="sp-stat-content">
                <h3>{{ $stats['total_masses'] }}</h3>
                <p>Total de Missas</p>
            </div>
        </div>

        <div class="sp-stat-card">
            <div class="sp-stat-icon sp-text-secondary">
                <i class="fas fa-edit"></i>
            </div>
            <div class="sp-stat-content">
                <h3>{{ $stats['my_news'] }}</h3>
                <p>Minhas Notícias</p>
            </div>
        </div>

        <div class="sp-stat-card">
            <div class="sp-stat-icon sp-text-tertiary">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="sp-stat-content">
                <h3>{{ $stats['my_events'] }}</h3>
                <p>Meus Eventos</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="sp-dashboard-sections">
        <div class="sp-dashboard-section">
            <h2>Ações Rápidas</h2>
            <div class="sp-action-grid">
                <a href="{{ route('admin.administrativo.news.create') }}" class="sp-action-card">
                    <i class="fas fa-plus"></i>
                    <span>Nova Notícia</span>
                </a>
                
                <a href="{{ route('admin.administrativo.events.create') }}" class="sp-action-card">
                    <i class="fas fa-calendar-plus"></i>
                    <span>Novo Evento</span>
                </a>
                
                <a href="{{ route('admin.administrativo.news.index') }}" class="sp-action-card">
                    <i class="fas fa-list"></i>
                    <span>Gerenciar Notícias</span>
                </a>
                
                <a href="{{ route('admin.administrativo.events.index') }}" class="sp-action-card">
                    <i class="fas fa-calendar"></i>
                    <span>Gerenciar Eventos</span>
                </a>
            </div>
        </div>

        <div class="sp-dashboard-section">
            <h2>Informações Importantes</h2>
            <div class="sp-notice sp-notice-info">
                <i class="fas fa-info-circle"></i>
                <div>
                    <h4>Permissões Administrativas</h4>
                    <p>Como administrativo, você pode criar e gerenciar notícias e eventos não-globais. Todas as suas criações passam por aprovação antes de serem publicadas.</p>
                </div>
            </div>
            
            <div class="sp-notice sp-notice-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <h4>Limitações</h4>
                    <p>Você não pode editar conteúdo global ou de outros usuários. Para alterações em conteúdo global, entre em contato com o administrador geral.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
