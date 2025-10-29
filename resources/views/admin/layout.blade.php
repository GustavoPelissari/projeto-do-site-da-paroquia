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
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Crimson+Text:ital,wght@0,400;0,600;1,400&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    
    <!-- CSS Global (mesmo do sistema público) -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    
    <!-- Styles Específicos -->
    @stack('styles')
    
    <!-- Laravel Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Layout Admin Styles Melhorados */
        .admin-layout {
            min-height: 100vh;
            display: flex;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        /* Sidebar Melhorada */
        .admin-sidebar {
            width: 300px;
            background: linear-gradient(180deg, #8B1538 0%, #A91B47 50%, #731029 100%);
            color: white;
            box-shadow: 0 10px 40px rgba(139, 21, 56, 0.3);
            z-index: 100;
            position: relative;
            overflow: hidden;
        }

        .admin-sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="crosses" patternUnits="userSpaceOnUse" width="20" height="20"><path d="M10,3 L10,17 M3,10 L17,10" stroke="rgba(255,255,255,0.05)" stroke-width="1" fill="none"/></pattern></defs><rect width="100" height="100" fill="url(%23crosses)"/></svg>');
            opacity: 0.3;
        }

        .admin-sidebar::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(180deg, transparent 0%, rgba(212, 175, 55, 0.3) 50%, transparent 100%);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            background: rgba(0,0,0,0.15);
            border-bottom: 2px solid rgba(212, 175, 55, 0.3);
            position: relative;
            z-index: 2;
        }
        
        /* Special styling for admin_global */
        .admin-layout.admin-global .sidebar-header {
            background: linear-gradient(135deg, rgba(139, 21, 56, 0.9) 0%, rgba(212, 175, 55, 0.3) 100%);
            border-bottom: 3px solid #D4AF37;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        
        .admin-layout.admin-global .sidebar-title {
            text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
            background: linear-gradient(45deg, #FFFFFF, #F4D03F);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .admin-layout.admin-global .admin-sidebar {
            background: linear-gradient(180deg, #8B1538 0%, #A91B47 70%, #D4AF37 100%);
            border-right: 3px solid rgba(212, 175, 55, 0.5);
        }

        .sidebar-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--sp-white);
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            position: relative;
            z-index: 2;
        }

        .sidebar-subtitle {
            font-size: 0.875rem;
            color: var(--sp-gold-light);
            margin-top: var(--space-1);
            position: relative;
            z-index: 2;
        }

        .sidebar-nav {
            padding: 1rem 0;
            position: relative;
            z-index: 2;
        }

        .nav-section {
            margin-bottom: 2rem;
        }

        .nav-section-title {
            font-size: 0.8rem;
            font-weight: 700;
            color: #F4D03F;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 0 1.5rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 4px solid transparent;
            position: relative;
            margin: 0.25rem 0;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 0;
            background: linear-gradient(45deg, #D4AF37, #F4D03F);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-link:hover {
            background: linear-gradient(90deg, rgba(255,255,255,0.15), rgba(212, 175, 55, 0.1));
            transform: translateX(4px);
            color: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .nav-link:hover::before {
            width: 4px;
        }

        .nav-link.active {
            background: linear-gradient(90deg, rgba(255,255,255,0.2), rgba(212, 175, 55, 0.15));
            border-left-color: #D4AF37;
            color: #F4D03F;
            transform: translateX(4px);
            box-shadow: 0 4px 20px rgba(212, 175, 55, 0.3);
        }

        .nav-link.active::before {
            width: 4px;
        }

        .nav-icon {
            font-size: 1.4rem;
            width: 1.8rem;
            text-align: center;
            opacity: 0.9;
        }

        .nav-text {
            font-weight: 500;
            font-size: 0.95rem;
        }

        .nav-divider {
            height: 2px;
            background: linear-gradient(90deg, transparent 0%, rgba(212, 175, 55, 0.3) 50%, transparent 100%);
            margin: 1.5rem 1.5rem;
            border-radius: 1px;
        }

        /* Main Content Melhorado */
        .admin-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            position: relative;
        }

        .admin-header {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-bottom: 2px solid rgba(139, 21, 56, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(10px);
        }

        .header-content {
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-title {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #8B1538, #D4AF37);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: #4a5568;
        }

        /* User avatar improvements */
        .user-avatar {
            width: 3rem;
            height: 3rem;
            background: linear-gradient(135deg, #8B1538, #A91B47);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            box-shadow: 0 4px 16px rgba(139, 21, 56, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }
        
        /* Special avatar styling for admin_global (priest) */
        .admin-layout.admin-global .user-avatar {
            background: linear-gradient(135deg, #D4AF37 0%, #F4D03F 100%);
            color: #8B1538;
            border: 3px solid #8B1538;
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.5);
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            background: linear-gradient(135deg, #8B1538, #D4AF37);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .user-role {
            font-size: 0.9rem;
            color: #718096;
            font-weight: 500;
        }

        /* Content Melhorado */
        .admin-content {
            flex: 1;
            padding: 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        /* Alerts */
        .admin-alert {
            margin: var(--space-4) var(--space-6) 0;
            padding: var(--space-4);
            border-radius: var(--border-radius-lg);
            border-left: 4px solid;
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .admin-alert-success {
            background: var(--sp-green-50);
            border-left-color: var(--sp-green);
            color: var(--sp-green-dark);
        }

        .admin-alert-error {
            background: var(--sp-red-50);
            border-left-color: var(--sp-red);
            color: var(--sp-red-dark);
        }

        .alert-icon {
            font-size: 1.25rem;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .admin-layout {
                flex-direction: column;
            }
            
            .admin-sidebar {
                width: 100%;
                position: fixed;
                top: 0;
                left: -100%;
                height: 100vh;
                z-index: 1000;
                transition: var(--transition-all);
            }
            
            .admin-sidebar.open {
                left: 0;
            }
            
            .admin-main {
                margin-left: 0;
            }
            
            .header-content {
                padding: var(--space-4);
            }
            
            .header-title {
                font-size: 1.5rem;
            }
            
            .user-info {
                display: none;
            }
        }
    </style>
</head>
<body class="sp-font-primary @if(auth()->user()->role->value === 'admin_global') admin-global @endif">
    <div class="admin-layout">
        <!-- Sidebar -->
        <nav class="admin-sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2 class="sidebar-title">⛪ Painel Admin</h2>
                <p class="sidebar-subtitle">São Paulo Apóstolo</p>
            </div>
            
            <div class="sidebar-nav">
                <!-- Seção Principal -->
                <div class="nav-section">
                    <div class="nav-section-title">📊 Principal</div>
                    @if(auth()->user()->role === 'admin_global')
                        <a href="{{ route('admin.global.dashboard') }}" class="nav-link {{ request()->routeIs('admin.global.dashboard') ? 'active' : '' }}">
                            <span class="nav-icon">⛪</span>
                            <span class="nav-text">Dashboard Padre</span>
                        </a>
                        <a href="{{ route('admin.global.stats') }}" class="nav-link {{ request()->routeIs('admin.global.stats') ? 'active' : '' }}">
                            <span class="nav-icon">📈</span>
                            <span class="nav-text">Estatísticas Paroquiais</span>
                        </a>
                    @elseif(auth()->user()->role === 'coordenador_de_pastoral')
                        <a href="{{ route('admin.coordenador.dashboard') }}" class="nav-link {{ request()->routeIs('admin.coordenador.dashboard') ? 'active' : '' }}">
                            <span class="nav-icon">�‍🏫</span>
                            <span class="nav-text">Dashboard Coordenador</span>
                        </a>
                    @else
                        <a href="{{ \App\Helpers\DashboardHelper::getDashboardRoute(auth()->user()->role) }}" class="nav-link {{ request()->routeIs('admin.*.dashboard') ? 'active' : '' }}">
                            <span class="nav-icon">📊</span>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    @endif
                </div>

                <!-- Seção Conteúdo -->
                <div class="nav-section">
                    <div class="nav-section-title">📝 Conteúdo</div>
                    @if(auth()->user()->role === 'coordenador_de_pastoral')
                        <a href="{{ route('admin.coordenador.news.index') }}" class="nav-link {{ request()->routeIs('admin.coordenador.news.*') ? 'active' : '' }}">
                            <span class="nav-icon">📰</span>
                            <span class="nav-text">Minhas Notícias</span>
                        </a>
                        <a href="{{ route('admin.coordenador.events.index') }}" class="nav-link {{ request()->routeIs('admin.coordenador.events.*') ? 'active' : '' }}">
                            <span class="nav-icon">📅</span>
                            <span class="nav-text">Meus Eventos</span>
                        </a>
                    @else
                        @if(auth()->user()->role->value === 'admin_global')
                            <a href="{{ route('admin.global.news.index') }}" class="nav-link {{ request()->routeIs('admin.global.news.*') ? 'active' : '' }}">
                                <span class="nav-icon">📰</span>
                                <span class="nav-text">Notícias</span>
                            </a>
                            <a href="{{ route('admin.global.events.index') }}" class="nav-link {{ request()->routeIs('admin.global.events.*') ? 'active' : '' }}">
                                <span class="nav-icon">📅</span>
                                <span class="nav-text">Eventos</span>
                            </a>
                        @elseif(auth()->user()->role->value === 'coordenador_de_pastoral')
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

                <!-- Seção Comunidade -->
                @if(auth()->user()->role->value === 'coordenador_de_pastoral')
                    <div class="nav-section">
                        <div class="nav-section-title">👤 Coroinhas</div>
                        <a href="{{ route('admin.coordenador.requests.index') }}" class="nav-link {{ request()->routeIs('admin.coordenador.requests.*') ? 'active' : '' }}">
                            <span class="nav-icon">📥</span>
                            <span class="nav-text">Solicitações</span>
                        </a>
                        <a href="{{ route('admin.coordenador.schedules.index') }}" class="nav-link {{ request()->routeIs('admin.coordenador.schedules.*') ? 'active' : '' }}">
                            <span class="nav-icon">📋</span>
                            <span class="nav-text">Escalas</span>
                        </a>
                    </div>
                @else
                    <div class="nav-section">
                        <div class="nav-section-title">👥 Comunidade</div>
                        @if(auth()->user()->role->value === 'admin_global')
                            <a href="{{ route('admin.global.groups.index') }}" class="nav-link {{ request()->routeIs('admin.global.groups.*') ? 'active' : '' }}">
                                <span class="nav-icon">👥</span>
                                <span class="nav-text">Grupos</span>
                            </a>
                        @endif
                        <a href="{{ route('group-requests.index') }}" class="nav-link {{ request()->routeIs('group-requests.*') ? 'active' : '' }}">
                            <span class="nav-icon">📥</span>
                            <span class="nav-text">Solicitações</span>
                        </a>
                    </div>
                @endif

                <!-- Seção Liturgia -->
                <div class="nav-section">
                    <div class="nav-section-title">⛪ Liturgia</div>
                    @if(auth()->user()->role->value === 'admin_global')
                        <a href="{{ route('admin.global.masses.index') }}" class="nav-link {{ request()->routeIs('admin.global.masses.*') ? 'active' : '' }}">
                            <span class="nav-icon">⛪</span>
                            <span class="nav-text">Horários de Missa</span>
                        </a>
                    @endif
                    @if(auth()->user()->role->value === 'coordenador_de_pastoral')
                        <a href="{{ route('admin.coordenador.masses.index') }}" class="nav-link {{ request()->routeIs('admin.coordenador.masses.*') ? 'active' : '' }}">
                            <span class="nav-icon">⛪</span>
                            <span class="nav-text">Horários de Missa</span>
                        </a>
                    @endif
                    @if(auth()->user()->role->value === 'administrativo')
                        <a href="{{ route('admin.administrativo.masses.index') }}" class="nav-link {{ request()->routeIs('admin.administrativo.masses.*') ? 'active' : '' }}">
                            <span class="nav-icon">⛪</span>
                            <span class="nav-text">Horários de Missa</span>
                        </a>
                    @endif
                </div>

                <div class="nav-divider"></div>

                <!-- Seção Sistema -->
                <div class="nav-section">
                    <div class="nav-section-title">🔧 Sistema</div>
                    @if(auth()->user()->role->value === 'admin_global')
                        <a href="{{ route('admin.global.users') }}" class="nav-link {{ request()->routeIs('admin.global.users') ? 'active' : '' }}">
                            <span class="nav-icon">👥</span>
                            <span class="nav-text">Gerenciar Usuários</span>
                        </a>
                        <a href="{{ route('admin.global.system') }}" class="nav-link {{ request()->routeIs('admin.global.system') ? 'active' : '' }}">
                            <span class="nav-icon">⚙️</span>
                            <span class="nav-text">Visão do Sistema</span>
                        </a>
                    @endif
                    <a href="{{ route('home') }}" class="nav-link">
                        <span class="nav-icon">🌐</span>
                        <span class="nav-text">Ver Site Público</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link w-full text-left border-0 bg-transparent">
                            <span class="nav-icon">🚪</span>
                            <span class="nav-text">Sair</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="admin-main">
            <!-- Header -->
            <header class="admin-header">
                <div class="header-content">
                    <h1 class="header-title">@yield('title', 'Dashboard')</h1>
                    <div class="header-user">
                        <div class="user-avatar">
                            @if(auth()->user()->profile_photo_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url(auth()->user()->profile_photo_path) }}" 
                                     alt="{{ auth()->user()->name }}"
                                     style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            @else
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            @endif
                        </div>
                        <div class="user-info">
                            <div class="user-name">{{ auth()->user()->name }}</div>
                            <div class="user-role">
                                @switch(auth()->user()->role)
                                    @case('admin_global')
                                        ⛪ Padre - Admin Global
                                        @break
                                    @case('administrativo')
                                        📋 Administrativo
                                        @break
                                    @case('coordenador_de_pastoral')
                                        🎯 Coordenador de Pastoral
                                        @break
                                    @default
                                        👤 Usuário
                                @endswitch
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="admin-content">
                @if (session('success'))
                    <div class="admin-alert admin-alert-success">
                        <span class="alert-icon">✅</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="admin-alert admin-alert-error">
                        <span class="alert-icon">❌</span>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Menu Toggle (se necessário) -->
    <script>
        // Mobile menu toggle functionality
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const isClickInsideSidebar = sidebar.contains(event.target);
            
            if (!isClickInsideSidebar && window.innerWidth <= 768 && sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth > 768) {
                sidebar.classList.remove('open');
            }
        });
    </script>
</body>
</html>