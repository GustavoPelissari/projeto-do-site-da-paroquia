@extends('layout')

@section('title', 'Paróquia São Paulo Apóstolo')

@section('content')

<!-- Hero Section -->
<section class="paulo-hero">
    <div class="paulo-hero-content">
        <div class="paulo-hero-icon">
            ✝️
        </div>
        <h1 class="paulo-hero-title">Paróquia São Paulo Apóstolo</h1>
        <p class="paulo-hero-subtitle">
            Uma comunidade de fé, esperança e caridade. Venha caminhar conosco na luz do Evangelho e no exemplo do grande Apóstolo dos Gentios.
        </p>
        
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('groups') }}" class="paulo-btn paulo-btn-gold">
                🤝 Nossos Grupos e Pastorais
            </a>
            @guest
                <a href="{{ route('register') }}" class="paulo-btn paulo-btn-secondary">
                    ✨ Junte-se à Nossa Comunidade
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="paulo-btn paulo-btn-secondary">
                    📊 Meu Painel Paroquial
                </a>
            @endguest
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="paulo-section" style="background: var(--paulo-white);">
    <div class="paulo-container">
        <div class="paulo-grid paulo-grid-3">
            <div class="text-center paulo-fade-in">
                <div style="font-size: 3rem; color: var(--paulo-red); margin-bottom: var(--space-md);">
                    {{ $groups->count() ?? 0 }}
                </div>
                <h3 class="paulo-card-title">Grupos e Pastorais</h3>
                <p class="paulo-card-text">Comunidades ativas servindo nossa paróquia na missão evangelizadora</p>
            </div>
            
            <div class="text-center paulo-fade-in">
                <div style="font-size: 3rem; color: var(--paulo-teal); margin-bottom: var(--space-md);">
                    {{ $recentSchedules->count() ?? 0 }}
                </div>
                <h3 class="paulo-card-title">Escalas Organizadas</h3>
                <p class="paulo-card-text">Cronogramas estruturados para nossas atividades litúrgicas e pastorais</p>
            </div>
            
            <div class="text-center paulo-fade-in">
                <div style="font-size: 3rem; color: var(--paulo-gold); margin-bottom: var(--space-md);">
                    ∞
                </div>
                <h3 class="paulo-card-title">Fé e Esperança</h3>
                <p class="paulo-card-text">Unidos na caminhada cristã, seguindo o exemplo de São Paulo Apóstolo</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Groups Section -->
@if($groups->count() > 0)
<section class="paulo-section" style="background: var(--paulo-cream);">
    <div class="paulo-container">
        <h2 class="paulo-section-title">Conheça Nossos Grupos e Pastorais</h2>
        <p class="text-center mb-xl" style="color: var(--paulo-gray-dark); max-width: 600px; margin: 0 auto var(--space-2xl);">
            Cada grupo tem sua missão especial na construção do Reino de Deus, seguindo o exemplo missionário do Apóstolo Paulo
        </p>
        
        <div class="paulo-grid paulo-grid-3">
            @foreach($groups->take(6) as $group)
                <article class="paulo-card paulo-interactive">
                    <div class="paulo-card-icon">
                        🙏
                    </div>
                    <h3 class="paulo-card-title">{{ $group->name }}</h3>
                    
                    @if($group->description)
                        <p class="paulo-card-text">{{ Str::limit($group->description, 100) }}</p>
                    @endif
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: var(--space-lg);">
                        <span style="background: var(--paulo-beige); color: var(--paulo-teal); padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                            ✅ Ativo
                        </span>
                        
                        @auth
                            <a href="{{ route('group-requests.create') }}" style="color: var(--paulo-red); font-weight: 600; font-size: 0.875rem;">
                                Participar →
                            </a>
                        @endauth
                    </div>
                </article>
            @endforeach
        </div>
        
        <div class="text-center mt-xl">
            <a href="{{ route('groups') }}" class="paulo-btn paulo-btn-primary">
                Ver Todos os Grupos →
            </a>
        </div>
    </div>
</section>
@endif

<!-- Mission Section -->
<section class="paulo-section" style="background: var(--paulo-white);">
    <div class="paulo-container">
        <div class="paulo-grid paulo-grid-2" style="align-items: center;">
            <div>
                <h2 style="color: var(--paulo-red-dark); margin-bottom: var(--space-lg);">Nossa Missão</h2>
                <p style="font-size: 1.125rem; line-height: 1.8; color: var(--paulo-gray-dark); margin-bottom: var(--space-lg);">
                    Inspirados pelo exemplo de <strong>São Paulo Apóstolo</strong>, somos uma comunidade que busca 
                    evangelizar, acolher e servir. Como o grande Apóstolo dos Gentios, levamos a Palavra de Deus 
                    a todos os corações, sem distinção.
                </p>
                <p style="color: var(--paulo-gray-dark); margin-bottom: var(--space-xl);">
                    Nossa paróquia é um lugar de encontro com Cristo, de crescimento na fé e de serviço ao próximo, 
                    sempre seguindo os ensinamentos do Evangelho e o exemplo missionário de nosso padroeiro.
                </p>
                
                @guest
                    <a href="{{ route('register') }}" class="paulo-btn paulo-btn-primary">
                        🚀 Faça Parte da Nossa Família
                    </a>
                @else
                    <a href="{{ route('group-requests.create') }}" class="paulo-btn paulo-btn-primary">
                        ✋ Solicite Participação em um Grupo
                    </a>
                @endguest
            </div>
            
            <div class="text-center">
                <div style="width: 200px; height: 200px; background: var(--gradient-gold); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; font-size: 4rem; color: var(--paulo-white); box-shadow: var(--shadow-gold);">
                    📖
                </div>
                <p style="margin-top: var(--space-lg); font-style: italic; color: var(--paulo-teal);">
                    "Pregai o Evangelho a toda criatura"
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="paulo-section" style="background: var(--gradient-sacred);">
    <div class="paulo-container text-center" style="color: var(--paulo-white);">
        <h2 style="color: var(--paulo-white); margin-bottom: var(--space-lg);">Venha Caminhar Conosco</h2>
        <p style="font-size: 1.25rem; color: var(--paulo-gold-light); margin-bottom: var(--space-2xl); max-width: 600px; margin-left: auto; margin-right: auto;">
            Junte-se à nossa comunidade paroquial e descubra como você pode servir a Deus e ao próximo, 
            seguindo o exemplo missionário de São Paulo Apóstolo.
        </p>
        
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            @guest
                <a href="{{ route('register') }}" class="paulo-btn paulo-btn-gold">
                    🌟 Cadastre-se Agora
                </a>
                <a href="{{ route('login') }}" class="paulo-btn paulo-btn-secondary">
                    🔑 Já sou Paroquiano
                </a>
            @else
                <a href="{{ route('group-requests.create') }}" class="paulo-btn paulo-btn-gold">
                    ✋ Participar de um Grupo
                </a>
                <a href="{{ route('dashboard') }}" class="paulo-btn paulo-btn-secondary">
                    📊 Acessar Meu Painel
                </a>
            @endguest
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="paulo-section" style="background: var(--paulo-white);">
    <div class="paulo-container">
        <h2 class="paulo-section-title">Entre em Contato Conosco</h2>
        <p class="text-center mb-xl" style="color: var(--paulo-gray-dark); max-width: 600px; margin: 0 auto var(--space-2xl);">
            Nossa equipe pastoral está sempre disponível para acolher, orientar e caminhar junto com você na vida de fé.
        </p>
        
        <div class="paulo-grid paulo-grid-3">
            <div class="paulo-card text-center">
                <div class="paulo-card-icon">📧</div>
                <h3 class="paulo-card-title">Email Paroquial</h3>
                <p class="paulo-card-text">
                    <a href="mailto:contato@saopauloapostolo.com" style="color: var(--paulo-red);">
                        contato@saopauloapostolo.com
                    </a>
                </p>
            </div>
            
            <div class="paulo-card text-center">
                <div class="paulo-card-icon">📱</div>
                <h3 class="paulo-card-title">Telefone</h3>
                <p class="paulo-card-text">
                    <a href="tel:+5511999999999" style="color: var(--paulo-red);">
                        (11) 99999-9999
                    </a>
                </p>
            </div>
            
            <div class="paulo-card text-center">
                <div class="paulo-card-icon">📍</div>
                <h3 class="paulo-card-title">Localização</h3>
                <p class="paulo-card-text">
                    Rua São Paulo Apóstolo, 123<br>
                    Bairro Centro<br>
                    São Paulo - SP
                </p>
            </div>
        </div>
        
        <div class="text-center mt-xl">
            <p style="color: var(--paulo-teal); font-style: italic;">
                "A paz de Cristo seja convosco sempre!"
            </p>
        </div>
    </div>
</section>

@endsection