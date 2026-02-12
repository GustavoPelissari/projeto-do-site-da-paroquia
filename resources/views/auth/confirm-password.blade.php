@extends('layouts.guest')

@section('content')
<h2 class="text-center mb-4">Confirmar senha</h2>
<p class="text-muted text-center mb-4">
    Esta é uma área segura da aplicação. Por favor, confirme sua senha antes de continuar.
</p>

<form method="POST" action="{{ route('password.confirm') }}">
    @csrf
    <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Digite sua senha">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Confirmar</button>
    </div>
</form>
@endsection