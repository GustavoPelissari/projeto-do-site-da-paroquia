@extends('layouts.public')

@section('title', 'Entrar - Paróquia São Paulo Apóstolo')
@section('description', 'Acesse sua conta da Paróquia São Paulo Apóstolo para acompanhar pastorais, escalas e atividades da comunidade.')

@section('content')
<section class="auth-page-section">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex justify-center">
            <div class="w-full max-w-2xl">
                <div class="auth-card">
                    <div class="auth-card-header text-center">
                        <h1 class="auth-title mb-2">Entrar na Paróquia</h1>
                        <p class="auth-subtitle mb-0">Acesse sua conta para participar da nossa comunidade.</p>
                    </div>

                    <div class="auth-card-body">
                        <x-auth-session-status class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}" class="auth-form" novalidate>
                            @csrf

                            <div>
                                <label for="email" class="auth-label block">Email</label>
                                <input
                                    id="email"
                                    class="auth-input w-full"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="seu.email@exemplo.com"
                                />
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                            </div>

                            <div>
                                <label for="password" class="auth-label block">Senha</label>
                                <input
                                    id="password"
                                    class="auth-input w-full"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Digite sua senha"
                                />
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                            </div>

                            <div class="auth-remember flex items-center gap-2">
                                <input id="remember_me" type="checkbox" class="h-4 w-4" name="remember">
                                <label for="remember_me">Lembrar de mim</label>
                            </div>

                            <button type="submit" class="btn-hero btn-hero-primary auth-submit-btn">
                                Entrar no Painel
                            </button>

                            <div class="auth-links text-center">
                                @if (Route::has('password.request'))
                                    <a class="auth-inline-link block" href="{{ route('password.request') }}">
                                        Esqueceu sua senha?
                                    </a>
                                @endif

                                @if (Route::has('register'))
                                    <div class="auth-register-block">
                                        <p class="mb-2">Ainda não é membro da nossa paróquia?</p>
                                        <a href="{{ route('register') }}" class="auth-register-btn inline-flex items-center rounded-lg border border-gray-400 px-4 py-2 text-gray-700 hover:bg-gray-100">
                                            Criar nova conta
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
