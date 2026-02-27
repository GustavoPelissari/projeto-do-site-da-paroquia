@extends('layouts.public')

@section('title', 'Entrar - Paróquia São Paulo Apóstolo')
@section('description', 'Acesse sua conta da Paróquia São Paulo Apóstolo para acompanhar pastorais, escalas e atividades da comunidade.')

@section('content')
<section class="auth-page-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-7 col-xl-5">
                <div class="auth-card">
                    <div class="auth-card-header text-center">
                        <h1 class="auth-title mb-2">Entrar na Paróquia</h1>
                        <p class="auth-subtitle mb-0">Acesse sua conta para participar da nossa comunidade.</p>
                    </div>

                    <div class="auth-card-body">
                        <x-auth-session-status class="alert alert-success" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}" class="auth-form" novalidate>
                            @csrf

                            <div>
                                <label for="email" class="form-label auth-label">Email</label>
                                <input
                                    id="email"
                                    class="form-control auth-input"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="seu.email@exemplo.com"
                                />
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
                            </div>

                            <div>
                                <label for="password" class="form-label auth-label">Senha</label>
                                <input
                                    id="password"
                                    class="form-control auth-input"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Digite sua senha"
                                />
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
                            </div>

                            <div class="form-check auth-remember">
                                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                <label for="remember_me" class="form-check-label">Lembrar de mim</label>
                            </div>

                            <button type="submit" class="btn-hero btn-hero-primary auth-submit-btn">
                                Entrar no Painel
                            </button>

                            <div class="auth-links text-center">
                                @if (Route::has('password.request'))
                                    <a class="auth-inline-link d-block" href="{{ route('password.request') }}">
                                        Esqueceu sua senha?
                                    </a>
                                @endif

                                @if (Route::has('register'))
                                    <div class="auth-register-block">
                                        <p class="mb-2">Ainda não é membro da nossa paróquia?</p>
                                        <a href="{{ route('register') }}" class="btn btn-outline-secondary auth-register-btn">
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
