<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - São Paulo Apóstolo</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Crimson+Text:ital,wght@0,400;0,600;1,400&family=Cormorant+Garamond:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- CSS Global -->
        <link href="{{ asset('css/global.css') }}" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="sp-auth-body">
        <div class="sp-auth-container">
            <!-- Background com padrão sagrado -->
            <div class="sp-auth-bg"></div>
            
            <!-- Container principal -->
            <div class="sp-auth-main">
                <!-- Logo e título -->
                <div class="sp-auth-header">
                    <a href="{{ route('home') }}" class="sp-auth-logo">
                        <img src="{{ asset('images/sao-paulo-logo.png') }}" 
                             alt="São Paulo Apóstolo"
                             class="sp-auth-logo-img">
                        <div class="sp-auth-logo-text">
                            <h1>São Paulo Apóstolo</h1>
                            <p>Comunidade de Fé</p>
                        </div>
                    </a>
                </div>

                <!-- Formulário -->
                <div class="sp-auth-form">
                    {{ $slot }}
                </div>
                
                <!-- Footer -->
                <div class="sp-auth-footer">
                    <p>"A paz de Cristo seja convosco sempre!"</p>
                </div>
            </div>
        </div>
        
        <style>
            .sp-auth-body {
                font-family: var(--font-primary);
                margin: 0;
                padding: 0;
                min-height: 100vh;
                background: var(--gradient-sacred);
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .sp-auth-container {
                position: relative;
                width: 100%;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: var(--space-4);
            }
            
            .sp-auth-bg {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: 
                    url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="cross" patternUnits="userSpaceOnUse" width="40" height="40"><path d="M20,5 L20,35 M5,20 L35,20" stroke="rgba(255,255,255,0.08)" stroke-width="1" fill="none"/></pattern></defs><rect width="100" height="100" fill="url(%23cross)"/></svg>'),
                    radial-gradient(circle at 30% 20%, rgba(212,175,55,0.1) 0%, transparent 50%),
                    radial-gradient(circle at 70% 80%, rgba(255,255,255,0.05) 0%, transparent 50%);
                opacity: 0.8;
                z-index: 1;
            }
            
            .sp-auth-main {
                position: relative;
                z-index: 2;
                background: var(--sp-white);
                border-radius: var(--radius-2xl);
                box-shadow: var(--shadow-2xl);
                padding: var(--space-8);
                width: 100%;
                max-width: 480px;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255,255,255,0.2);
            }
            
            .sp-auth-header {
                text-align: center;
                margin-bottom: var(--space-8);
            }
            
            .sp-auth-logo {
                display: inline-flex;
                align-items: center;
                gap: var(--space-4);
                text-decoration: none;
                color: var(--sp-red-800);
            }
            
            .sp-auth-logo-img {
                width: 60px;
                height: 60px;
                border-radius: var(--radius-full);
                border: 3px solid var(--sp-gold);
                padding: 4px;
                background: var(--sp-white);
            }
            
            .sp-auth-logo-text h1 {
                font-family: var(--font-decorative);
                font-size: var(--text-xl);
                font-weight: var(--font-bold);
                color: var(--sp-red);
                margin: 0;
                line-height: 1.2;
            }
            
            .sp-auth-logo-text p {
                font-size: var(--text-sm);
                color: var(--sp-gold-dark);
                margin: 0;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                font-weight: var(--font-medium);
            }
            
            .sp-auth-form {
                margin-bottom: var(--space-6);
            }
            
            .sp-auth-footer {
                text-align: center;
                padding-top: var(--space-4);
                border-top: 1px solid var(--sp-gray-200);
            }
            
            .sp-auth-footer p {
                color: var(--sp-teal);
                font-style: italic;
                font-size: var(--text-sm);
                margin: 0;
            }
            
            /* Responsividade */
            @media (max-width: 640px) {
                .sp-auth-container {
                    padding: var(--space-2);
                }
                
                .sp-auth-main {
                    padding: var(--space-6);
                }
                
                .sp-auth-logo {
                    flex-direction: column;
                    gap: var(--space-2);
                }
                
                .sp-auth-logo-text {
                    text-align: center;
                }
            }
        </style>
    </body>
</html>
