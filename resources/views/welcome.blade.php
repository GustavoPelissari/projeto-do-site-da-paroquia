<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Front-end removido</title>
    <meta name="robots" content="noindex,nofollow">
    <style>html,body{height:100%;margin:0;font-family:Arial, Helvetica, sans-serif;background:#fff;color:#111} .placeholder{display:flex;flex-direction:column;align-items:center;justify-content:center;height:100vh;text-align:center;padding:2rem} .placeholder h1{color:#2C2F6B;margin-bottom:.5rem} .placeholder p{color:#444;opacity:.9}</style>
</head>
<body>
    <div class="placeholder">
        <h1>Front-end público removido</h1>
        <p>As views foram limpas. Reconstruiremos o site a partir de um novo design.</p>
        <p style="margin-top:1rem"><a href="{{ route('login') }}">Ir para login</a></p>
    </div>
</body>
</html>
                        <a href="{{ route('register') }}" class="sp-btn sp-btn-gold sp-btn-lg">
                            ✨ Junte-se à Nossa Comunidade
                        </a>
                    @endif
                    
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="sp-btn sp-btn-outline sp-btn-lg" style="border-color: var(--sp-white); color: var(--sp-white);">
                            🚪 Fazer Login
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section class="welcome-features">
        <div class="sp-container">
            <div class="sp-text-center sp-mb-xl">
                <h2 style="color: var(--sp-red-dark); margin-bottom: var(--space-md);">
                    Nossa Comunidade
                </h2>
                <p style="color: var(--sp-gray-dark); max-width: 600px; margin: 0 auto;">
                    Descubra as diversas formas de participar e crescer em nossa família paroquial
                </p>
            </div>
            
            <div class="sp-grid sp-grid-3">
                <div class="feature-card sp-fade-in">
                    <span class="feature-icon" style="color: var(--sp-red);">🤝</span>
                    <h3 class="feature-title">Grupos e Pastorais</h3>
                    <p class="feature-text">
                        Participe de nossos grupos de oração, pastorais e movimentos. 
                        Encontre seu lugar na missão evangelizadora.
                    </p>
                    <div style="margin-top: var(--space-md);">
                        <a href="{{ route('groups') }}" class="sp-btn sp-btn-outline sp-btn-sm">
                            Conhecer Grupos
                        </a>
                    </div>
                </div>
                
                <div class="feature-card sp-fade-in">
                    <span class="feature-icon" style="color: var(--sp-teal);">⛪</span>
                    <h3 class="feature-title">Vida Litúrgica</h3>
                    <p class="feature-text">
                        Celebre conosco a Eucaristia e os sacramentos. 
                        Confira nossos horários de missas e eventos.
                    </p>
                    <div style="margin-top: var(--space-md);">
                        @if(Route::has('masses'))
                            <a href="{{ route('masses') }}" class="sp-btn sp-btn-outline sp-btn-sm">
                                Ver Horários
                            </a>
                        @else
                            <a href="#" class="sp-btn sp-btn-outline sp-btn-sm">
                                Em Breve
                            </a>
                        @endif
                    </div>
                </div>
                
                <div class="feature-card sp-fade-in">
                    <span class="feature-icon" style="color: var(--sp-gold);">❤️</span>
                    <h3 class="feature-title">Vida Comunitária</h3>
                    <p class="feature-text">
                        Faça parte de uma família unida pela fé. 
                        Cadastre-se e conecte-se com outros fiéis.
                    </p>
                    <div style="margin-top: var(--space-md);">
                        @guest
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="sp-btn sp-btn-outline sp-btn-sm">
                                    Cadastrar-se
                                </a>
                            @endif
                        @else
                            <a href="{{ route('profile.edit') }}" class="sp-btn sp-btn-outline sp-btn-sm">
                                Meu Perfil
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Final -->
    <section class="text-center" style="padding: 4rem 0; background: white;">
        <div class="container">
            <h2 style="color: #2C2F6B; margin-bottom: 1rem; font-family: 'Playfair Display', serif;">
                "Combati o bom combate, terminei a corrida, guardei a fé"
            </h2>
            <p style="color: #6c757d; font-style: italic; margin-bottom: 2rem;">
                2 Timóteo 4:7
            </p>
            
            <div class="card" style="max-width: 600px; margin: 0 auto; border: 2px solid #D4AF37;">
                <div class="card-body">
                    <p style="font-size: 1.125rem; line-height: 1.8; color: #333; margin-bottom: 2rem;">
                        Inspirados no exemplo de São Paulo Apóstolo, convidamos você a fazer parte 
                        desta jornada de fé, esperança e caridade. Juntos, podemos construir uma 
                        comunidade mais forte e acolhedora.
                    </p>
                    
                    @guest
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn" style="background: #2C2F6B; color: white; padding: 0.75rem 2rem; border-radius: 8px; text-decoration: none; font-weight: 600;">
                                <i class="bi bi-star-fill me-2" aria-hidden="true"></i>Começar Agora
                            </a>
                        @endif
                    @else
                        <a href="{{ route('dashboard') }}" class="btn" style="background: #2C2F6B; color: white; padding: 0.75rem 2rem; border-radius: 8px; text-decoration: none; font-weight: 600;">
                            <i class="bi bi-house-fill me-2" aria-hidden="true"></i>Acessar Painel
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>
@endsection