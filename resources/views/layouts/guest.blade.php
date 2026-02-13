<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - São Paulo Apóstolo</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])
</head>

<body class="auth-body d-flex align-items-center justify-content-center">
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">
                <div class="card auth-card">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <x-parish-logo class="auth-logo mb-2" alt="São Paulo Apóstolo" />
                            <h1 class="h4 mb-1 auth-title">São Paulo Apóstolo</h1>
                            <p class="mb-0 text-muted small">Comunidade de Fé</p>
                        </div>

                        @if(isset($slot))
                            {{ $slot }}
                        @else
                            @yield('content')
                        @endif

                        <p class="text-center mt-4 mb-0 text-muted fst-italic">
                            "A paz de Cristo seja convosco sempre!"
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @vite(['resources/js/app.js'])
</body>
</html>
