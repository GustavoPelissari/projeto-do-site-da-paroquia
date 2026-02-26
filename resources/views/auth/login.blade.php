@extends('layout')

@section('title', 'Entrar - Paróquia São Paulo Apóstolo')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/sao-paulo-logo.png') }}" alt="São Paulo Apóstolo" class="mb-3" style="height: 60px;" loading="lazy">
                        <h2 class="h4 text-brand-vinho mb-2">Entrar na Paróquia</h2>
                        <p class="text-muted">Acesse sua conta para participar da nossa comunidade</p>
                    </div>

                    @if (session('status'))
                        <x-alert type="success" class="mb-4">
                            {{ session('status') }}
                        </x-alert>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope"></i> Email
                            </label>
                            <input id="email" 
                                   class="form-control @error('email') is-invalid @enderror"
                                   type="email" 
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus 
                                   autocomplete="username" 
                                   placeholder="seu.email@exemplo.com" />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock"></i> Senha
                            </label>
                            <input id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   type="password"
                                   name="password"
                                   required 
                                   autocomplete="current-password"
                                   placeholder="Sua senha" />
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                <label for="remember_me" class="form-check-label">
                                    Lembrar de mim
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none" href="{{ route('password.request') }}">
                                    Esqueceu sua senha?
                                </a>
                            @endif
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn-primary-paroquia">
                                <i class="bi bi-box-arrow-in-right"></i> Entrar
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="mb-0">Não tem uma conta?
                                <a href="{{ route('register') }}" class="text-decoration-none">
                                    Cadastre-se aqui
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection