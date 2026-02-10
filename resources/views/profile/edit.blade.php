@extends('admin.layout')

@section('title', 'Meu Perfil')

@section('content')
<!-- Hero Section -->
<header class="hero-paroquia" style="min-height: 300px;">
    <div class="hero-content">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-10">
                    <h1 class="display-4 fw-bold mb-4">Meu Perfil</h1>
                    <p class="lead mb-4">Gerencie suas informações pessoais e configurações de segurança</p>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container py-4">
    <div class="row g-4">
        <!-- Conteúdo Principal -->
        <div class="col-lg-8">
            <!-- Informações do Perfil -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <strong><i class="bi bi-person-fill me-2" aria-hidden="true"></i>Informações do Perfil</strong>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Segurança -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <strong><i class="bi bi-shield-lock-fill me-2" aria-hidden="true"></i>Segurança da Conta</strong>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Zona de Perigo -->
            <div class="card shadow-sm border-danger mb-4">
                <div class="card-header bg-white text-danger">
                    <strong><i class="bi bi-exclamation-triangle-fill me-2" aria-hidden="true"></i>Zona de Perigo</strong>
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center p-4">
                    @if(Auth::user()->profile_photo_path)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" 
                             alt="{{ Auth::user()->name }}" 
                             class="rounded-circle mb-3" 
                             style="width: 120px; height: 120px; object-fit: cover; border: 3px solid var(--brand-vinho);">
                    @else
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 120px; height: 120px; background: var(--brand-vinho);">
                            <span class="display-3 text-white fw-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                    @endif
                    
                    <h5 class="mb-1 fw-bold">{{ Auth::user()->name }}</h5>
                    <p class="text-muted small mb-3">{{ Auth::user()->email }}</p>
                    
                    <span class="badge bg-vinho px-3 py-2 mb-3">
                        <i class="bi bi-shield-check me-1" aria-hidden="true"></i>
                        {{ match(Auth::user()->role->value) {
                            'admin_global' => 'Admin Global',
                            'coordenador_de_pastoral' => 'Coordenador',
                            'administrativo' => 'Administrativo',
                            default => 'Usuário'
                        } }}
                    </span>

                    <hr class="my-3">
                    
                    <div class="text-start">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted small">Status do E-mail</span>
                            @if(Auth::user()->hasVerifiedEmail())
                                <span class="badge bg-success"><i class="bi bi-check-circle-fill" aria-hidden="true"></i> Verificado</span>
                            @else
                                <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-circle-fill" aria-hidden="true"></i> Não Verificado</span>
                            @endif
                        </div>
                        
                        <div class="d-flex align-items-start mb-2">
                            <i class="bi bi-calendar-event text-brand-vinho me-2 mt-1" aria-hidden="true"></i>
                            <div class="small">
                                <div class="text-muted">Membro desde</div>
                                <div class="fw-semibold">{{ Auth::user()->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start">
                            <i class="bi bi-clock text-brand-vinho me-2 mt-1" aria-hidden="true"></i>
                            <div class="small">
                                <div class="text-muted">Último acesso</div>
                                <div class="fw-semibold">{{ Auth::user()->updated_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
