<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Paróquia São Paulo Apóstolo')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/sao-paulo-logo.png') }}" alt="São Paulo Apóstolo" class="me-2" style="height: 40px;">
                <div>
                    <div class="fw-bold text-brand-vinho">São Paulo Apóstolo</div>
                    <small class="text-muted">Paróquia</small>
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
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.global.news.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.global.news.index') }}">
                                    <i class="bi bi-newspaper"></i> Notícias
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.global.events.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.global.events.index') }}">
                                    <i class="bi bi-calendar-event"></i> Eventos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.global.groups.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.global.groups.index') }}">
                                    <i class="bi bi-people"></i> Grupos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.global.masses.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.global.masses.index') }}">
                                    <i class="bi bi-peace"></i> Missas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.global.users') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.global.users') }}">
                                    <i class="bi bi-person-gear"></i> Usuários
                                </a>
                            </li>
                        @elseif(Auth::user()->role->value === 'coordenador_de_pastoral')
                            <!-- Menu Coordenador -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.coordenador.dashboard') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.coordenador.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.coordenador.news.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.coordenador.news.index') }}">
                                    <i class="bi bi-newspaper"></i> Notícias
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.coordenador.requests.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.coordenador.requests.index') }}">
                                    <i class="bi bi-envelope"></i> Solicitações
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">
                                    <i class="bi bi-house-door"></i> Site Público
                                </a>
                            </li>
                        @elseif(Auth::user()->role->value === 'administrativo')
                            <!-- Menu Administrativo -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.administrativo.dashboard') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.administrativo.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.administrativo.news.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.administrativo.news.index') }}">
                                    <i class="bi bi-newspaper"></i> Notícias
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.administrativo.masses.*') ? 'active text-brand-vinho fw-bold' : '' }}" href="{{ route('admin.administrativo.masses.index') }}">
                                    <i class="bi bi-peace"></i> Missas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">
                                    <i class="bi bi-house-door"></i> Site Público
                                </a>
                            </li>
                        @else
                            <!-- Menu Usuário Padrão -->
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
                        <!-- Menu não autenticado -->
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

                <!-- User Menu -->
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person"></i> Perfil
                                </a></li>
                                
                                @if(Auth::user()->role === 'usuario_padrao')
                                    <li><a class="dropdown-item" href="{{ route('group-requests.create') }}">
                                        <i class="bi bi-pencil-square"></i> Solicitar Entrada em Grupo
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('group-requests.index') }}">
                                        <i class="bi bi-list-check"></i> Minhas Solicitações
                                    </a></li>
                                @endif

                                @if(Auth::user()->role === 'coordenador_de_pastoral')
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.coordenador.dashboard') }}">
                                        <i class="bi bi-speedometer2"></i> Painel Coordenador
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.coordenador.requests.index') }}">
                                        <i class="bi bi-envelope"></i> Solicitações Pendentes
                                    </a></li>
                                @endif
                                
                                @if(Auth::user()->role === 'administrativo')
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.administrativo.dashboard') }}">
                                        <i class="bi bi-speedometer2"></i> Painel Administrativo
                                    </a></li>
                                @endif

                                @if(Auth::user()->role === 'admin_global')
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.global.dashboard') }}">
                                        <i class="bi bi-gear"></i> Admin Global
                                    </a></li>
                                @endif
                                
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> Sair
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

    <!-- Main Content -->
    <main style="margin-top: 80px;">
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
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
                        <li><a href="{{ route('home') }}"><i class="bi bi-house-door"></i> Início</a></li>
                        <li><a href="{{ route('groups') }}"><i class="bi bi-people"></i> Grupos e Pastorais</a></li>
                        <li><a href="{{ route('masses') }}"><i class="bi bi-peace"></i> Missas</a></li>
                        <li><a href="{{ route('events') }}"><i class="bi bi-calendar-event"></i> Eventos</a></li>
                        <li><a href="{{ route('news') }}"><i class="bi bi-newspaper"></i> Notícias</a></li>
                        @auth
                            @if(Auth::user()->role === 'usuario_padrao')
                                <li><a href="{{ route('group-requests.create') }}"><i class="bi bi-person-plus"></i> Participar de Grupo</a></li>
                            @endif
                        @else
                            <li><a href="{{ route('register') }}"><i class="bi bi-person-add"></i> Cadastre-se</a></li>
                            <li><a href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Entrar</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-lg-4 mb-4">
                    <h5 class="footer-title">Contato</h5>
                    <ul class="footer-contact">
                        <li><i class="bi bi-geo-alt"></i> Rua São Paulo Apóstolo, 123<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bairro Centro - São Paulo/SP</li>
                        <li><i class="bi bi-telephone"></i> <a href="tel:+5511999999999">(11) 99999-9999</a></li>
                        <li><i class="bi bi-envelope"></i> <a href="mailto:contato@saopauloapostolo.com">contato@saopauloapostolo.com</a></li>
                        <li><i class="bi bi-clock"></i> Seg-Sex: 8h-17h | Sáb: 8h-12h</li>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Debug Script para ícones -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Verifica se Bootstrap Icons está carregado
            const testIcon = document.createElement('i');
            testIcon.className = 'bi bi-house-door';
            document.body.appendChild(testIcon);
            
            const computedStyle = window.getComputedStyle(testIcon, '::before');
            const content = computedStyle.getPropertyValue('content');
            
            if (content && content !== 'none' && content !== '""') {
                console.log('✅ Bootstrap Icons carregado corretamente');
            } else {
                console.error('❌ Bootstrap Icons não carregou');
                console.log('Tentando carregar Bootstrap Icons como fallback...');
                
                // Fallback: carregar Bootstrap Icons novamente
                const link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css';
                document.head.appendChild(link);
            }
            
            document.body.removeChild(testIcon);
        });
    </script>
    
    @stack('scripts')
</body>
</html>