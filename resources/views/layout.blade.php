<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Paróquia São Paulo Apóstolo')</title>
    <meta name="description" content="@yield('meta_description', 'Site oficial da Paróquia São Paulo Apóstolo. Notícias, eventos, missas e informações da comunidade.')">
    <meta property="og:title" content="@yield('title', 'Paróquia São Paulo Apóstolo')">
    <meta property="og:description" content="@yield('meta_description', 'Site oficial da Paróquia São Paulo Apóstolo. Notícias, eventos, missas e informações da comunidade.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/sao-paulo-logo.png') }}">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="@yield('title', 'Paróquia São Paulo Apóstolo')">
    <meta name="twitter:description" content="@yield('meta_description', 'Site oficial da Paróquia São Paulo Apóstolo. Notícias, eventos, missas e informações da comunidade.')">
    <meta name="twitter:image" content="{{ asset('images/sao-paulo-logo.png') }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/sao-paulo-logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/sao-paulo-logo.png') }}">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Vite Assets (includes Bootstrap CSS and JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Garantir que o body ocupe toda a altura */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        /* Header fixo no topo */
        .navbar.fixed-top {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }
        
        /* Main content com espaçamento correto */
        .main-content {
            flex: 1 0 auto;
            margin-top: 80px;
            margin-bottom: 2rem;
            min-height: calc(100vh - 80px - 300px);
        }
        
        /* Footer fixo no final */
        .footer-paroquia {
            flex-shrink: 0;
            margin-top: auto;
        }
        
        /* Ajuste quando há alertas */
        .main-content.has-alert {
            margin-top: 140px;
        }
        
        /* Alertas fixos abaixo do header */
        .alert-container {
            position: fixed;
            top: 72px;
            left: 0;
            right: 0;
            z-index: 1025;
            padding: 0.5rem;
        }
        
        /* Mobile navbar improvements */
        @media (max-width: 768px) {
            .main-content {
                margin-top: 70px;
            }
            
            .navbar {
                padding: 0.5rem 0;
            }
            
            .navbar-brand {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            
            .navbar-brand img {
                height: 36px;
            }
            
            .navbar-brand > div {
                display: flex;
                flex-direction: column;
                line-height: 1.2;
            }
            
            .navbar-brand .fw-bold {
                font-size: 0.9rem;
            }
            
            .navbar-brand small {
                font-size: 0.7rem;
            }
            
            .navbar-toggler {
                padding: 0.5rem;
                font-size: 1.125rem;
            }
            
            .navbar-collapse {
                max-height: 70vh;
                overflow-y: auto;
                margin-top: 0.5rem;
            }
            
            .navbar-nav {
                padding: 0.5rem 0;
            }
            
            .nav-item {
                border-bottom: 1px solid rgba(0,0,0,0.05);
            }
            
            .nav-item:last-child {
                border-bottom: none;
            }
            
            .nav-link {
                padding: 0.875rem 0.5rem !important;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            
            .dropdown-menu {
                border: none;
                box-shadow: none;
                background-color: #f8f9fa;
                padding: 0;
            }
            
            .dropdown-item {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 576px) {
            .main-content {
                margin-top: 65px;
            }
            
            .navbar-brand .fw-bold {
                font-size: 0.8rem;
            }
            
            .navbar-brand small {
                font-size: 0.65rem;
            }
        }
    </style>
</head>
<body>
    <a class="visually-hidden-focusable" href="#main-content">Ir para o conteúdo</a>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/sao-paulo-logo.png') }}" alt="São Paulo Apóstolo" class="me-2" style="height: 40px;">
                <div>
                    <div class="fw-bold text-brand-vinho">Paróquia São Paulo Apóstolo</div>
                    <small class="text-muted">Diocese de Umuarama</small>
                </div>
            </a>

            <!-- Toggle button for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                        @if(Auth::user()->role->value === 'admin_global')
                            <!-- Menu Admin Global -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.global.dashboard') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.global.dashboard') }}">
                                    <i class="bi bi-speedometer2" aria-hidden="true"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.global.news.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.global.news.index') }}">
                                    <i class="bi bi-newspaper" aria-hidden="true"></i> Notícias
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.global.events.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.global.events.index') }}">
                                    <i class="bi bi-calendar-event" aria-hidden="true"></i> Eventos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.global.groups.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.global.groups.index') }}">
                                    <i class="bi bi-people" aria-hidden="true"></i> Grupos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.global.masses.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.global.masses.index') }}">
                                    <i class="bi bi-clock" aria-hidden="true"></i> Missas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.global.users') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.global.users') }}">
                                    <i class="bi bi-person-gear" aria-hidden="true"></i> Usuários
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('home') || request()->routeIs('groups') || request()->routeIs('masses') || request()->routeIs('events') || request()->routeIs('news') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('home') }}">
                                    <i class="bi bi-globe" aria-hidden="true"></i> Site Público
                                </a>
                            </li>
                        @elseif(Auth::user()->role->value === 'coordenador_de_pastoral')
                            <!-- Menu Coordenador -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.coordenador.dashboard') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.coordenador.dashboard') }}">
                                    <i class="bi bi-speedometer2" aria-hidden="true"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.coordenador.news.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.coordenador.news.index') }}">
                                    <i class="bi bi-newspaper" aria-hidden="true"></i> Notícias
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.coordenador.scales.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.coordenador.scales.index') }}">
                                    <i class="bi bi-calendar3" aria-hidden="true"></i> Escalas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.coordenador.requests.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.coordenador.requests.index') }}">
                                    <i class="bi bi-envelope" aria-hidden="true"></i> Solicitações
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('home') || request()->routeIs('groups') || request()->routeIs('masses') || request()->routeIs('events') || request()->routeIs('news') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('home') }}">
                                    <i class="bi bi-globe" aria-hidden="true"></i> Site Público
                                </a>
                            </li>
                        @elseif(Auth::user()->role->value === 'administrativo')
                            <!-- Menu Administrativo -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.administrativo.dashboard') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.administrativo.dashboard') }}">
                                    <i class="bi bi-speedometer2" aria-hidden="true"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.administrativo.news.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.administrativo.news.index') }}">
                                    <i class="bi bi-newspaper" aria-hidden="true"></i> Notícias
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.administrativo.masses.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.administrativo.masses.index') }}">
                                    <i class="bi bi-clock" aria-hidden="true"></i> Missas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('home') || request()->routeIs('groups') || request()->routeIs('masses') || request()->routeIs('events') || request()->routeIs('news') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('home') }}">
                                    <i class="bi bi-globe" aria-hidden="true"></i> Site Público
                                </a>
                            </li>
                        @else
                            <!-- Menu Usuário Padrão -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('user.dashboard') }}">
                                    <i class="bi bi-house-heart" aria-hidden="true"></i> Minha Área
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('home') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('home') }}">
                                    <i class="bi bi-globe" aria-hidden="true"></i> Início
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('groups') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('groups') }}">
                                    <i class="bi bi-people" aria-hidden="true"></i> Grupos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('masses') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('masses') }}">
                                    <i class="bi bi-clock" aria-hidden="true"></i> Missas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('events') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('events') }}">
                                    <i class="bi bi-calendar-event" aria-hidden="true"></i> Eventos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('news') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('news') }}">
                                    <i class="bi bi-newspaper" aria-hidden="true"></i> Notícias
                                </a>
                            </li>
                            @if(Auth::user()->parishGroup && Auth::user()->parishGroup->id == 5)
                                <!-- Menu especial para Coroinhas -->
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('user.scales.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('user.scales.index') }}">
                                        <i class="bi bi-calendar3" aria-hidden="true"></i> Escalas
                                    </a>
                                </li>
                            @endif
                        @endif
                    @else
                        <!-- Menu não autenticado -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('home') }}">
                                <i class="bi bi-house-door" aria-hidden="true"></i> Início
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('groups') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('groups') }}">
                                <i class="bi bi-people" aria-hidden="true"></i> Grupos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('masses') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('masses') }}">
                                <i class="bi bi-clock" aria-hidden="true"></i> Missas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('events') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('events') }}">
                                <i class="bi bi-calendar-event" aria-hidden="true"></i> Eventos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('news') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('news') }}">
                                <i class="bi bi-newspaper" aria-hidden="true"></i> Notícias
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('about') }}">
                                <i class="bi bi-info-circle" aria-hidden="true"></i> Sobre
                            </a>
                        </li>
                    @endauth
                </ul>

                <!-- User Menu -->
                <ul class="navbar-nav">
                    @auth
                        <!-- Notifications Bell -->
                        <li class="nav-item dropdown me-2">
                            @php
                                try {
                                    $unreadCount = Auth::user()->notifications()->whereNull('read_at')->count();
                                } catch (\Exception $e) {
                                    $unreadCount = 0;
                                    \Log::error('Erro ao carregar notificações: ' . $e->getMessage());
                                }
                            @endphp
                            <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-bell" aria-hidden="true" style="font-size: 1.2rem;"></i>
                                @if($unreadCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                    </span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" style="min-width: 320px;">
                                <li class="dropdown-header d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Notificações</span>
                                    @if($unreadCount > 0)
                                        <span class="badge bg-danger">{{ $unreadCount }}</span>
                                    @endif
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                @php
                                    try {
                                        $recentNotifications = Auth::user()->notifications()->latest()->limit(5)->get();
                                    } catch (\Exception $e) {
                                        $recentNotifications = collect([]);
                                        \Log::error('Erro ao carregar notificações recentes: ' . $e->getMessage());
                                    }
                                @endphp
                                @forelse($recentNotifications as $notif)
                                    <li>
                                        <div class="dropdown-item-text small {{ $notif->read_at ? 'text-muted' : '' }}" style="white-space: normal;">
                                            <div class="d-flex align-items-start">
                                                <div class="rounded-circle circle-center me-2" style="width: 30px; height: 30px; min-width: 30px; background: var(--bg-rose);">
                                                    @php
                                                        $icon = 'bi-bell';
                                                        if ($notif->type === 'news_published') $icon = 'bi-newspaper';
                                                        elseif ($notif->type === 'event_published') $icon = 'bi-calendar-event';
                                                        elseif ($notif->type === 'scale_published') $icon = 'bi-file-earmark-pdf';
                                                        elseif ($notif->type === 'group_request_status_changed') $icon = 'bi-clipboard-check';
                                                    @endphp
                                                    <i class="bi {{ $icon }}" aria-hidden="true" style="color: var(--brand-vinho) !important; font-size: 0.85rem;"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="fw-semibold" style="font-size: 0.85rem;">{{ $notif->title }}</div>
                                                    <div class="text-muted" style="font-size: 0.75rem;">{{ Str::limit($notif->message, 60) }}</div>
                                                    <div class="text-muted" style="font-size: 0.7rem;">{{ $notif->created_at->diffForHumans() }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @if(!$loop->last)
                                        <li><hr class="dropdown-divider"></li>
                                    @endif
                                @empty
                                    <li class="dropdown-item-text text-center text-muted small py-3">
                                        <i class="bi bi-bell-slash d-block mb-1" aria-hidden="true" style="font-size: 1.5rem;"></i>
                                        Nenhuma notificação
                                    </li>
                                @endforelse
                                @if($recentNotifications->isNotEmpty())
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-center small fw-semibold" href="{{ route('notifications.index') }}" style="color: var(--brand-vinho);">
                                            Ver todas as notificações
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle" aria-hidden="true"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <!-- Perfil (sempre visível) -->
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person" aria-hidden="true"></i> Meu Perfil
                                    </a>
                                </li>
                                
                                <li><hr class="dropdown-divider"></li>
                                
                                <!-- Links específicos por role -->
                                @if(Auth::user()->role->value === 'admin_global')
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.global.dashboard') }}">
                                            <i class="bi bi-speedometer2" aria-hidden="true"></i> Dashboard Admin
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.global.users') }}">
                                            <i class="bi bi-person-gear" aria-hidden="true"></i> Gerenciar Usuários
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('home') }}">
                                            <i class="bi bi-globe" aria-hidden="true"></i> Ver Site Público
                                        </a>
                                    </li>
                                @elseif(Auth::user()->role->value === 'coordenador_de_pastoral')
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.coordenador.dashboard') }}">
                                            <i class="bi bi-speedometer2" aria-hidden="true"></i> Meu Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.coordenador.requests.index') }}">
                                            <i class="bi bi-envelope" aria-hidden="true"></i> Solicitações Pendentes
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.coordenador.scales.index') }}">
                                            <i class="bi bi-calendar3" aria-hidden="true"></i> Minhas Escalas
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('home') }}">
                                            <i class="bi bi-globe" aria-hidden="true"></i> Ver Site Público
                                        </a>
                                    </li>
                                @elseif(Auth::user()->role->value === 'administrativo')
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.administrativo.dashboard') }}">
                                            <i class="bi bi-speedometer2" aria-hidden="true"></i> Meu Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.administrativo.news.index') }}">
                                            <i class="bi bi-newspaper" aria-hidden="true"></i> Gerenciar Notícias
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.administrativo.masses.index') }}">
                                            <i class="bi bi-clock" aria-hidden="true"></i> Gerenciar Missas
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('home') }}">
                                            <i class="bi bi-globe" aria-hidden="true"></i> Ver Site Público
                                        </a>
                                    </li>
                                @else
                                    <!-- Usuário Padrão -->
                                    <li>
                                        <a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                            <i class="bi bi-house-heart" aria-hidden="true"></i> Minha Área
                                        </a>
                                    </li>
                                    
                                    @if(Auth::user()->parish_group_id)
                                        {{-- Usuário está em um grupo --}}
                                        <li>
                                            <a class="dropdown-item d-flex align-items-start" style="white-space: normal; cursor: default;" onclick="return false;">
                                                <i class="bi bi-check-circle-fill text-success me-2 mt-1 flex-shrink-0" aria-hidden="true"></i>
                                                <div>
                                                    <strong>Meu Grupo Principal</strong>
                                                    <small class="d-block text-muted">{{ Auth::user()->parishGroup->name }}</small>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        <a class="dropdown-item" href="{{ route('group-requests.create') }}">
                                            <i class="bi bi-pencil-square" aria-hidden="true"></i> Solicitar Entrada em Grupo
                                        </a>
                                    </li>
                                    
                                    <li>
                                        <a class="dropdown-item" href="{{ route('group-requests.my-requests') }}">
                                            <i class="bi bi-list-check" aria-hidden="true"></i> Minhas Solicitações
                                        </a>
                                    </li>
                                    
                                    @if(Auth::user()->parishGroup && Auth::user()->parishGroup->requires_scale)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('user.scales.index') }}">
                                                <i class="bi bi-calendar3" aria-hidden="true"></i> Minhas Escalas
                                            </a>
                                        </li>
                                    @endif
                                @endif
                                
                                <li><hr class="dropdown-divider"></li>
                                
                                <!-- Logout (sempre visível) -->
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right" aria-hidden="true"></i> Sair
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right" aria-hidden="true"></i> Entrar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-primary-paroquia text-white px-3 py-2 rounded" href="{{ route('register') }}">
                                <i class="bi bi-person-plus" aria-hidden="true"></i> Cadastrar
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main id="main-content" tabindex="-1" class="main-content {{ (session('success') || session('error') || session('warning')) ? 'has-alert' : '' }}">
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2" aria-hidden="true"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2" aria-hidden="true"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('warning'))
            <div class="container mt-3">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2" aria-hidden="true"></i>{{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-paroquia">
        <div class="container">
            <div class="row">
                <!-- About Section -->
                <div class="col-lg-4 mb-4">
                    <h5 class="footer-title">Paróquia São Paulo Apóstolo</h5>
                    <p class="footer-text">
                        Uma comunidade de fé inspirada no exemplo missionário de São Paulo Apóstolo, 
                        levando o Evangelho a todos os corações.
                    </p>
                    <p class="footer-verse">
                        <em>"Ai de mim se não evangelizar!" - 1 Cor 9:16</em>
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-4 mb-4">
                    <h5 class="footer-title">Links Rápidos</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}"><i class="bi bi-house-door" aria-hidden="true"></i> Início</a></li>
                        <li><a href="{{ route('groups') }}"><i class="bi bi-people" aria-hidden="true"></i> Grupos e Pastorais</a></li>
                        <li><a href="{{ route('masses') }}"><i class="bi bi-clock" aria-hidden="true"></i> Missas</a></li>
                        <li><a href="{{ route('events') }}"><i class="bi bi-calendar-event" aria-hidden="true"></i> Eventos</a></li>
                        <li><a href="{{ route('news') }}"><i class="bi bi-newspaper" aria-hidden="true"></i> Notícias</a></li>
                        @auth
                            @if(Auth::user()->role === 'usuario_padrao')
                                <li><a href="{{ route('group-requests.create') }}"><i class="bi bi-person-plus" aria-hidden="true"></i> Participar de Grupo</a></li>
                            @endif
                        @else
                            <li><a href="{{ route('register') }}"><i class="bi bi-person-add" aria-hidden="true"></i> Cadastre-se</a></li>
                            <li><a href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right" aria-hidden="true"></i> Entrar</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-lg-4 mb-4">
                    <h5 class="footer-title">Contato</h5>
                    <ul class="footer-contact">
                        <li><i class="bi bi-geo-alt" aria-hidden="true"></i> Av. General Mascarenhas de Morais, 4969<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Zona V - Umuarama/PR - CEP 87504-090</li>
                        <li><i class="bi bi-telephone" aria-hidden="true"></i> <a href="https://wa.me/554430554464" target="_blank">(44) 3055-4464</a></li>
                        <li><i class="bi bi-envelope" aria-hidden="true"></i> <a href="mailto:secretaria_pspaulo@hotmail.com">secretaria_pspaulo@hotmail.com</a></li>
                        <li><i class="bi bi-clock" aria-hidden="true"></i> Secretaria:<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Seg: 8h-12h / 14h-17h30<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Qua-Sex: 8h-12h / 14h-17h30<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sáb: 8h-12h</li>
                        <li class="mt-2">
                            <a href="https://www.instagram.com/paroquiasaopauloumu" target="_blank" class="text-white me-3" title="Instagram">
                                <i class="bi bi-instagram" aria-hidden="true"></i> @paroquiasaopauloumu
                            </a><br>
                            <a href="https://www.facebook.com/paroquiasaopauloumu" target="_blank" class="text-white" title="Facebook">
                                <i class="bi bi-facebook" aria-hidden="true"></i> Facebook
                            </a>
                        </li>
                    </ul>
                    <p class="footer-text mt-2">
                        <small>Diocese de Umuarama</small>
                    </p>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="row">
                    <div class="col-12 text-center">
                        <p>&copy; {{ date('Y') }} Paróquia São Paulo Apóstolo. Todos os direitos reservados.</p>
                        <p class="footer-verse">
                            "Graça e paz da parte de Deus nosso Pai e do Senhor Jesus Cristo" - Ef 1:2
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>