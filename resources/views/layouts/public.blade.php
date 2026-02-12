<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Paróquia São Paulo Apóstolo - Umuarama PR')</title>
    <meta name="description" content="@yield('description', 'Paróquia São Paulo Apóstolo em Umuarama - PR. Uma comunidade de fé, esperança e caridade, inspirada no exemplo do Apóstolo dos Gentios.')">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="has-fixed-navbar">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top js-navbar-scroll">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/sao-paulo-logo.png') }}" alt="Logo São Paulo Apóstolo"
                     class="me-3 rounded-circle"
                     style="width: 56px; height: 56px; object-fit: cover;">
                <div>
                    <span class="d-block fw-semibold">Paróquia São Paulo Apóstolo</span>
                    <small class="d-block text-muted">Diocese de Umuarama</small>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house me-1"></i>Início
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('masses') ? 'active' : '' }}" href="{{ route('masses') }}">
                            <i class="bi bi-clock me-1"></i>Horários de Missa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('groups') ? 'active' : '' }}" href="{{ route('groups') }}">
                            <i class="bi bi-people me-1"></i>Pastorais
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('events') ? 'active' : '' }}" href="{{ route('events') }}">
                            <i class="bi bi-calendar-event me-1"></i>Eventos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('news') ? 'active' : '' }}" href="{{ route('news') }}">
                            <i class="bi bi-newspaper me-1"></i>Notícias
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contato">
                            <i class="bi bi-envelope me-1"></i>Contato
                        </a>
                    </li>
                </ul>

                <div class="d-flex gap-2 ms-lg-3 mt-3 mt-lg-0">
                    <a href="#doacoes" class="btn btn-warning">
                        <i class="bi bi-heart me-1"></i>Apoiar a Paróquia
                    </a>
                    @auth
                        <a href="{{ \App\Helpers\DashboardHelper::getDashboardRoute(auth()->user()->role) }}" class="btn btn-primary">
                            <i class="bi bi-gear me-1"></i>Admin
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Painel
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-dark text-light mt-5" id="contato">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ asset('images/sao-paulo-logo.png') }}" alt="Logo São Paulo Apóstolo" class="logo-footer">
                        <div>
                            <h5 class="mb-0">Paróquia São Paulo Apóstolo</h5>
                            <small>Diocese de Umuarama - PR</small>
                        </div>
                    </div>
                    <p class="mb-3">
                        Uma comunidade de fé, esperança e caridade,
                        inspirada no exemplo do Apóstolo dos Gentios.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-light" title="Facebook da Paróquia" aria-label="Facebook">
                            <i class="bi bi-facebook fs-4"></i>
                        </a>
                        <a href="#" class="text-light" title="Instagram da Paróquia" aria-label="Instagram">
                            <i class="bi bi-instagram fs-4"></i>
                        </a>
                        <a href="#" class="text-light" title="Canal do YouTube" aria-label="YouTube">
                            <i class="bi bi-youtube fs-4"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4">
                    <h6 class="mb-3">Navegação</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-light text-decoration-none">Início</a></li>
                        <li class="mb-2"><a href="{{ route('masses') }}" class="text-light text-decoration-none">Horários</a></li>
                        <li class="mb-2"><a href="{{ route('groups') }}" class="text-light text-decoration-none">Pastorais</a></li>
                        <li class="mb-2"><a href="{{ route('events') }}" class="text-light text-decoration-none">Eventos</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-4">
                    <h6 class="mb-3">Contato</h6>
                    <div class="d-flex align-items-start gap-2 mb-2">
                        <i class="bi bi-geo-alt mt-1"></i>
                        <span>
                            Av. General Mascarenhas de Morais, 4969<br>
                            Umuarama - PR
                        </span>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-telephone"></i>
                        <a href="tel:+5544305540464" class="text-light text-decoration-none">(44) 3055-4464</a>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-envelope"></i>
                        <a href="mailto:secretaria.pspaulo@hotmail.com" class="text-light text-decoration-none">secretaria.pspaulo@hotmail.com</a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <h6 class="mb-3">Horários de Missa</h6>
                    <div>
                        <div class="mb-1"><strong>Domingo:</strong> 09:30 e 18:00</div>
                        <div class="mb-1"><strong>Quarta:</strong> 20:00</div>
                        <div class="mb-1"><strong>Sábado:</strong> 19:30</div>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="row align-items-center">
                <div class="col-md-6">
                    <small>© 2025 Paróquia São Paulo Apóstolo. Todos os direitos reservados.</small>
                </div>
                <div class="col-md-6 text-md-end">
                    <small>Diocese de Umuarama - PR</small>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
