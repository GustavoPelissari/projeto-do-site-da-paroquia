@extends('layouts.guest')

@section('content')
<h2 class="text-center mb-4">Recuperar senha</h2>
<p class="text-muted text-center mb-4">
    Esqueceu sua senha? Sem problemas. Informe seu email e enviaremos um link para redefinir sua senha.
</p>

<!-- Session Status -->
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="seu.email@exemplo.com">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary w-100">Enviar link de recuperação</button>
    <p class="text-center mt-3 small">
        <a href="{{ route('login') }}">Voltar para o login</a>
    </p>
</form>
@endsection