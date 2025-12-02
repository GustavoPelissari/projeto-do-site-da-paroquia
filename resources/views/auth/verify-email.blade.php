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
                            <i class="bi bi-envelope-check" style="font-size: 3rem; color: var(--bs-primary);"></i>
                        </div>
                        <h1 class="h4 fw-bold text-vinho mb-2">Verifique seu E-mail</h1>
                        <p class="text-muted small">
                            Obrigado por se cadastrar! Antes de começar, você poderia verificar seu endereço de e-mail clicando no link que acabamos de enviar para você?
                        </p>
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <x-alert type="success" class="mb-3">
                            <i class="bi bi-check-circle me-2"></i>
                            Um novo link de verificação foi enviado para o endereço de e-mail que você forneceu durante o registro.
                        </x-alert>
                    @endif

                    <div class="alert alert-info d-flex align-items-start mb-4" role="alert">
                        <i class="bi bi-info-circle me-2 mt-1"></i>
                        <div>
                            <strong>Não recebeu o e-mail?</strong>
                            <p class="mb-0 small mt-1">Verifique sua caixa de spam ou solicite um novo link abaixo.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-envelope me-2"></i>Reenviar E-mail de Verificação
                            </button>
                        </div>
                    </form>

                    <hr class="my-3">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-box-arrow-left me-1"></i>Sair
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection