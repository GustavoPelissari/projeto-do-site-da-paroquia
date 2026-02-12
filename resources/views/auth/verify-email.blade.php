@extends('layouts.guest')

@section('content')
<h2 class="text-center mb-4">Verificar email</h2>
<p class="text-muted text-center mb-4">
    Obrigado por se cadastrar! Antes de começar, você pode verificar seu endereço de email clicando no link que enviamos para você? Se você não recebeu o email, teremos prazer em enviar outro.
</p>

@if (session('status') == 'verification-link-sent')
    <div class="alert alert-success" role="alert">
        Um novo link de verificação foi enviado para o endereço de email fornecido durante o registro.
    </div>
@endif

<div class="mt-4 d-flex justify-content-between">
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Reenviar email de verificação</button>
    </form>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-link">Sair</button>
    </form>
</div>
@endsection