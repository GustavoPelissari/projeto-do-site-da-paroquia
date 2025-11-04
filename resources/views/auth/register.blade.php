@extends('layout')

@section('title', 'Cadastrar - Paróquia São Paulo Apóstolo')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/sao-paulo-logo.png') }}" alt="São Paulo Apóstolo" class="mb-3" style="height: 60px;">
                        <h2 class="h4 text-brand-vinho mb-2">Cadastrar na Paróquia</h2>
                        <p class="text-muted">Junte-se à nossa comunidade de fé</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Nome -->
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="bi bi-person"></i> Nome Completo
                            </label>
                            <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Seu nome completo" />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope"></i> Email
                            </label>
                            <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="seu.email@exemplo.com" />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Senha -->
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock"></i> Senha
                            </label>
                            <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="new-password" placeholder="Crie uma senha segura" />
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirmar Senha -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">
                                <i class="bi bi-lock-fill"></i> Confirmar Senha
                            </label>
                            <input id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirme sua senha" />
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn-primary-paroquia">
                                <i class="bi bi-person-plus"></i> Cadastrar
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="mb-0">Já tem uma conta?
                                <a href="{{ route('login') }}" class="text-decoration-none">Faça login aqui</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
