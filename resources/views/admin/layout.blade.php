<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Painel') - Paróquia São Paulo Apóstolo</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/sao-paulo-logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/sao-paulo-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/sao-paulo-logo.png') }}">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles Específicos -->
    @stack('styles')

    <!-- Laravel Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <nav class="admin-sidebar" id="adminSidebar" aria-label="Menu administrativo">
            <div class="sidebar-header">
                <div class="d-flex align-items-center gap-3">
                    <x-parish-logo class="admin-logo" alt="Logo da Paróquia" />
                    <div>
                        <div class="sidebar-title">Painel Administrativo</div>
                        <div class="sidebar-subtitle">Paróquia São Paulo Apóstolo</div>
                    </div>
                </div>
            </div>

            <div class="sidebar-nav">
                <div class="nav-section">
                    <div class="admin-section-title">Principal</div>

                    @if(auth()->check())
                        @if(auth()->user()->role->value === 'admin_global')
                            <a href="{{ route('admin.global.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.global.dashboard') ? 'active' : '' }}">
                                <i class="bi bi-grid-1x2 admin-nav-icon"></i>
                                <span class="nav-text">Painel</span>
                            </a>
                            <a href="{{ route('admin.global.news.index') }}" class="admin-nav-link {{ request()->routeIs('admin.global.news.*') ? 'active' : '' }}">
                                <i class="bi bi-newspaper admin-nav-icon"></i>
                                <span class="nav-text">Notícias</span>
                            </a>
                            <a href="{{ route('admin.global.events.index') }}" class="admin-nav-link {{ request()->routeIs('admin.global.events.*') ? 'active' : '' }}">
                                <i class="bi bi-calendar-event admin-nav-icon"></i>
                                <span class="nav-text">Eventos</span>
                            </a>
                        @elseif(auth()->user()->role->value === 'coordenador_de_pastoral')
                            <a href="{{ route('admin.coordenador.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.coordenador.dashboard') ? 'active' : '' }}">
                                <i class="bi bi-grid-1x2 admin-nav-icon"></i>
                                <span class="nav-text">Painel</span>
                            </a>
                            <a href="{{ route('admin.coordenador.news.index') }}" class="admin-nav-link {{ request()->routeIs('admin.coordenador.news.*') ? 'active' : '' }}">
                                <i class="bi bi-newspaper admin-nav-icon"></i>
                                <span class="nav-text">Notícias</span>
                            </a>
                            <a href="{{ route('admin.coordenador.events.index') }}" class="admin-nav-link {{ request()->routeIs('admin.coordenador.events.*') ? 'active' : '' }}">
                                <i class="bi bi-calendar-event admin-nav-icon"></i>
                                <span class="nav-text">Eventos</span>
                            </a>
                        @elseif(auth()->user()->role->value === 'administrativo')
                            <a href="{{ route('admin.administrativo.news.index') }}" class="admin-nav-link {{ request()->routeIs('admin.administrativo.news.*') ? 'active' : '' }}">
                                <i class="bi bi-newspaper admin-nav-icon"></i>
                                <span class="nav-text">Notícias</span>
                            </a>
                            <a href="{{ route('admin.administrativo.events.index') }}" class="admin-nav-link {{ request()->routeIs('admin.administrativo.events.*') ? 'active' : '' }}">
                                <i class="bi bi-calendar-event admin-nav-icon"></i>
                                <span class="nav-text">Eventos</span>
                            </a>
                        @endif
                    @endif
                </div>

                <div class="admin-nav-divider"></div>

                <div class="nav-section">
                    <div class="admin-section-title">Sistema</div>
                    <a href="{{ route('home') }}" class="admin-nav-link">
                        <i class="bi bi-globe admin-nav-icon"></i>
                        <span class="nav-text">Ver site público</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="admin-nav-link admin-link-button">
                            <i class="bi bi-box-arrow-right admin-nav-icon"></i>
                            <span class="nav-text">Sair</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="admin-main">
            <header class="admin-header">
                <div class="container-fluid px-4 py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-outline-secondary d-lg-none" type="button" data-admin-toggle aria-controls="adminSidebar" aria-label="Abrir menu">
                            <i class="bi bi-list"></i>
                        </button>
                        <h1 class="header-title mb-0">@yield('title', 'Painel')</h1>
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
