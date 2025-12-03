@extends('layout')

@section('title', 'Pastorais e Movimentos - Paróquia São Paulo Apóstolo')

@section('content')
<!-- Hero Section -->
<x-hero title="Pastorais e Movimentos" subtitle="Conheça nossos grupos paroquiais e encontre seu lugar na nossa comunidade de fé">
    <p class="mb-0" style="opacity: 0.9;">
        Seguindo o exemplo missionário de São Paulo Apóstolo, cada pastoral tem sua missão
        especial na construção do Reino de Deus.
    </p>
</x-hero>

<!-- Breadcrumbs -->
<div class="container mt-4">
    <x-breadcrumbs :items="[
        ['label' => 'Grupos e Pastorais', 'icon' => 'people']
    ]" />
</div>

<!-- Groups Section -->
<section class="section-paroquia section-bg-bege">
    <div class="container">
        @if($groups->count() > 0)
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h2 class="mb-3">Nossos Grupos Paroquiais</h2>
                    <p class="lead text-muted">
                        Cada grupo tem sua missão especial na construção do Reino de Deus. 
                        Encontre aquele que mais se alinha com seu carisma e chamado.
                    </p>
                </div>
            </div>
            
            <div class="row g-4">
                @foreach($groups as $group)
                <div class="col-lg-4 col-md-6">
                    <div class="card-paroquia h-100">
                        <div class="card-header-paroquia text-center">
                            <div class="mb-3">
                                @if($group->image)
                                    <img src="{{ asset('storage/' . $group->image) }}" 
                                         alt="{{ $group->name }}" 
                                         class="rounded-circle"
                                         style="width: 80px; height: 80px; object-fit: cover; border: 3px solid var(--accent-dourado);">
                                @else
                                    @switch($group->category ?? 'geral')
                                        @case('catequese')
                                        @case('formation')
                                            <i data-lucide="graduation-cap" class="icon-lg" style="width: 48px; height: 48px;"></i>
                                            @break
                                        @case('liturgia')
                                        @case('liturgy')
                                            <i data-lucide="church" class="icon-lg" style="width: 48px; height: 48px;"></i>
                                            @break
                                        @case('familia')
                                        @case('family')
                                            <i data-lucide="home" class="icon-lg" style="width: 48px; height: 48px;"></i>
                                            @break
                                        @case('juventude')
                                        @case('youth')
                                            <i data-lucide="zap" class="icon-lg" style="width: 48px; height: 48px;"></i>
                                            @break
                                        @default
                                            <i data-lucide="users" class="icon-lg" style="width: 48px; height: 48px;"></i>
                                    @endswitch
                                @endif
                            </div>
                            <h5 class="mb-2">{{ $group->name }}</h5>
                            <span class="badge bg-warning text-dark">{{ $group->category_name ?? ($group->category ?? 'Geral') }}</span>
                        </div>
                        <div class="card-body flex-grow-1">
                            <p class="text-muted mb-3">{{ \Illuminate\Support\Str::limit($group->description, 140) }}</p>
                            
                            @if($group->coordinator_name)
                                <div class="mb-2 small">
                                    <i data-lucide="user" class="icon-paroquia text-vinho"></i>
                                    <strong>Coordenador:</strong> {{ $group->coordinator_name }}
                                </div>
                            @endif
                            
                            @if($group->coordinator_phone)
                                <div class="mb-2 small">
                                    <i data-lucide="phone" class="icon-paroquia text-success"></i>
                                    <a href="tel:{{ $group->coordinator_phone }}" class="text-decoration-none">{{ $group->coordinator_phone }}</a>
                                </div>
                            @endif
                            
                            @if(!empty($group->meeting_info))
                                <div class="small text-muted d-flex align-items-start gap-2 mt-3 pt-3 border-top">
                                    <i data-lucide="calendar" class="icon-paroquia text-dourado"></i>
                                    <span>{{ $group->meeting_info }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent border-0 mt-auto p-3">
                            @auth
                                @if(Auth::user()->parish_group_id)
                                    @if(Auth::user()->parish_group_id === $group->id)
                                        <div class="alert mb-0 p-3" style="background-color: var(--bg-rose); border: 1px solid var(--dourado-suave); border-radius: 8px;">
                                            <div class="d-flex align-items-center">
                                                <i data-lucide="check-circle" class="me-2" style="color: var(--brand-vinho); width: 20px; height: 20px;"></i>
                                                <span class="fw-bold" style="color: var(--brand-vinho); font-size: 0.9rem;">Você é membro deste grupo!</span>
                                            </div>
                                        </div>
                                    @else
                                        <button class="btn btn-secondary w-100" disabled title="Você já participa de outro grupo">
                                            <i data-lucide="users" class="icon-paroquia"></i>
                                            Já está em um grupo
                                        </button>
                                    @endif
                                @elseif($group->isFull())
                                    <button class="btn btn-secondary w-100" disabled>
                                        <i data-lucide="user-x" class="icon-paroquia"></i>
                                        Grupo Completo
                                    </button>
                                @else
                                    <a href="{{ route('group-requests.create', ['group' => $group->id]) }}" 
                                       class="btn-paroquia btn-primary-paroquia w-100 d-flex align-items-center justify-content-center gap-2">
                                        <i data-lucide="user-plus" class="icon-paroquia"></i>
                                        <span>Solicitar Participação</span>
                                    </a>
                                @endif
                            @endauth
                            @guest
                                <a href="{{ route('login') }}" 
                                   class="btn-paroquia btn-primary-paroquia w-100 d-flex align-items-center justify-content-center gap-2">
                                    <i data-lucide="log-in" class="icon-paroquia"></i>
                                    <span>Entrar para Participar</span>
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
        @else
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card-paroquia text-center p-5">
                        <div class="mb-4">
                            <i data-lucide="users" class="icon-lg text-muted" style="width: 64px; height: 64px;"></i>
                        </div>
                        <h3 class="text-muted mb-3">Nenhum grupo encontrado</h3>
                        <p class="text-muted">
                            Ainda não temos grupos cadastrados, mas em breve teremos várias opções 
                            para você participar da nossa comunidade.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Como Participar -->
<section class="section-paroquia bg-white">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="mb-3">Como Participar?</h2>
                <p class="lead text-muted">É simples e rápido! Siga estes passos para fazer parte da nossa comunidade</p>
            </div>
        </div>
        
        <div class="row g-4 mb-5">
            <div class="col-lg-4 col-md-6">
                <div class="card-paroquia text-center p-4 h-100">
                    <div class="mb-3">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white bg-vinho" 
                             style="width: 70px; height: 70px; font-size: 2rem; font-weight: 700; box-shadow: 0 4px 15px rgba(139, 30, 63, 0.25);">
                            1
                        </div>
                    </div>
                    <div class="mb-3">
                        <i data-lucide="search" class="icon-lg text-vinho"></i>
                    </div>
                    <h4 class="text-vinho">Explore as Pastorais</h4>
                    <p class="text-muted">Navegue pelos grupos disponíveis e encontre aquele que mais se alinha com seu carisma e chamado espiritual.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card-paroquia text-center p-4 h-100">
                    <div class="mb-3">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white bg-vinho" 
                             style="width: 70px; height: 70px; font-size: 2rem; font-weight: 700; box-shadow: 0 4px 15px rgba(139, 30, 63, 0.25);">
                            2
                        </div>
                    </div>
                    <div class="mb-3">
                        <i data-lucide="user-plus" class="icon-lg text-vinho"></i>
                    </div>
                    <h4 class="text-vinho">Solicite Participação</h4>
                    <p class="text-muted">Após fazer login, clique em "Solicitar Participação" no grupo escolhido e preencha sua solicitação.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card-paroquia text-center p-4 h-100">
                    <div class="mb-3">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white bg-vinho" 
                             style="width: 70px; height: 70px; font-size: 2rem; font-weight: 700; box-shadow: 0 4px 15px rgba(139, 30, 63, 0.25);">
                            3
                        </div>
                    </div>
                    <div class="mb-3">
                        <i data-lucide="check-circle" class="icon-lg text-vinho"></i>
                    </div>
                    <h4 class="text-vinho">Aguarde a Aprovação</h4>
                    <p class="text-muted">O coordenador da pastoral avaliará sua solicitação e você receberá uma notificação com a resposta.</p>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card-paroquia p-4 bg-rose">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-8">
                            <h3 class="text-vinho mb-3">Pronto para começar?</h3>
                            <p class="mb-0 text-muted">
                                @guest
                                    Crie uma conta gratuita ou faça login para solicitar participação em qualquer pastoral.
                                @else
                                    Você já está logado! Agora pode solicitar participação em qualquer pastoral acima.
                                @endguest
                            </p>
                        </div>
                        <div class="col-lg-4 text-center">
                            @guest
                                <a href="{{ route('register') }}" class="btn-paroquia btn-primary-paroquia w-100 mb-2 d-flex align-items-center justify-content-center gap-2">
                                    <i data-lucide="user-plus" class="icon-paroquia"></i>
                                    <span>Criar Conta Grátis</span>
                                </a>
                                <a href="{{ route('login') }}" class="text-vinho text-decoration-none d-inline-flex align-items-center gap-2 mt-2" style="font-weight: 500;">
                                    <i data-lucide="log-in" class="icon-paroquia"></i>
                                    <span>Já tenho conta</span>
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="btn-paroquia btn-primary-paroquia w-100 d-flex align-items-center justify-content-center gap-2">
                                    <i data-lucide="layout-dashboard" class="icon-paroquia"></i>
                                    <span>Ir para Meu Painel</span>
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>
@endpush
