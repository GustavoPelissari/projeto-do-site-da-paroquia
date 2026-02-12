@extends('layouts.guest')

@section('content')
<h2 class="text-center mb-4">Entrar na sua conta</h2>

<!-- Session Status -->
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="seu.email@exemplo.com">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Digite sua senha">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
        <label class="form-check-label" for="remember_me">Lembrar-me</label>
    </div>

    <button type="submit" class="btn btn-primary w-100">Entrar</button>

    <div class="d-flex justify-content-between mt-3 small">
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">Esqueceu sua senha?</a>
        @endif
        @if (Route::has('register'))
            <a href="{{ route('register') }}">Criar conta</a>
        @endif
    </div>
</form>
@endsection