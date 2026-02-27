<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Paróquia São Paulo Apóstolo - Umuarama PR')</title>
    <meta name="description" content="@yield('description', 'Paróquia São Paulo Apóstolo em Umuarama - PR. Uma comunidade de fé, esperança e caridade, inspirada no exemplo do Apóstolo dos Gentios.')">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <nav class="sp-topbar fixed inset-x-0 top-0 z-50 border-b border-[rgba(139,21,56,0.12)] bg-white/95 backdrop-blur">
        <div class="sp-page-container flex items-center gap-4 py-3">
            <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3 no-underline">
                <img src="{{ asset('images/sao-paulo-logo.png') }}" alt="Logo São Paulo Apóstolo" class="logo-paroquia">
                <div class="brand-text min-w-0">
                    <span class="brand-titulo">Paróquia São Paulo Apóstolo</span>
                    <small class="brand-subtitulo block">Diocese de Morama</small>
                </div>
            </a>

            <button id="mobile-menu-toggle" type="button" class="inline-flex items-center justify-center rounded-md border border-[var(--sp-vermelho-manto)] p-2 text-[var(--sp-vermelho-manto)] lg:hidden" aria-controls="navbarNav" aria-expanded="false" aria-label="Abrir menu">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <div id="navbarNav" class="hidden w-full flex-col gap-4 lg:ml-6 lg:flex lg:w-auto lg:flex-row lg:items-center">
                <ul class="flex flex-col gap-2 lg:flex-row lg:items-center lg:gap-1">
                    <li><a class="sp-nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}"><i data-lucide="house" class="sp-nav-icon" aria-hidden="true"></i><span>Início</span></a></li>
                    <li><a class="sp-nav-link {{ request()->routeIs('masses') ? 'active' : '' }}" href="{{ route('masses') }}"><i data-lucide="clock-3" class="sp-nav-icon" aria-hidden="true"></i><span>Horários de Missa</span></a></li>
                    <li><a class="sp-nav-link {{ request()->routeIs('groups') ? 'active' : '' }}" href="{{ route('groups') }}"><i data-lucide="users" class="sp-nav-icon" aria-hidden="true"></i><span>Pastorais</span></a></li>
                    <li><a class="sp-nav-link {{ request()->routeIs('events') ? 'active' : '' }}" href="{{ route('events') }}"><i data-lucide="calendar-days" class="sp-nav-icon" aria-hidden="true"></i><span>Eventos</span></a></li>
                    <li><a class="sp-nav-link {{ request()->routeIs('news') ? 'active' : '' }}" href="{{ route('news') }}"><i data-lucide="newspaper" class="sp-nav-icon" aria-hidden="true"></i><span>Notícias</span></a></li>
                    <li><a class="sp-nav-link" href="#contato"><i data-lucide="mail" class="sp-nav-icon" aria-hidden="true"></i><span>Contato</span></a></li>
                </ul>

                <div class="flex flex-col gap-2 lg:ml-4 lg:flex-row">
                    <a href="#doacoes" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[var(--sp-gold)] px-4 py-2 font-semibold text-[var(--sp-red-900)] transition hover:brightness-95">
                        <i data-lucide="heart" class="sp-nav-icon" aria-hidden="true"></i><span>Apoiar a Paróquia</span>
                    </a>
                    @auth
                        <a href="{{ \App\Helpers\DashboardHelper::getDashboardRoute(auth()->user()->role) }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[var(--sp-vermelho-manto)] px-4 py-2 font-semibold text-white transition hover:bg-[var(--sp-vermelho-bordô)]">
                            <i data-lucide="shield-check" class="sp-nav-icon" aria-hidden="true"></i><span>Admin</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-[var(--sp-vermelho-manto)] px-4 py-2 font-semibold text-[var(--sp-vermelho-manto)] transition hover:bg-[var(--sp-vermelho-manto)] hover:text-white">
                            <i data-lucide="lock" class="sp-nav-icon" aria-hidden="true"></i><span>Painel</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="mt-16 bg-[var(--sp-vermelho-manto)] text-white" id="contato">
        <div class="sp-page-container py-12">
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                <div>
                    <div class="mb-3 flex items-center gap-3">
                        <img src="{{ asset('images/sao-paulo-logo.png') }}" alt="Logo São Paulo Apóstolo" class="logo-footer">
                        <div>
                            <h5 class="mb-0 text-lg font-semibold text-white">Paróquia São Paulo Apóstolo</h5>
                            <small class="text-white/80">Diocese de Umuarama - PR</small>
                        </div>
                    </div>
                    <p class="mb-3 text-white/90">Uma comunidade de fé, esperança e caridade, inspirada no exemplo do Apóstolo dos Gentios.</p>
                    <div class="flex gap-4 text-xl">
                        <a href="#" class="text-white/90 hover:text-white" title="Facebook da Paróquia" aria-label="Facebook"><i data-lucide="facebook" class="sp-footer-icon" aria-hidden="true"></i></a>
                        <a href="#" class="text-white/90 hover:text-white" title="Instagram da Paróquia" aria-label="Instagram"><i data-lucide="instagram" class="sp-footer-icon" aria-hidden="true"></i></a>
                        <a href="#" class="text-white/90 hover:text-white" title="Canal do YouTube" aria-label="YouTube"><i data-lucide="youtube" class="sp-footer-icon" aria-hidden="true"></i></a>
                    </div>
                </div>

                <div>
                    <h6 class="mb-3 text-base font-semibold text-white">Navegação</h6>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-white/90 hover:text-white">Início</a></li>
                        <li><a href="{{ route('masses') }}" class="text-white/90 hover:text-white">Horários</a></li>
                        <li><a href="{{ route('groups') }}" class="text-white/90 hover:text-white">Pastorais</a></li>
                        <li><a href="{{ route('events') }}" class="text-white/90 hover:text-white">Eventos</a></li>
                    </ul>
                </div>

                <div>
                    <h6 class="mb-3 text-base font-semibold text-white">Contato</h6>
                    <div class="space-y-2 text-white/90">
                        <div class="flex items-start gap-2"><i data-lucide="map-pin" class="sp-footer-icon mt-0.5 shrink-0" aria-hidden="true"></i><span>Av. General Mascarenhas de Morais, 4969<br>Umuarama - PR</span></div>
                        <div class="flex items-center gap-2"><i data-lucide="phone" class="sp-footer-icon shrink-0" aria-hidden="true"></i><a href="tel:+5544305540464" class="text-white/90 hover:text-white">(44) 3055-4464</a></div>
                        <div class="flex items-center gap-2"><i data-lucide="mail" class="sp-footer-icon shrink-0" aria-hidden="true"></i><a href="mailto:secretaria.pspaulo@hotmail.com" class="text-white/90 hover:text-white">secretaria.pspaulo@hotmail.com</a></div>
                    </div>
                </div>

                <div>
                    <h6 class="mb-3 text-base font-semibold text-white">Horários de Missa</h6>
                    <div class="space-y-1 text-white/90">
                        <div><strong>Domingo:</strong> 09:30 e 18:00</div>
                        <div><strong>Quarta:</strong> 20:00</div>
                        <div><strong>Sábado:</strong> 19:30</div>
                    </div>
                </div>
            </div>

            <hr class="my-8 border-white/30">

            <div class="flex flex-col gap-2 text-sm text-white/90 md:flex-row md:items-center md:justify-between">
                <small>© 2025 Paróquia São Paulo Apóstolo. Todos os direitos reservados.</small>
                <small>Diocese de Umuarama - PR</small>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>

    @stack('scripts')
</body>
</html>
