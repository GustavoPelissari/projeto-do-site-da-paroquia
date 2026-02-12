<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Paróquia São Paulo Apóstolo</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/sao-paulo-logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/sao-paulo-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/sao-paulo-logo.png') }}">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Crimson+Text:ital,wght@0,400;0,600;1,400&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">

    <!-- Styles Específicos -->
    @stack('styles')

    <!-- Laravel Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* (mantido por enquanto; será refatorado para Bootstrap-only na etapa ADMIN) */
        .admin-layout { min-height: 100vh; display: flex; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); }
        .admin-sidebar { width: 300px; background: linear-gradient(180deg, #8B1538 0%, #A91B47 50%, #731029 100%); color: white; box-shadow: 0 10px 40px rgba(139, 21, 56, 0.3); z-index: 100; position: relative; overflow: hidden; }
        .sidebar-header { padding: 2rem 1.5rem; background: rgba(0,0,0,0.15); border-bottom: 2px solid rgba(212, 175, 55, 0.3); position: relative; z-index: 2; }
        .sidebar-title { font-size: 1.4rem; font-weight: 700; color: #fff; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); position: relative; z-index: 2; }
        .sidebar-nav { padding: 1rem 0; position: relative; z-index: 2; }
        .nav-section { margin-bottom: 2rem; }
        .nav-section-title { font-size: 0.8rem; font-weight: 700; color: #F4D03F; text-transform: uppercase; letter-spacing: 0.08em; padding: 0 1.5rem; margin-bottom: 1rem; opacity: 0.9; }
        .nav-link { display: flex; align-items: center; gap: 1rem; padding: 1rem 1.5rem; color: rgba(255, 255, 255, 0.9); text-decoration: none; transition: all 0.3s ease; border-left: 4px solid transparent; position: relative; margin: 0.25rem 0; }
        .nav-link:hover { background: rgba(255,255,255,0.12); transform: translateX(4px); color: #fff; }
        .nav-link.active { background: rgba(255,255,255,0.18); border-left-color: #D4AF37; color: #F4D03F; transform: translateX(4px); }
        .nav-icon { font-size: 1.4rem; width: 1.8rem; text-align: center; opacity: 0.9; }
        .nav-text { font-weight: 500; font-size: 0.95rem; }
        .nav-divider { height: 2px; background: linear-gradient(90deg, transparent 0%, rgba(212, 175, 55, 0.3) 50%, transparent 100%); margin: 1.5rem 1.5rem; border-radius: 1px; }
        .admin-main { flex: 1; display: flex; flex-direction: column; min-height: 100vh; position: relative; }
        .admin-header { background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border-bottom: 2px solid rgba(139, 21, 56, 0.1); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); backdrop-filter: blur(10px); }
        .header-content { padding: 1.5rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        .header-title { font-size: 2rem; font-weight: 700; background: linear-gradient(135deg, #8B1538, #D4AF37); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .admin-content { flex: 1; padding: 0; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); }
    </style>
</head>

<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <nav class="admin-sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-title">Painel Admin</div>
                <div class="sidebar-subtitle">Paróquia São Paulo Apóstolo</div>
            </div>

            <div class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">📌 Principal</div>

                    @if(auth()->check())
                        @if(auth()->user()->role->value === 'admin_global')
                            <a href="{{ route('admin.global.dashboard') }}" class="nav-link {{ request()->routeIs('admin.global.dashboard') ? 'active' : '' }}">
                                <span class="nav-icon">🏠</span>
                                <span class="nav-text">Dashboard</span>
                            </a>
                            <a href="{{ route('admin.global.news.index') }}" class="nav-link {{ request()->routeIs('admin.global.news.*') ? 'active' : '' }}">
                                <span class="nav-icon">📰</span>
                                <span class="nav-text">Notícias</span>
                            </a>
                            <a href="{{ route('admin.global.events.index') }}" class="nav-link {{ request()->routeIs('admin.global.events.*') ? 'active' : '' }}">
                                <span class="nav-icon">📅</span>
                                <span class="nav-text">Eventos</span>
                            </a>
                        @elseif(auth()->user()->role->value === 'coordenador_de_pastoral')
                            <a href="{{ route('admin.coordenador.dashboard') }}" class="nav-link {{ request()->routeIs('admin.coordenador.dashboard') ? 'active' : '' }}">
                                <span class="nav-icon">🏠</span>
                                <span class="nav-text">Dashboard</span>
                            </a>
                            <a href="{{ route('admin.coordenador.news.index') }}" class="nav-link {{ request()->routeIs('admin.coordenador.news.*') ? 'active' : '' }}">
                                <span class="nav-icon">📰</span>
                                <span class="nav-text">Notícias</span>
                            </a>
                            <a href="{{ route('admin.coordenador.events.index') }}" class="nav-link {{ request()->routeIs('admin.coordenador.events.*') ? 'active' : '' }}">
                                <span class="nav-icon">📅</span>
                                <span class="nav-text">Eventos</span>
                            </a>
                        @elseif(auth()->user()->role->value === 'administrativo')
                            <a href="{{ route('admin.administrativo.news.index') }}" class="nav-link {{ request()->routeIs('admin.administrativo.news.*') ? 'active' : '' }}">
                                <span class="nav-icon">📰</span>
                                <span class="nav-text">Notícias</span>
                            </a>
                            <a href="{{ route('admin.administrativo.events.index') }}" class="nav-link {{ request()->routeIs('admin.administrativo.events.*') ? 'active' : '' }}">
                                <span class="nav-icon">📅</span>
                                <span class="nav-text">Eventos</span>
                            </a>
                        @endif
                    @endif
                </div>

                <div class="nav-divider"></div>

                <div class="nav-section">
                    <div class="nav-section-title">🔧 Sistema</div>
                    <a href="{{ route('home') }}" class="nav-link">
                        <span class="nav-icon">🌐</span>
                        <span class="nav-text">Ver Site Público</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                            <span class="nav-icon">🚪</span>
                            <span class="nav-text">Sair</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="admin-main">
            <header class="admin-header">
                <div class="header-content">
                    <h1 class="header-title">@yield('title', 'Dashboard')</h1>
                </div>
            </header>

            <main class="admin-content">
                @if (session('success'))
                    <div class="alert alert-success m-4">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger m-4">{{ session('error') }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }

        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const isClickInsideSidebar = sidebar.contains(event.target);

            if (!isClickInsideSidebar && window.innerWidth <= 768 && sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
            }
        });

        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth > 768) {
                sidebar.classList.remove('open');
            }
        });
    </script>
</body>
</html>
