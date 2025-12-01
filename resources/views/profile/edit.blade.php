@extends('admin.layout')

@section('title', 'Meu Perfil')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">
                <i class="bi bi-person-circle"></i> Meu Perfil
            </h1>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-person"></i> Informações do Perfil
                    </h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-key"></i> Alterar Senha
                    </h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="card shadow-sm border-danger">
                <div class="card-header bg-white">
                    <h5 class="mb-0 text-danger">
                        <i class="bi bi-exclamation-triangle"></i> Excluir Conta
                    </h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    @if(Auth::user()->profile_photo_path)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" 
                             alt="{{ Auth::user()->name }}" 
                             class="rounded-circle mb-3" 
                             style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 150px; height: 150px;">
                            <span class="display-1 text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                    @endif
                    <h5>{{ Auth::user()->name }}</h5>
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                    <span class="badge bg-primary">
                        {{ match(Auth::user()->role->value) {
                            'admin_global' => 'Administrador Global',
                            'coordenador_de_pastoral' => 'Coordenador de Pastoral',
                            'administrativo' => 'Administrativo',
                            default => 'Usuário'
                        } }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
