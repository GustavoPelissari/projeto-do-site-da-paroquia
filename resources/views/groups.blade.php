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
<section class="py-5" style="background: var(--vermelho-profundo); position: relative; overflow: hidden;">
    <!-- Padrão decorativo de fundo -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.1; background-image: radial-gradient(circle, rgba(255,255,255,0.3) 1px, transparent 1px); background-size: 30px 30px;"></div>
    
    <div class="container" style="position: relative; z-index: 1;">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-6 text-center">
                <h3 class="mb-2" style="color: white; font-weight: 700;">Explore por Categoria</h3>
                <p style="color: rgba(255,255,255,0.9);">Encontre a pastoral que combina com seu chamado</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex flex-wrap justify-content-center gap-3" id="category-filters">
                    <button class="category-filter-btn active" data-category="all">
                        <div class="category-icon">
                            <i data-lucide="grid-3x3"></i>
                        </div>
                        <span>Todas</span>
                        <div class="category-count" id="count-all">0</div>
                    </button>
                    <button class="category-filter-btn" data-category="catequese">
                        <div class="category-icon">
                            <i data-lucide="graduation-cap"></i>
                        </div>
                        <span>Formação</span>
                        <div class="category-count" id="count-catequese">0</div>
                    </button>
                    <button class="category-filter-btn" data-category="liturgia">
                        <div class="category-icon">
                            <i data-lucide="church"></i>
                        </div>
                        <span>Liturgia</span>
                        <div class="category-count" id="count-liturgia">0</div>
                    </button>
                    <button class="category-filter-btn" data-category="familia">
                        <div class="category-icon">
                            <i data-lucide="home"></i>
                        </div>
                        <span>Família</span>
                        <div class="category-count" id="count-familia">0</div>
                    </button>
                    <button class="category-filter-btn" data-category="juventude">
                        <div class="category-icon">
                            <i data-lucide="zap"></i>
                        </div>
                        <span>Juventude</span>
                        <div class="category-count" id="count-juventude">0</div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.category-filter-btn {
    position: relative;
    background: white;
    border: 3px solid rgba(255,255,255,0.3);
    border-radius: 16px;
    padding: 20px 28px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    min-width: 140px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
}

.category-filter-btn:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.3);
    border-color: var(--dourado-suave);
}

.category-filter-btn.active {
    background: var(--dourado-suave);
    border-color: var(--dourado-suave);
    color: var(--vermelho-profundo);
    transform: translateY(-6px);
    box-shadow: 0 12px 40px rgba(212, 175, 55, 0.5);
}

.category-icon {
    width: 48px;
    height: 48px;
    background: var(--bege-claro);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.category-filter-btn:hover .category-icon {
    background: var(--dourado-suave);
    transform: scale(1.1);
}

.category-filter-btn.active .category-icon {
    background: var(--vermelho-profundo);
}

.category-icon i {
    width: 24px;
    height: 24px;
    color: var(--vermelho-profundo);
}

.category-filter-btn.active .category-icon i {
    color: white;
}

.category-filter-btn span {
    font-weight: 600;
    font-size: 14px;
}

.category-count {
    position: absolute;
    top: -12px;
    right: -12px;
    background: var(--vermelho-profundo);
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 700;
    border: 4px solid white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.category-filter-btn.active .category-count {
    background: white;
    color: var(--vermelho-profundo);
    border-color: var(--dourado-suave);
}
</style>

<!-- Groups Section -->
<section class="section-paroquia" style="background: var(--bege-claro); padding: 80px 0;">
    <div class="container">
        @if($groups->count() > 0)
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <div style="display: inline-block; background: var(--vermelho-profundo); color: white; padding: 8px 20px; border-radius: 50px; font-size: 14px; font-weight: 600; margin-bottom: 20px;">
                        <i data-lucide="sparkles" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle;"></i>
                        Comunidade Ativa
                    </div>
                    <h2 class="mb-4" style="color: var(--vermelho-profundo); font-weight: 700;">Nossos Grupos Paroquiais</h2>
                    <p class="lead" style="color: #555;">
                        Cada grupo tem sua missão especial na construção do Reino de Deus. 
                        Encontre aquele que mais se alinha com seu carisma e chamado.
                    </p>
                </div>
            </div>
            
            <div class="row g-4" id="groups-container">
                @foreach($groups as $group)
                <div class="col-lg-4 col-md-6 group-card-item" 
                     data-category="{{ $group->category ?? 'geral' }}"
                     style="animation: fadeInUp 0.5s ease-out {{ $loop->index * 0.1 }}s both;">
                    <div class="modern-group-card h-100">
                        <div class="group-card-header">
                            @if($group->image)
                                <div class="group-card-image">
                                    <img src="{{ asset('storage/' . $group->image) }}" alt="{{ $group->name }}">
                                    <div class="group-card-overlay"></div>
                                </div>
                            @else
                                <div class="group-card-icon-bg">
                                    @switch($group->category ?? 'geral')
                                        @case('catequese')
                                        @case('formation')
                                            <i data-lucide="graduation-cap"></i>
                                            @break
                                        @case('liturgia')
                                        @case('liturgy')
                                            <i data-lucide="church"></i>
                                            @break
                                        @case('familia')
                                        @case('family')
                                            <i data-lucide="home"></i>
                                            @break
                                        @case('juventude')
                                        @case('youth')
                                            <i data-lucide="zap"></i>
                                            @break
                                        @default
                                            <i data-lucide="users"></i>
                                    @endswitch
                                </div>
                            @endif
                            <div class="group-card-badge">
                                <i data-lucide="bookmark" style="width: 14px; height: 14px;"></i>
                                {{ $group->category_name ?? ($group->category ?? 'Geral') }}
                            </div>
                        </div>
                        
                        <div class="group-card-body">
                            <h5 class="group-card-title">{{ $group->name }}</h5>
                            <p class="group-card-description">{{ \Illuminate\Support\Str::limit($group->description, 120) }}</p>
                            
                            <div class="group-card-info">
                                @if($group->coordinator_name)
                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i data-lucide="user"></i>
                                        </div>
                                        <div class="info-content">
                                            <small class="text-muted d-block">Coordenador</small>
                                            <strong>{{ $group->coordinator_name }}</strong>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($group->coordinator_phone)
                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i data-lucide="phone"></i>
                                        </div>
                                        <div class="info-content">
                                            <small class="text-muted d-block">Contato</small>
                                            <a href="tel:{{ $group->coordinator_phone }}" class="text-decoration-none fw-semibold">{{ $group->coordinator_phone }}</a>
                                        </div>
                                    </div>
                                @endif
                                
                                @if(!empty($group->meeting_info))
                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i data-lucide="calendar"></i>
                                        </div>
                                        <div class="info-content">
                                            <small class="text-muted d-block">Encontros</small>
                                            <strong>{{ $group->meeting_info }}</strong>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="group-card-footer">
                            @auth
                                @if($group->isFull())
                                    <button class="btn-group-action disabled" disabled>
                                        <i data-lucide="user-x"></i>
                                        <span>Grupo Completo</span>
                                    </button>
                                @else
                                    <a href="{{ route('group-requests.create', ['group' => $group->id]) }}" 
                                       class="btn-group-action primary">
                                        <i data-lucide="user-plus"></i>
                                        <span>Solicitar Participação</span>
                                    </a>
                                @endif
                            @endauth
                            @guest
                                <a href="{{ route('login') }}" class="btn-group-action outline">
                                    <i data-lucide="log-in"></i>
                                    <span>Entrar para Participar</span>
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modern-group-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    border: 2px solid var(--bege-claro);
}

.modern-group-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(138, 28, 28, 0.2);
    border-color: var(--dourado-suave);
}

.group-card-header {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.group-card-image {
    width: 100%;
    height: 100%;
    position: relative;
}

.group-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.modern-group-card:hover .group-card-image img {
    transform: scale(1.1);
}

.group-card-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(180deg, transparent 0%, rgba(138, 28, 28, 0.7) 100%);
}

.group-card-icon-bg {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--vermelho-profundo) 0%, #a91d1d 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.group-card-icon-bg::before {
    content: '';
    position: absolute;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: pulse 3s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

.group-card-icon-bg i {
    width: 80px;
    height: 80px;
    color: white;
    opacity: 0.9;
    z-index: 1;
}

.group-card-badge {
    position: absolute;
    top: 16px;
    right: 16px;
    background: var(--dourado-suave);
    color: var(--vermelho-profundo);
    padding: 8px 16px;
    border-radius: 100px;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    backdrop-filter: blur(10px);
}

.group-card-body {
    padding: 24px;
    flex-grow: 1;
}

.group-card-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--vermelho-profundo);
    margin-bottom: 12px;
    line-height: 1.3;
}

.group-card-description {
    color: #666;
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 20px;
}

.group-card-info {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px;
    background: var(--bege-claro);
    border-radius: 12px;
    transition: all 0.3s ease;
    border-left: 3px solid var(--dourado-suave);
}

.info-item:hover {
    background: #f0ebe5;
    transform: translateX(3px);
    border-left-color: var(--vermelho-profundo);
}

.info-icon {
    width: 36px;
    height: 36px;
    background: var(--vermelho-profundo);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.info-icon i {
    width: 18px;
    height: 18px;
    color: white;
}

.info-content {
    flex: 1;
    min-width: 0;
}

.info-content small {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-content strong,
.info-content a {
    font-size: 14px;
    color: #333;
}

.group-card-footer {
    padding: 20px 24px;
    background: linear-gradient(180deg, #fafafa 0%, #f5f5f5 100%);
    border-top: 2px solid #e0e0e0;
}

.btn-group-action {
    width: 100%;
    padding: 14px 24px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 15px;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.btn-group-action i {
    width: 20px;
    height: 20px;
}

.btn-group-action.primary {
    background: var(--vermelho-profundo);
    color: white;
}

.btn-group-action.primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(138, 28, 28, 0.3);
    background: #6d1616;
}

.btn-group-action.outline {
    background: white;
    border-color: var(--vermelho-profundo);
    color: var(--vermelho-profundo);
}

.btn-group-action.outline:hover {
    background: var(--vermelho-profundo);
    color: white;
}

.btn-group-action.disabled {
    background: #e0e0e0;
    color: #999;
    cursor: not-allowed;
}

@media (max-width: 768px) {
    .group-card-header {
        height: 160px;
    }
    
    .group-card-title {
        font-size: 18px;
    }
}
</style>
            
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
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <div style="display: inline-block; background: var(--dourado-suave); color: var(--vermelho-profundo); padding: 8px 20px; border-radius: 50px; font-size: 14px; font-weight: 600; margin-bottom: 20px;">
                    <i data-lucide="info" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle;"></i>
                    Guia de Participação
                </div>
                <h2 class="mb-3" style="color: var(--vermelho-profundo);">Como Participar?</h2>
                <p class="lead text-muted">É simples e rápido! Siga estes passos para fazer parte da nossa comunidade</p>
            </div>
        </div>
        
        <div class="row g-4 mb-5">
            <div class="col-lg-4 col-md-6">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div class="step-icon">
                        <i data-lucide="search"></i>
                    </div>
                    <h4>Explore as Pastorais</h4>
                    <p>Navegue pelos grupos disponíveis e encontre aquele que mais se alinha com seu carisma e chamado espiritual.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div class="step-icon">
                        <i data-lucide="user-plus"></i>
                    </div>
                    <h4>Solicite Participação</h4>
                    <p>Após fazer login, clique em "Solicitar Participação" no grupo escolhido e preencha sua solicitação.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div class="step-icon">
                        <i data-lucide="check-circle"></i>
                    </div>
                    <h4>Aguarde a Aprovação</h4>
                    <p>O coordenador da pastoral avaliará sua solicitação e você receberá uma notificação com a resposta.</p>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="cta-card">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-8">
                            <h3 class="mb-3">Pronto para começar?</h3>
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
                                <a href="{{ route('register') }}" class="btn-cta btn-cta-primary mb-2">
                                    <i data-lucide="user-plus"></i>
                                    <span>Criar Conta Grátis</span>
                                </a>
                                <a href="{{ route('login') }}" class="btn-cta btn-cta-outline">
                                    <i data-lucide="log-in"></i>
                                    <span>Já tenho conta</span>
                                </a>
                            @else
                                <div class="success-badge mb-3">
                                    <i data-lucide="check-circle"></i>
                                    <span>Você está conectado!</span>
                                </div>
                                <a href="{{ route('dashboard') }}" class="btn-cta btn-cta-outline">
                                    <i data-lucide="layout-dashboard"></i>
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

<style>
.step-card {
    background: white;
    border-radius: 20px;
    padding: 40px 30px;
    text-align: center;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    transition: all 0.4s ease;
    position: relative;
    height: 100%;
}

.step-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 32px rgba(138, 28, 28, 0.15);
}

.step-number {
    position: absolute;
    top: -20px;
    left: 50%;
    transform: translateX(-50%);
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--vermelho-profundo) 0%, #a91d1d 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: 700;
    box-shadow: 0 4px 16px rgba(138, 28, 28, 0.3);
    border: 4px solid white;
}

.step-icon {
    width: 80px;
    height: 80px;
    margin: 20px auto 24px;
    background: linear-gradient(135deg, var(--bege-claro) 0%, #f0ebe5 100%);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.4s ease;
}

.step-card:hover .step-icon {
    transform: scale(1.1) rotate(5deg);
    background: linear-gradient(135deg, var(--dourado-suave) 0%, #d4af37 100%);
}

.step-icon i {
    width: 40px;
    height: 40px;
    color: var(--vermelho-profundo);
}

.step-card h4 {
    font-size: 20px;
    font-weight: 700;
    color: var(--vermelho-profundo);
    margin-bottom: 16px;
}

.step-card p {
    color: #666;
    font-size: 15px;
    line-height: 1.6;
    margin: 0;
}

.cta-card {
    background: linear-gradient(135deg, var(--vermelho-profundo) 0%, #a91d1d 100%);
    color: white;
    border-radius: 24px;
    padding: 48px;
    box-shadow: 0 12px 40px rgba(138, 28, 28, 0.3);
    position: relative;
    overflow: hidden;
}

.cta-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: pulse 4s ease-in-out infinite;
}

.cta-card h3 {
    color: white;
    font-weight: 700;
    position: relative;
    z-index: 1;
}

.cta-card p {
    color: rgba(255,255,255,0.9);
    position: relative;
    z-index: 1;
}

.btn-cta {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 14px 32px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 15px;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
    width: 100%;
}

.btn-cta i {
    width: 20px;
    height: 20px;
}

.btn-cta-primary {
    background: white;
    color: var(--vermelho-profundo);
}

.btn-cta-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(255,255,255,0.3);
}

.btn-cta-outline {
    background: transparent;
    border: 2px solid white;
    color: white;
}

.btn-cta-outline:hover {
    background: rgba(255,255,255,0.1);
    transform: translateY(-2px);
}

.success-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.2);
    color: white;
    padding: 12px 24px;
    border-radius: 100px;
    font-weight: 600;
    backdrop-filter: blur(10px);
}

.success-badge i {
    width: 24px;
    height: 24px;
}

@media (max-width: 992px) {
    .cta-card {
        padding: 32px;
        text-align: center;
    }
    
    .step-card {
        padding: 32px 24px;
    }
}
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryFilters = document.querySelectorAll('[data-category]');
    const groupCards = document.querySelectorAll('.group-card-item');
    
    // Contar grupos por categoria
    function updateCategoryCounts() {
        const counts = {
            all: groupCards.length,
            catequese: 0,
            liturgia: 0,
            familia: 0,
            juventude: 0
        };
        
        groupCards.forEach(card => {
            const category = card.dataset.category;
            if (counts.hasOwnProperty(category)) {
                counts[category]++;
            }
        });
        
        // Atualizar os contadores na UI
        Object.keys(counts).forEach(cat => {
            const countEl = document.getElementById(`count-${cat}`);
            if (countEl) {
                countEl.textContent = counts[cat];
            }
        });
    }
    
    // Filtro de categorias
    categoryFilters.forEach(filter => {
        filter.addEventListener('click', function() {
            const category = this.dataset.category;
            
            // Atualizar botões ativos
            categoryFilters.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filtrar cards com animação
            let delay = 0;
            groupCards.forEach(card => {
                const cardCategory = card.dataset.category;
                
                if (category === 'all' || cardCategory === category) {
                    setTimeout(() => {
                        card.style.display = 'block';
                        card.style.animation = 'fadeInUp 0.5s ease-out both';
                    }, delay);
                    delay += 50;
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
    
    // Inicializar contadores
    updateCategoryCounts();
    
    // Inicializar Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    // Animação de scroll suave
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>
@endpush
