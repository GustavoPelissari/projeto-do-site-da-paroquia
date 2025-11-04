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

<!-- Filtros de Categoria -->
<section class="py-4" style="background: var(--bege-claro);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex flex-wrap justify-content-center gap-2" id="category-filters">
                    <button class="btn-paroquia btn-outline-paroquia active" data-category="all">
                        <i data-lucide="grid-3x3" class="icon-paroquia"></i>
                        Todas
                    </button>
                    <button class="btn-paroquia btn-outline-paroquia" data-category="catequese">
                        <i data-lucide="graduation-cap" class="icon-paroquia"></i>
                        Catequese
                    </button>
                    <button class="btn-paroquia btn-outline-paroquia" data-category="liturgia">
                        <i data-lucide="church" class="icon-paroquia"></i>
                        Liturgia
                    </button>
                    <button class="btn-paroquia btn-outline-paroquia" data-category="caridade">
                        <i data-lucide="heart-handshake" class="icon-paroquia"></i>
                        Caridade
                    </button>
                    <button class="btn-paroquia btn-outline-paroquia" data-category="jovens">
                        <i data-lucide="zap" class="icon-paroquia"></i>
                        Jovens
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Groups Section -->
<section class="section-paroquia">
    <div class="container">
        @if($groups->count() > 0)
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h2 class="mb-4">Nossos Grupos Ativos</h2>
                    <p class="lead text-muted">
                        Cada grupo tem sua missão especial na construção do Reino de Deus. 
                        Encontre aquele que mais se alinha com seu carisma e chamado.
                    </p>
                </div>
            </div>
            
            <div class="row g-4" id="groups-container">
                @foreach($groups as $group)
                <div class="col-lg-4 col-md-6 group-card-item" 
                     data-category="{{ $group->category ?? 'geral' }}">
                    <div class="card-paroquia h-100 d-flex flex-column">
                        <div class="card-header-paroquia text-center">
                            <div class="mb-3">
                                @switch($group->category ?? 'geral')
                                    @case('catequese')
                                    @case('formation')
                                        <i data-lucide="graduation-cap" class="icon-lg text-vermelho"></i>
                                        @break
                                    @case('liturgia')
                                    @case('liturgy')
                                        <i data-lucide="church" class="icon-lg text-vermelho"></i>
                                        @break
                                    @case('caridade')
                                    @case('service')
                                        <i data-lucide="heart-handshake" class="icon-lg text-vermelho"></i>
                                        @break
                                    @case('jovens')
                                    @case('youth')
                                        <i data-lucide="zap" class="icon-lg text-vermelho"></i>
                                        @break
                                    @case('family')
                                        <i data-lucide="home" class="icon-lg text-vermelho"></i>
                                        @break
                                    @case('pastoral')
                                        <i data-lucide="users" class="icon-lg text-vermelho"></i>
                                        @break
                                    @default
                                        <i data-lucide="users" class="icon-lg text-vermelho"></i>
                                @endswitch
                            </div>
                            <h5 class="card-title-paroquia mb-2">{{ $group->name }}</h5>
                            <span class="badge rounded-pill bg-light text-dark">{{ $group->category_name ?? ($group->category ?? 'Geral') }}</span>
                        </div>
                        <div class="card-body-paroquia flex-grow-1">
                            <p class="text-muted mb-3">{{ \Illuminate\Support\Str::limit($group->description, 140) }}</p>
                            @if(!empty($group->meeting_info))
                                <div class="small text-muted d-flex align-items-center gap-2">
                                    <i data-lucide="calendar"></i>
                                    <span>{{ $group->meeting_info }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent border-0 mt-auto">
                            @auth
                                @if($group->isFull())
                                    <button class="btn-paroquia btn-secondary-paroquia w-100" disabled>
                                        <i data-lucide="user-x" class="icon-paroquia"></i>
                                        Grupo Completo
                                    </button>
                                @else
                                    <a href="{{ route('group-requests.create', ['group' => $group->id]) }}" 
                                       class="btn-paroquia btn-primary-paroquia w-100">
                                        <i data-lucide="user-plus" class="icon-paroquia"></i>
                                        Participar
                                    </a>
                                @endif
                            @endauth
                            @guest
                                <a href="{{ route('login') }}" 
                                   class="btn-paroquia btn-outline-paroquia w-100">
                                    <i data-lucide="log-in" class="icon-paroquia"></i>
                                    Entrar para Participar
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
<section class="section-paroquia section-bg-bege">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card-paroquia p-5">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-8">
                            <h3 class="mb-4">Como Participar de uma Pastoral?</h3>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 48px; height: 48px; background: var(--vermelho-profundo); color: white;">
                                            <span class="fw-bold">1</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Escolha uma Pastoral</h6>
                                            <small class="text-muted">Encontre a que mais combina com você</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 48px; height: 48px; background: var(--dourado-suave); color: white;">
                                            <span class="fw-bold">2</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Solicite Participação</h6>
                                            <small class="text-muted">Clique em \"Participar\" após fazer login</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 48px; height: 48px; background: var(--verde-agua); color: white;">
                                            <span class="fw-bold">3</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Aguarde Aprovação</h6>
                                            <small class="text-muted">O coordenador avaliará sua solicitação</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center">
                            @guest
                                <a href="{{ route('register') }}" class="btn-paroquia btn-primary-paroquia mb-3">
                                    <i data-lucide="user-plus" class="icon-paroquia"></i>
                                    Criar Conta
                                </a>
                                <br>
                                <a href="{{ route('login') }}" class="btn-paroquia btn-outline-paroquia">
                                    <i data-lucide="log-in" class="icon-paroquia"></i>
                                    Já tenho conta
                                </a>
                            @else
                                <div class="mb-3">
                                    <i data-lucide="check-circle" class="icon-lg text-verde"></i>
                                </div>
                                <h5 class="text-verde">Você já está logado!</h5>
                                <p class="text-muted mb-3">Agora você pode solicitar participação em qualquer pastoral.</p>
                                <a href="{{ route('dashboard') }}" class="btn-paroquia btn-outline-paroquia">
                                    <i data-lucide="layout-dashboard" class="icon-paroquia"></i>
                                    Meu Painel
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
    // Filtro de categorias
    const categoryFilters = document.querySelectorAll('[data-category]');
    const groupCards = document.querySelectorAll('.group-card-item');
    
    categoryFilters.forEach(filter => {
        filter.addEventListener('click', function() {
            const category = this.dataset.category;
            
            // Atualizar botões ativos
            categoryFilters.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filtrar cards
            groupCards.forEach(card => {
                const cardCategory = card.dataset.category;
                
                if (category === 'all' || cardCategory === category) {
                    card.style.display = 'block';
                    card.classList.add('animate-fade-in');
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
    
    // Inicializar Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>
@endpush
