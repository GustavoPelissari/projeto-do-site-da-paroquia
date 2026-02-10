@extends('layout')

@section('title', 'Esqueci minha senha - Paróquia São Paulo Apóstolo')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/sao-paulo-logo.png') }}" alt="São Paulo Apóstolo" class="mb-3" style="height: 60px;" loading="lazy">
                        <h2 class="h4 text-brand-vinho mb-2">Esqueci minha senha</h2>
                        <p class="text-muted">Digite seu email para receber um link de recuperação</p>
                    </div>

                    <div class="mb-4">
                        <x-alert type="info">
                            <i class="bi bi-info-circle"></i> 
                            Esqueceu sua senha? Sem problemas. Digite seu email e enviaremos um link para redefinir sua senha.
                        </x-alert>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <x-alert type="success" class="mb-4">
                            <i class="bi bi-check-circle"></i> {{ session('status') }}
                        </x-alert>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
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
                                   placeholder="seu.email@exemplo.com" />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn-primary-paroquia">
                                <i class="bi bi-envelope-arrow-up"></i> Enviar Link de Recuperação
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="mb-0">Lembrou da senha? 
                                <a href="{{ route('login') }}" class="text-decoration-none">
                                    Entre aqui
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
