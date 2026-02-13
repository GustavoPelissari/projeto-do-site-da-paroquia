<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Painel') - Paróquia São Paulo Apóstolo</title>

    <link rel="icon" type="image/png" href="{{ asset(config('branding.logo_path')) }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset(config('branding.logo_path')) }}">
    <link rel="apple-touch-icon" href="{{ asset(config('branding.logo_path')) }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@php
    $user = auth()->user();
    $role = $user ? (is_object($user->role) ? $user->role->value : $user->role) : null;

    $roleLabel = [
        'admin_global' => 'Administrador Global',
        'coordenador_de_pastoral' => 'Coordenador de Pastoral',
        'administrativo' => 'Administrativo',
    ][$role] ?? 'Usuário';
@endphp

<body>
    <div class="admin-layout">
        <aside class="admin-sidebar" id="adminSidebar" aria-label="Menu administrativo">
            <div class="sidebar-header">
                <a href="{{ route('home') }}" class="admin-brand-link">
                    <img src="{{ asset(config('branding.logo_path')) }}" alt="Logo da Paróquia" class="admin-logo">
                    <div>
                        <div class="sidebar-title">Paróquia São Paulo Apóstolo</div>
                        <div class="sidebar-subtitle">Área interna</div>
                    </div>
                </a>
            </div>

            <div class="admin-user-card">
                <div class="admin-user-name">{{ $user?->name }}</div>
                <div class="admin-user-email">{{ $user?->email }}</div>
                <span class="admin-role-badge">{{ $roleLabel }}</span>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="admin-section-title">Navegação</div>

                    @if($role === 'admin_global')
                        <a href="{{ route('admin.global.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.global.dashboard') ? 'active' : '' }}"><i class="bi bi-grid-1x2"></i><span>Painel</span></a>
                        <a href="{{ route('admin.global.news.index') }}" class="admin-nav-link {{ request()->routeIs('admin.global.news.*') ? 'active' : '' }}"><i class="bi bi-newspaper"></i><span>Notícias</span></a>
                        <a href="{{ route('admin.global.events.index') }}" class="admin-nav-link {{ request()->routeIs('admin.global.events.*') ? 'active' : '' }}"><i class="bi bi-calendar-event"></i><span>Eventos</span></a>
                        <a href="{{ route('admin.global.groups.index') }}" class="admin-nav-link {{ request()->routeIs('admin.global.groups.*') ? 'active' : '' }}"><i class="bi bi-people"></i><span>Pastorais e grupos</span></a>
                        <a href="{{ route('admin.global.masses.index') }}" class="admin-nav-link {{ request()->routeIs('admin.global.masses.*') ? 'active' : '' }}"><i class="bi bi-clock-history"></i><span>Horários de missa</span></a>
                        <a href="{{ route('admin.global.users') }}" class="admin-nav-link {{ request()->routeIs('admin.global.users*') ? 'active' : '' }}"><i class="bi bi-person-gear"></i><span>Usuários</span></a>
                        <a href="{{ route('admin.global.stats') }}" class="admin-nav-link {{ request()->routeIs('admin.global.stats') ? 'active' : '' }}"><i class="bi bi-bar-chart"></i><span>Estatísticas</span></a>
                        <a href="{{ route('admin.global.system') }}" class="admin-nav-link {{ request()->routeIs('admin.global.system') ? 'active' : '' }}"><i class="bi bi-hdd-rack"></i><span>Sistema</span></a>
                    @elseif($role === 'coordenador_de_pastoral')
                        <a href="{{ route('admin.coordenador.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.coordenador.dashboard') ? 'active' : '' }}"><i class="bi bi-grid-1x2"></i><span>Painel</span></a>
                        <a href="{{ route('admin.coordenador.news.index') }}" class="admin-nav-link {{ request()->routeIs('admin.coordenador.news.*') ? 'active' : '' }}"><i class="bi bi-newspaper"></i><span>Notícias</span></a>
                        <a href="{{ route('admin.coordenador.events.index') }}" class="admin-nav-link {{ request()->routeIs('admin.coordenador.events.*') ? 'active' : '' }}"><i class="bi bi-calendar-event"></i><span>Eventos</span></a>
                        <a href="{{ route('admin.coordenador.requests.index') }}" class="admin-nav-link {{ request()->routeIs('admin.coordenador.requests.*') ? 'active' : '' }}"><i class="bi bi-person-check"></i><span>Solicitações</span></a>
                        <a href="{{ route('admin.coordenador.schedules.index') }}" class="admin-nav-link {{ request()->routeIs('admin.coordenador.schedules.*') ? 'active' : '' }}"><i class="bi bi-list-check"></i><span>Escalas</span></a>
                        <a href="{{ route('admin.coordenador.masses.index') }}" class="admin-nav-link {{ request()->routeIs('admin.coordenador.masses.*') ? 'active' : '' }}"><i class="bi bi-clock-history"></i><span>Missas</span></a>
                        <a href="{{ route('admin.coordenador.scales.index') }}" class="admin-nav-link {{ request()->routeIs('admin.coordenador.scales.*') ? 'active' : '' }}"><i class="bi bi-file-earmark-arrow-up"></i><span>Escalas PDF</span></a>
                    @elseif($role === 'administrativo')
                        <a href="{{ route('admin.administrativo.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.administrativo.dashboard') ? 'active' : '' }}"><i class="bi bi-grid-1x2"></i><span>Painel</span></a>
                        <a href="{{ route('admin.administrativo.news.index') }}" class="admin-nav-link {{ request()->routeIs('admin.administrativo.news.*') ? 'active' : '' }}"><i class="bi bi-newspaper"></i><span>Notícias</span></a>
                        <a href="{{ route('admin.administrativo.events.index') }}" class="admin-nav-link {{ request()->routeIs('admin.administrativo.events.*') ? 'active' : '' }}"><i class="bi bi-calendar-event"></i><span>Eventos</span></a>
                        <a href="{{ route('admin.administrativo.masses.index') }}" class="admin-nav-link {{ request()->routeIs('admin.administrativo.masses.*') ? 'active' : '' }}"><i class="bi bi-clock-history"></i><span>Missas</span></a>
                    @endif
                </div>

                <div class="admin-nav-divider"></div>

                <div class="nav-section">
                    <div class="admin-section-title">Conta</div>
                    <a href="{{ route('profile.edit') }}" class="admin-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"><i class="bi bi-person"></i><span>Meu perfil</span></a>
                    <a href="{{ route('home') }}" class="admin-nav-link"><i class="bi bi-globe"></i><span>Ver site público</span></a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="admin-nav-link admin-link-button"><i class="bi bi-box-arrow-right"></i><span>Sair</span></button>
                    </form>
                </div>
            </nav>
        </aside>

        <div class="admin-main">
            <header class="admin-header">
                <div class="container-fluid px-4 py-3 d-flex align-items-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-outline-primary d-lg-none" type="button" data-admin-toggle aria-controls="adminSidebar" aria-label="Abrir menu">
                            <i class="bi bi-list"></i>
                        </button>
                        <div>
                            <p class="admin-overline mb-1">Área administrativa</p>
                            <h1 class="header-title mb-0">@yield('title', 'Painel')</h1>
                        </div>
                    </div>
                </div>
            </header>

            <main class="admin-content py-4">
                <div class="container-fluid px-4">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
