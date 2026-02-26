@extends('admin.layout')

@section('title', 'Dashboard Administrativo')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="mb-4">
        <h1 class="display-6 fw-bold text-brand-vinho">Dashboard Administrativo</h1>
        <p class="text-muted">Painel de controle para funções administrativas</p>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                <i class="bi bi-newspaper fs-4 text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0 fw-bold">{{ $stats['total_news'] }}</h3>
                            <p class="text-muted mb-0 small">Total de Notícias</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                <i class="bi bi-calendar-event fs-4 text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0 fw-bold">{{ $stats['total_events'] }}</h3>
                            <p class="text-muted mb-0 small">Total de Eventos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                                <i class="bi bi-clock fs-4 text-danger"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0 fw-bold">{{ $stats['total_masses'] }}</h3>
                            <p class="text-muted mb-0 small">Total de Missas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                <i class="bi bi-pencil-square fs-4 text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0 fw-bold">{{ $stats['my_news'] }}</h3>
                            <p class="text-muted mb-0 small">Minhas Notícias</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="fw-bold mb-0">Ações Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('admin.administrativo.news.create') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="bi bi-plus-circle me-2"></i>Nova Notícia
                            </a>
                        </div>
                        
                        <div class="col-md-6">
                            <a href="{{ route('admin.administrativo.events.create') }}" class="btn btn-outline-success w-100 py-3">
                                <i class="bi bi-calendar-plus me-2"></i>Novo Evento
                            </a>
                        </div>
                        
                        <div class="col-md-6">
                            <a href="{{ route('admin.administrativo.news.index') }}" class="btn btn-outline-secondary w-100 py-3">
                                <i class="bi bi-list-ul me-2"></i>Gerenciar Notícias
                            </a>
                        </div>
                        
                        <div class="col-md-6">
                            <a href="{{ route('admin.administrativo.events.index') }}" class="btn btn-outline-info w-100 py-3">
                                <i class="bi bi-calendar-event me-2"></i>Gerenciar Eventos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="flex-shrink-0">
                            <i class="bi bi-info-circle fs-4 text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fw-bold">Permissões Administrativas</h6>
                            <p class="small text-muted mb-0">Como administrativo, você pode criar e gerenciar notícias e eventos não-globais. Todas as suas criações passam por aprovação antes de serem publicadas.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm border-warning border-start border-3">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="flex-shrink-0">
                            <i class="bi bi-exclamation-triangle fs-4 text-warning"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fw-bold">Limitações</h6>
                            <p class="small text-muted mb-0">Você não pode editar conteúdo global ou de outros usuários. Para alterações em conteúdo global, entre em contato com o administrador geral.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
