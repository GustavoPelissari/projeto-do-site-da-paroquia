@extends('layout')

@section('title', 'Verificação de E-mail')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="bi bi-envelope-check" style="font-size: 3rem; color: var(--brand-vinho);"></i>
                        </div>
                        <h1 class="h4 fw-bold text-vinho mb-2">Verifique seu E-mail</h1>
                        <p class="text-muted small">
                            Enviamos um código de 6 dígitos para seu e-mail. Digite-o abaixo para completar o registro.
                        </p>
                    </div>

                    @if (session('status'))
                        <x-alert type="success" class="mb-3">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('status') }}
                        </x-alert>
                    @endif

                    <div class="alert alert-info d-flex align-items-start mb-4" role="alert">
                        <i class="bi bi-info-circle me-2 mt-1"></i>
                        <div>
                            <strong>E-mail: {{ $email ?? 'não informado' }}</strong>
                            <p class="mb-0 small mt-1">Verifique sua caixa de spam se não receber o código.</p>
                        </div>
                    </div>

                    <!-- Formulário de verificação com código -->
                    <form method="POST" action="{{ route('verification.verify') }}">
                        @csrf

                        <!-- Email hidden field -->
                        <input type="hidden" name="email" value="{{ $email ?? '' }}">

                        <!-- Código de verificação -->
                        <div class="mb-3">
                            <label for="code" class="form-label">
                                <i class="bi bi-key"></i> Código de Verificação (6 dígitos)
                            </label>
                            <input 
                                id="code" 
                                type="text" 
                                class="form-control form-control-lg text-center @error('code') is-invalid @enderror" 
                                name="code" 
                                placeholder="000000"
                                maxlength="6"
                                inputmode="numeric"
                                pattern="[0-9]{6}"
                                required
                                autofocus
                            />
                            @error('code')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Verificar E-mail
                            </button>
                        </div>
                    </form>

                    <hr class="my-3">

                    <!-- Formulário de reenvio -->
                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email ?? '' }}">
                        <div class="text-center">
                            <p class="small text-muted mb-2">Não recebeu o código?</p>
                            <button type="submit" class="btn btn-sm btn-outline-secondary w-100">
                                <i class="bi bi-arrow-repeat me-1"></i>Reenviar Código
                            </button>
                        </div>
                    </form>

                    <hr class="my-3">

                    <!-- Voltar para login -->
                    <div class="text-center">
                        <p class="small">Já tem uma conta? <a href="{{ route('login') }}">Entre aqui</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
