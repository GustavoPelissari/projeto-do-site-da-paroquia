@extends('layouts.app')

@section('title', 'Verificação de E-mail')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="bi bi-envelope-check" style="font-size: 3rem; color: var(--bs-primary);" aria-hidden="true"></i>
                        </div>
                        <h1 class="h4 fw-bold text-vinho mb-2">Verifique seu E-mail</h1>
                        <p class="text-muted small">
                            Para participar de grupos paroquiais, você precisa verificar seu endereço de e-mail.
                        </p>
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success mb-3">
                            <i class="bi bi-check-circle me-2" aria-hidden="true"></i>
                            Um novo link de verificação foi enviado para seu e-mail!
                        </div>
                    @endif

                    <div class="alert alert-info d-flex align-items-start mb-4" role="alert">
                        <i class="bi bi-info-circle me-2 mt-1" aria-hidden="true"></i>
                        <div>
                            <strong>E-mail: {{ Auth::user()->email }}</strong>
                            <p class="mb-0 small mt-1">Clique no link enviado para seu e-mail. Se não recebeu, verifique a caixa de spam ou solicite um novo envio abaixo.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-envelope me-2" aria-hidden="true"></i>Reenviar E-mail de Verificação
                            </button>
                        </div>
                    </form>

                    <hr class="my-3">

                    <div class="text-center">
                        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Voltar ao Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection