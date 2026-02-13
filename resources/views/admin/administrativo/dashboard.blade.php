@extends('admin.layout')

@section('title', 'Painel administrativo')

@section('content')
<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
    <div>
        <p class="admin-overline mb-1">Área administrativa</p>
        <h2 class="h3 mb-0">Visão geral</h2>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('admin.administrativo.news.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>Nova notícia
        </a>
        <a href="{{ route('admin.administrativo.events.create') }}" class="btn btn-outline-primary">
            <i class="bi bi-calendar-plus me-1"></i>Novo evento
        </a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card h-100"><div class="card-body">
            <p class="text-secondary small mb-1">Total de notícias</p>
            <h3 class="h4 mb-0">{{ $stats['total_news'] }}</h3>
        </div></div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card h-100"><div class="card-body">
            <p class="text-secondary small mb-1">Total de eventos</p>
            <h3 class="h4 mb-0">{{ $stats['total_events'] }}</h3>
        </div></div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card h-100"><div class="card-body">
            <p class="text-secondary small mb-1">Total de missas</p>
            <h3 class="h4 mb-0">{{ $stats['total_masses'] }}</h3>
        </div></div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card h-100"><div class="card-body">
            <p class="text-secondary small mb-1">Conteúdos criados por você</p>
            <h3 class="h4 mb-0">{{ $stats['my_news'] + $stats['my_events'] }}</h3>
        </div></div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12 col-lg-8">
        <div class="card h-100">
            <div class="card-header">
                <h3 class="h5 mb-0">Acesso rápido</h3>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.administrativo.news.index') }}" class="btn btn-outline-primary">Gerenciar notícias</a>
                    <a href="{{ route('admin.administrativo.events.index') }}" class="btn btn-outline-primary">Gerenciar eventos</a>
                    <a href="{{ route('admin.administrativo.masses.index') }}" class="btn btn-outline-primary">Horários de missa</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h3 class="h5 mb-0">Permissões</h3>
            </div>
            <div class="card-body">
                <p class="mb-2">Você pode criar e editar conteúdos administrativos.</p>
                <p class="text-secondary small mb-0">Conteúdos globais continuam sob responsabilidade do administrador global.</p>
            </div>
        </div>
    </div>
</div>
@endsection
