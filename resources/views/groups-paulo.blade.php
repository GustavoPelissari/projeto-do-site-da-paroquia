@extends('layout')

@section('title', 'Grupos e Pastorais - São Paulo Apóstolo')

@section('content')

<!-- Hero Section -->
<section class="paulo-hero" style="padding: var(--space-2xl) 0;">
    <div class="paulo-hero-content">
        <div class="paulo-hero-icon" style="width: 80px; height: 80px; font-size: 2rem;">
            👥
        </div>
        <h1 class="paulo-hero-title" style="font-size: 2.5rem;">Grupos e Pastorais</h1>
        <p class="paulo-hero-subtitle">
            Conheça nossos grupos paroquiais e encontre seu lugar na nossa comunidade de fé, 
            seguindo o exemplo missionário de São Paulo Apóstolo.
        </p>
    </div>
</section>

<!-- Groups Section -->
<section class="paulo-section" style="background: var(--paulo-cream);">
    <div class="paulo-container">
        @if($groups->count() > 0)
            <h2 class="paulo-section-title">Nossos Grupos Ativos</h2>
            <p class="text-center mb-xl" style="color: var(--paulo-gray-dark); max-width: 600px; margin: 0 auto var(--space-2xl);">
                Cada grupo tem sua missão especial na construção do Reino de Deus. Encontre aquele que mais se alinha com seu carisma e chamado.
            </p>
            
            <div class="paulo-grid paulo-grid-3">
                @foreach($groups as $group)
                    <article class="paulo-card paulo-interactive">
                        <div class="paulo-card-icon">
                            🙏
                        </div>
                        <h3 class="paulo-card-title">{{ $group->name }}</h3>
                        
                        @if($group->description)
                            <p class="paulo-card-text">{{ $group->description }}</p>
                        @endif
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: var(--space-lg);">
                            <span style="background: var(--paulo-beige); color: var(--paulo-teal); padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                                ✅ Grupo Ativo
                            </span>
                            
                            @auth
                                <a href="{{ route('group-requests.create') }}" 
                                   style="color: var(--paulo-red); font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                                    Participar →
                                </a>
                            @endauth
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="text-center paulo-fade-in" style="padding: var(--space-3xl) 0;">
                <div style="font-size: 4rem; margin-bottom: var(--space-lg); color: var(--paulo-teal);">🏗️</div>
                <h3 style="color: var(--paulo-red-dark); margin-bottom: var(--space-lg); font-size: 2rem;">Grupos em Organização</h3>
                <p style="color: var(--paulo-gray-dark); font-size: 1.125rem; max-width: 500px; margin: 0 auto;">
                    Estamos estruturando nossos grupos paroquiais com muito cuidado e oração. 
                    Em breve você poderá se inscrever e participar ativamente de nossa missão evangelizadora!
                </p>
            </div>
        @endif
    </div>
</section>

<!-- Call to Action Section -->
<section class="paulo-section" style="background: var(--gradient-sacred);">
    <div class="paulo-container text-center" style="color: var(--paulo-white);">
        <h2 style="color: var(--paulo-white); margin-bottom: var(--space-lg);">Quer Fazer Parte?</h2>
        <p style="color: var(--paulo-gold-light); font-size: 1.25rem; margin-bottom: var(--space-2xl); max-width: 600px; margin-left: auto; margin-right: auto;">
            Junte-se à nossa comunidade paroquial! Como São Paulo nos ensinou, cada um tem seus dons únicos 
            para servir no Corpo de Cristo.
        </p>
        
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            @guest
                <a href="{{ route('register') }}" class="paulo-btn paulo-btn-gold">
                    🚀 Cadastre-se na Paróquia
                </a>
                <a href="{{ route('login') }}" class="paulo-btn paulo-btn-secondary">
                    🔑 Já sou Cadastrado
                </a>
            @else
                <a href="{{ route('group-requests.create') }}" class="paulo-btn paulo-btn-gold">
                    ✋ Solicitar Participação
                </a>
                <a href="{{ route('group-requests.my-requests') }}" class="paulo-btn paulo-btn-secondary">
                    📋 Minhas Solicitações
                </a>
            @endguest
        </div>
    </div>
</section>

<!-- Information Section -->
<section class="paulo-section" style="background: var(--paulo-white);">
    <div class="paulo-container">
        <div class="paulo-grid paulo-grid-2" style="align-items: center;">
            <div>
                <h3 style="color: var(--paulo-red-dark); margin-bottom: var(--space-lg); font-size: 1.75rem;">Como Participar</h3>
                <div style="margin-bottom: var(--space-lg);">
                    <h4 style="color: var(--paulo-teal); margin-bottom: var(--space-sm); font-size: 1.125rem;">1. Cadastre-se no Sistema</h4>
                    <p style="color: var(--paulo-gray-dark);">
                        Faça seu cadastro em nosso sistema paroquial com seus dados pessoais.
                    </p>
                </div>
                
                <div style="margin-bottom: var(--space-lg);">
                    <h4 style="color: var(--paulo-teal); margin-bottom: var(--space-sm); font-size: 1.125rem;">2. Escolha seu Grupo</h4>
                    <p style="color: var(--paulo-gray-dark);">
                        Conheça nossos grupos e pastorais para encontrar aquele que mais se alinha com seu carisma.
                    </p>
                </div>
                
                <div style="margin-bottom: var(--space-lg);">
                    <h4 style="color: var(--paulo-teal); margin-bottom: var(--space-sm); font-size: 1.125rem;">3. Solicite Participação</h4>
                    <p style="color: var(--paulo-gray-dark);">
                        Envie sua solicitação através do sistema e aguarde o contato do coordenador do grupo.
                    </p>
                </div>
                
                <div>
                    <h4 style="color: var(--paulo-teal); margin-bottom: var(--space-sm); font-size: 1.125rem;">4. Participe e Sirva</h4>
                    <p style="color: var(--paulo-gray-dark);">
                        Integre-se às atividades do grupo e contribua com seus dons para a missão evangelizadora.
                    </p>
                </div>
            </div>
            
            <div class="text-center">
                <div style="width: 180px; height: 180px; background: var(--gradient-gold); border-radius: 50%; margin: 0 auto var(--space-lg); display: flex; align-items: center; justify-content: center; font-size: 3rem; color: var(--paulo-white); box-shadow: var(--shadow-gold);">
                    ⛪
                </div>
                <blockquote style="font-style: italic; color: var(--paulo-teal); font-size: 1.125rem; margin-top: var(--space-lg);">
                    "Há diversidade de carismas, mas o Espírito é o mesmo"<br>
                    <cite style="font-size: 0.875rem; color: var(--paulo-gray);">1 Coríntios 12:4</cite>
                </blockquote>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="paulo-section" style="background: var(--paulo-beige);">
    <div class="paulo-container">
        <h2 class="paulo-section-title">Dúvidas sobre os Grupos?</h2>
        <p class="text-center mb-xl" style="color: var(--paulo-gray-dark); max-width: 600px; margin: 0 auto var(--space-2xl);">
            Nossa equipe pastoral está pronta para ajudar você a encontrar o grupo ideal para sua caminhada de fé.
        </p>
        
        <div class="paulo-grid paulo-grid-3">
            <div class="paulo-card text-center">
                <div class="paulo-card-icon">📧</div>
                <h3 class="paulo-card-title">Email dos Grupos</h3>
                <p class="paulo-card-text">
                    <a href="mailto:grupos@saopauloapostolo.com" style="color: var(--paulo-red);">
                        grupos@saopauloapostolo.com
                    </a>
                </p>
            </div>
            
            <div class="paulo-card text-center">
                <div class="paulo-card-icon">📱</div>
                <h3 class="paulo-card-title">WhatsApp</h3>
                <p class="paulo-card-text">
                    <a href="https://wa.me/5511999999999" style="color: var(--paulo-red);">
                        (11) 99999-9999
                    </a>
                </p>
            </div>
            
            <div class="paulo-card text-center">
                <div class="paulo-card-icon">⏰</div>
                <h3 class="paulo-card-title">Horário de Atendimento</h3>
                <p class="paulo-card-text">
                    Segunda a Sexta<br>
                    8h às 17h<br>
                    Sábado: 8h às 12h
                </p>
            </div>
        </div>
        
        <div class="text-center mt-xl">
            <p style="color: var(--paulo-teal); font-style: italic; font-size: 1.125rem;">
                "Cada um ponha a serviço dos outros o carisma que recebeu" - 1 Pedro 4:10
            </p>
        </div>
    </div>
</section>

@endsection