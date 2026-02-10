<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Paróquia São Paulo Apóstolo') }}</title>
    <meta name="description" content="@yield('meta_description', 'Acesse a Paróquia São Paulo Apóstolo: notícias, eventos, missas e comunidade.')">
    <meta property="og:title" content="{{ config('app.name', 'Paróquia São Paulo Apóstolo') }}">
    <meta property="og:description" content="@yield('meta_description', 'Acesse a Paróquia São Paulo Apóstolo: notícias, eventos, missas e comunidade.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/sao-paulo-logo.png') }}">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ config('app.name', 'Paróquia São Paulo Apóstolo') }}">
    <meta name="twitter:description" content="@yield('meta_description', 'Acesse a Paróquia São Paulo Apóstolo: notícias, eventos, missas e comunidade.')">
    <meta name="twitter:image" content="{{ asset('images/sao-paulo-logo.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/sao-paulo-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/sao-paulo-logo.png') }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <a class="visually-hidden-focusable" href="#main-content">Ir para o conteúdo</a>
    <!-- Header com logo da Paróquia -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/sao-paulo-logo.png') }}" alt="São Paulo Apóstolo" class="me-2" style="height: 40px;">
                <div>
                    <div class="fw-bold text-brand-vinho">Paróquia São Paulo Apóstolo</div>
                    <small class="text-muted">Diocese de Umuarama</small>
                </div>
            </a>
        </div>
    </nav>

    <main id="main-content" tabindex="-1" class="min-vh-100 py-4">
        @yield('content')
    </main>
</body>
</html>
