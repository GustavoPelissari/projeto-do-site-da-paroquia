<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Paróquia São Paulo Apóstolo') }}</title>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Vite compiled CSS & JS (Bootstrap included) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-light">
        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (View::hasSection('header'))
            <header class="bg-white border-bottom shadow-sm py-3">
                <div class="container">
                    @yield('header')
                </div>
            </header>
        @elseif(isset($header))
            <header class="bg-white border-bottom shadow-sm py-3">
                <div class="container">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="py-4">
            <div class="container">
                @if (View::hasSection('content'))
                    @yield('content')
                @else
                    {{ $slot }}
                @endif
            </div>
        </main>
    </body>
</html>