@extends('layouts.guest')

@section('title', 'Redefinição de Senha')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-shield-lock display-5" aria-hidden="true" style="color: var(--bs-primary);"></i>
                        <h1 class="h4 fw-bold text-vinho mt-2">Redefinição de Senha</h1>
                        <p class="text-muted small mb-0">Digite sua nova senha abaixo para concluir a redefinição.</p>
                    </div>

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nova Senha</label>
                            <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            @error('password_confirmation')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check2-circle me-2" aria-hidden="true"></i>Redefinir Senha
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mt-3">
        <a href="{{ route('login') }}" class="text-muted small"><i class="bi bi-box-arrow-in-right me-1" aria-hidden="true"></i>Voltar para Entrar</a>
    </div>
    
</div>
@endsection
