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
                <div class="col-lg-4 col-md-6 group-card-item animate-on-scroll" 
                     data-category="{{ $group->category ?? 'geral' }}">
                    <div class="card-paroquia h-100">
                        <div class="card-header-paroquia text-center">
                            <div class="mb-3">
                                @switch($group->category ?? 'geral')
                                    @case('catequese')
                                        <i data-lucide="graduation-cap" class="icon-lg text-vermelho"></i>
                                        @break
                                    @case('liturgia')
                                        <i data-lucide="church" class="icon-lg text-vermelho"></i>
                                        @break
                                    @case('caridade')
                                        <i data-lucide="heart-handshake" class="icon-lg text-vermelho"></i>
                                        @break
                                    @case('jovens')
                                        <i data-lucide="zap" class="icon-lg text-vermelho"></i>
                                        @break
                                    @default
                                        <i data-lucide="users" class="icon-lg text-vermelho"></i>
                                @endswitch

                                <!-- Hero Section -->
                                ...existing code...
                                <!-- Call to Action Section -->
                                <section ...> ... </section>
                                <!-- Information Section -->
                                <section ...> ... </section>
                                <!-- Contact Section -->
                                <section ...> ... </section>
                                ...existing code...
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
                                            <small class="text-muted">Clique em "Participar" após fazer login</small>
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

<!-- Call to Action Section -->
<section style="background: var(--gradient-sacred); padding: var(--space-3xl) 0;">
    <div class="sp-container sp-text-center" style="color: var(--sp-white);">
        <h2 style="color: var(--sp-white); margin-bottom: var(--space-lg); font-size: var(--text-3xl);">Quer Fazer Parte?</h2>
        <p style="color: var(--sp-gold-light); font-size: var(--text-xl); margin-bottom: var(--space-2xl); max-width: 600px; margin-left: auto; margin-right: auto;">
            Junte-se à nossa comunidade paroquial! Como São Paulo nos ensinou, cada um tem seus dons únicos 
            para servir no Corpo de Cristo.
        </p>
        
        <div class="sp-flex sp-flex-center" style="gap: var(--space-lg); flex-wrap: wrap;">
            @guest
                <a href="{{ route('register') }}" class="sp-btn sp-btn-gold sp-btn-lg">
                    🚀 Cadastre-se na Paróquia
                </a>
                <a href="{{ route('login') }}" class="sp-btn sp-btn-outline sp-btn-lg" style="border-color: var(--sp-white); color: var(--sp-white);">
                    🔑 Já sou Cadastrado
                </a>
            @else
                <a href="{{ route('group-requests.create') }}" class="sp-btn sp-btn-gold sp-btn-lg">
                    <i class="bi bi-person-raised-hand"></i> Solicitar Participação
                </a>
                <a href="{{ route('group-requests.my-requests') }}" class="sp-btn sp-btn-outline sp-btn-lg" style="border-color: var(--sp-white); color: var(--sp-white);">
                    <i class="bi bi-list-check"></i> Minhas Solicitações
                </a>
            @endguest
        </div>
    </div>
</section>

<!-- Information Section -->
<section style="background: var(--sp-white); padding: var(--space-3xl) 0;">
    <div class="sp-container">
        <div class="sp-grid sp-grid-2" style="align-items: center; gap: var(--space-2xl);">
            <div>
                <h3 class="sp-text-red" style="margin-bottom: var(--space-lg); font-size: var(--text-2xl);">Como Participar</h3>
                <div style="margin-bottom: var(--space-lg);">
                    <h4 class="sp-text-teal" style="margin-bottom: var(--space-sm); font-size: var(--text-lg);">1. Cadastre-se no Sistema</h4>
                    <p class="sp-text-muted">
                        Faça seu cadastro em nosso sistema paroquial com seus dados pessoais.
                    </p>
                </div>
                
                <div style="margin-bottom: var(--space-lg);">
                    <h4 class="sp-text-teal" style="margin-bottom: var(--space-sm); font-size: var(--text-lg);">2. Escolha seu Grupo</h4>
                    <p class="sp-text-muted">
                        Conheça nossos grupos e pastorais para encontrar aquele que mais se alinha com seu carisma.
                    </p>
                </div>
                
                <div style="margin-bottom: var(--space-lg);">
                    <h4 class="sp-text-teal" style="margin-bottom: var(--space-sm); font-size: var(--text-lg);">3. Solicite Participação</h4>
                    <p class="sp-text-muted">
                        Envie sua solicitação através do sistema e aguarde o contato do coordenador do grupo.
                    </p>
                </div>
                
                <div>
                    <h4 class="sp-text-teal" style="margin-bottom: var(--space-sm); font-size: var(--text-lg);">4. Participe e Sirva</h4>
                    <p class="sp-text-muted">
                        Integre-se às atividades do grupo e contribua com seus dons para a missão evangelizadora.
                    </p>
                </div>
            </div>
            
            <div class="sp-text-center">
                <div style="width: 180px; height: 180px; background: var(--gradient-gold); border-radius: 50%; margin: 0 auto var(--space-lg); display: flex; align-items: center; justify-content: center; font-size: 3rem; color: var(--sp-white); box-shadow: var(--shadow-gold);">
                    ⛪
                </div>
                <blockquote class="sp-quote-sacred">
                    "Há diversidade de carismas, mas o Espírito é o mesmo"<br>
                    <cite style="font-size: var(--text-sm); color: var(--sp-gray-500);">1 Coríntios 12:4</cite>
                </blockquote>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section style="background: var(--sp-ivory); padding: var(--space-3xl) 0;">
    <div class="sp-container">
        <h2 class="sp-text-center sp-text-red" style="margin-bottom: var(--space-lg); font-size: var(--text-3xl);">Dúvidas sobre os Grupos?</h2>
        <p class="sp-text-center sp-text-muted" style="max-width: 600px; margin: 0 auto var(--space-2xl);">
            Nossa equipe pastoral está pronta para ajudar você a encontrar o grupo ideal para sua caminhada de fé.
        </p>
        
        <div class="sp-grid sp-grid-responsive" style="gap: var(--space-xl);">
            <div class="sp-card sp-text-center">
                <div style="font-size: 3rem; margin-bottom: var(--space-md);">📧</div>
                <h3 class="sp-card-title">Email dos Grupos</h3>
                <p class="sp-card-content">
                    <a href="mailto:grupos@saopauloapostolo.com" class="sp-link" style="color: var(--sp-red);">
                        grupos@saopauloapostolo.com
                    </a>
                </p>
            </div>
            
            <div class="sp-card sp-text-center">
                <div style="font-size: 3rem; margin-bottom: var(--space-md);">📱</div>
                <h3 class="sp-card-title">WhatsApp</h3>
                <p class="sp-card-content">
                    <a href="https://wa.me/5511999999999" class="sp-link" style="color: var(--sp-red);">
                        (11) 99999-9999
                    </a>
                </p>
            </div>
            
            <div class="sp-card sp-text-center">
                <div style="font-size: 3rem; margin-bottom: var(--space-md);">⏰</div>
                <h3 class="sp-card-title">Horário de Atendimento</h3>
                <p class="sp-card-content">
                    Segunda a Sexta<br>
                    8h às 17h<br>
                    Sábado: 8h às 12h
                </p>
            </div>
        </div>
        
        <div class="sp-text-center" style="margin-top: var(--space-2xl);">
            <p class="sp-text-teal" style="font-style: italic; font-size: var(--text-lg);">
                "Cada um ponha a serviço dos outros o carisma que recebeu" - 1 Pedro 4:10
            </p>
        </div>
    </div>
</section>

@endsection