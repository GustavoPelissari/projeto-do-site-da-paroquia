<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Paróquia São Paulo Apóstolo')</title>
    <meta name="description" content="@yield('meta_description', 'Portal administrativo e área de membros da Paróquia São Paulo Apóstolo.')">
    <meta property="og:title" content="@yield('title', 'Paróquia São Paulo Apóstolo')">
    <meta property="og:description" content="@yield('meta_description', 'Portal administrativo e área de membros da Paróquia São Paulo Apóstolo.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/sao-paulo-logo.png') }}">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="@yield('title', 'Paróquia São Paulo Apóstolo')">
    <meta name="twitter:description" content="@yield('meta_description', 'Portal administrativo e área de membros da Paróquia São Paulo Apóstolo.')">
    <meta name="twitter:image" content="{{ asset('images/sao-paulo-logo.png') }}">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/sao-paulo-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/sao-paulo-logo.png') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a class="visually-hidden-focusable" href="#main-content">Ir para o conteúdo</a>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/sao-paulo-logo.png') }}" alt="São Paulo Apóstolo" class="me-2" style="height: 40px;">
                <div>
                    <div class="fw-bold text-brand-vinho">Paróquia São Paulo Apóstolo</div>
                    <small class="text-muted">Diocese de Umuarama</small>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                        @if(Auth::user()->role->value === 'admin_global')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.global.dashboard') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.global.dashboard') }}">
                                    <i class="bi bi-speedometer2" aria-hidden="true"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.global.news.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.global.news.index') }}">
                                    <i class="bi bi-newspaper" aria-hidden="true"></i> Gerenciar Notícias
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.global.events.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.global.events.index') }}">
                                    <i class="bi bi-calendar-event" aria-hidden="true"></i> Gerenciar Eventos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.global.groups.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.global.groups.index') }}">
                                    <i class="bi bi-people" aria-hidden="true"></i> Gerenciar Grupos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.global.masses.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.global.masses.index') }}">
                                    <i class="bi bi-clock" aria-hidden="true"></i> Gerenciar Missas
                                </a>
                            </li>
                        @elseif(Auth::user()->role->value === 'coordenador_de_pastoral')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.coordenador.dashboard') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.coordenador.dashboard') }}">
                                    <i class="bi bi-speedometer2" aria-hidden="true"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">
                                    <i class="bi bi-house-door" aria-hidden="true"></i> Início
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('groups') }}">Grupos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('masses') }}">Missas</a>
                            </li>
                        @elseif(Auth::user()->role->value === 'administrativo')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.administrativo.dashboard') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.administrativo.dashboard') }}">
                                    <i class="bi bi-speedometer2" aria-hidden="true"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">
                                    <i class="bi bi-house-door" aria-hidden="true"></i> Início
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('news') }}">Notícias</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('masses') }}">Missas</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Início</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('groups') }}">Grupos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('masses') }}">Missas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('events') }}">Eventos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('news') }}">Notícias</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('groups') }}">Grupos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('masses') }}">Missas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('events') }}">Eventos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('news') }}">Notícias</a>
                        </li>
                    @endauth
                </ul>

                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                                @if(Auth::user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                @else
                                    <i class="bi bi-person-circle" aria-hidden="true"></i>
                                @endif
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person" aria-hidden="true"></i> Perfil
                                </a></li>
                                
                                @if(Auth::user()->role === 'usuario_padrao')
                                    <li><a class="dropdown-item" href="{{ route('group-requests.create') }}">
                                        <i class="bi bi-pencil-square" aria-hidden="true"></i> Solicitar Entrada em Grupo
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('group-requests.index') }}">
                                        <i class="bi bi-list-check" aria-hidden="true"></i> Minhas Solicitações
                                    </a></li>
                                @endif

                                @if(Auth::user()->role === 'coordenador_de_pastoral')
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.coordenador.dashboard') }}">
                                        <i class="bi bi-speedometer2" aria-hidden="true"></i> Painel Coordenador
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.coordenador.requests.index') }}">
                                        <i class="bi bi-envelope" aria-hidden="true"></i> Solicitações Pendentes
                                    </a></li>
                                @endif
                                
                                @if(Auth::user()->role === 'administrativo')
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.administrativo.dashboard') }}">
                                        <i class="bi bi-speedometer2" aria-hidden="true"></i> Painel Administrativo
                                    </a></li>
                                @endif

                                @if(Auth::user()->role === 'admin_global')
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.global.dashboard') }}">
                                        <i class="bi bi-gear" aria-hidden="true"></i> Admin Global
                                    </a></li>
                                @endif
                                
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right" aria-hidden="true"></i> Sair
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Entrar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-primary-paroquia" href="{{ route('register') }}">Cadastrar</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main id="main-content" tabindex="-1" style="margin-top: 80px;">
        <div class="container mt-3">
            @if(session('success'))
                <x-alert type="success">
                    {{ session('success') }}
                </x-alert>
            @endif
            
            @if(session('error'))
                <x-alert type="error">
                    {{ session('error') }}
                </x-alert>
            @endif

            @if(session('warning'))
                <x-alert type="warning">
                    {{ session('warning') }}
                </x-alert>
            @endif

            @if(session('info'))
                <x-alert type="info">
                    {{ session('info') }}
                </x-alert>
            @endif
        </div>

        @yield('content')
    </main>

    <footer class="footer-paroquia">
        <div class="container">
            <div class="row">
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

                <div class="col-lg-4 mb-4">
                    <h5 class="footer-title">Contato</h5>
                    <ul class="footer-contact">
                        <li><i class="bi bi-geo-alt" aria-hidden="true"></i> Rua São Paulo Apóstolo, 123<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bairro Centro - São Paulo/SP</li>
                        <li><i class="bi bi-telephone" aria-hidden="true"></i> <a href="tel:+5511999999999">(11) 99999-9999</a></li>
                        <li><i class="bi bi-envelope" aria-hidden="true"></i> <a href="mailto:contato@saopauloapostolo.com">contato@saopauloapostolo.com</a></li>
                        <li><i class="bi bi-clock" aria-hidden="true"></i> Seg-Sex: 8h-17h | Sáb: 8h-12h</li>
                    </ul>
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