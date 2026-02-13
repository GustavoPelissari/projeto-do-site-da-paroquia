{{-- Footer da Paróquia São Paulo Apóstolo --}}
<footer class="sp-footer">
    <div class="sp-container">
        <div class="sp-footer-content">
            {{-- Informações da Paróquia --}}
            <div class="sp-footer-section">
                <h3>Paróquia São Paulo Apóstolo</h3>
                <p>Uma comunidade de fé, esperança e caridade, caminhando na luz do Evangelho e no exemplo do grande Apóstolo dos Gentios.</p>
                
                <div style="margin-top: var(--space-lg);">
                    <div style="display: flex; align-items: center; gap: var(--space-sm); margin-bottom: var(--space-sm);">
                        <span></span>
                        <a href="mailto:contato@paroquiasaopaulo.org.br">contato@paroquiasaopaulo.org.br</a>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: var(--space-sm); margin-bottom: var(--space-sm);">
                        <span></span>
                        <a href="tel:+5511999999999">(11) 99999-9999</a>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: var(--space-sm);">
                        <span></span>
                        <span>Rua São Paulo Apóstolo, 123 - Centro - São Paulo/SP</span>
                    </div>
                </div>
            </div>

            {{-- Horários de Funcionamento --}}
            <div class="sp-footer-section">
                <h3>Horários</h3>
                
                <div style="margin-bottom: var(--space-lg);">
                    <h4 style="color: var(--sp-gold-light); font-size: var(--text-base); margin-bottom: var(--space-sm);">Missas</h4>
                    <div style="font-size: var(--text-sm); line-height: 1.6;">
                        <div>Segunda a Sexta: 7h e 19h</div>
                        <div>Sábado: 19h (Vigília)</div>
                        <div>Domingo: 7h, 9h, 11h e 19h</div>
                    </div>
                </div>
                
                <div>
                    <h4 style="color: var(--sp-gold-light); font-size: var(--text-base); margin-bottom: var(--space-sm);">Secretaria</h4>
                    <div style="font-size: var(--text-sm); line-height: 1.6;">
                        <div>Segunda a Sexta: 8h às 17h</div>
                        <div>Sábado: 8h às 12h</div>
                        <div>Domingo: Fechado</div>
                    </div>
                </div>
            </div>

            {{-- Links Úteis --}}
            <div class="sp-footer-section">
                <h3>Navegação</h3>
                <div style="display: flex; flex-direction: column; gap: var(--space-sm);">
                    <a href="{{ route('home') }}">Início</a>
                    <a href="{{ route('groups') }}">Grupos e Pastorais</a>
                    
                    @if(Route::has('masses'))
                        <a href="{{ route('masses') }}">Missas e Eventos</a>
                    @endif
                    
                    @guest
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Cadastre-se</a>
                        @endif
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}">Entrar</a>
                        @endif
                    @endguest
                    
                    @auth
                        <a href="{{ route('profile.edit') }}">Meu Perfil</a>
                        @if(auth()->user()->role !== 'visitante')
                            <a href="{{ route('group-requests.create') }}">Participar de Grupos</a>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- Sobre São Paulo Apóstolo --}}
            <div class="sp-footer-section">
                <h3>São Paulo Apóstolo</h3>
                <p style="font-size: var(--text-sm); line-height: 1.6; margin-bottom: var(--space-md);">
                    "Combati o bom combate, terminei a corrida, guardei a fé."
                </p>
                <p style="font-size: var(--text-xs); color: var(--sp-gold-light);">
                    2 Timóteo 4:7
                </p>
                
                <div style="margin-top: var(--space-lg);">
                    <p style="font-size: var(--text-sm); line-height: 1.6;">
                        São Paulo, o Apóstolo dos Gentios, nos inspira a levar a Boa Nova a todos os povos com coragem, dedicação e amor incondicional.
                    </p>
                </div>
            </div>
        </div>

        {{-- Rodapé inferior --}}
        <div class="sp-footer-bottom">
            <div style="display: flex; flex-direction: column; align-items: center; gap: var(--space-sm);">
                <div style="display: flex; align-items: center; gap: var(--space-md); flex-wrap: wrap; justify-content: center;">
                    <span>&copy; {{ date('Y') }} Paróquia São Paulo Apóstolo</span>
                    <span>•</span>
                    <span>Todos os direitos reservados</span>
                    <span>•</span>
                    <span>Desenvolvido para a comunidade</span>
                </div>
                
                <div style="font-size: var(--text-xs); color: var(--sp-gold-light);">
                    Sistema Paroquial - Versão 1.0
                </div>
            </div>
        </div>
    </div>
</footer>

{{-- CSS específico do footer --}}
<style>
    .sp-footer {
        background: var(--sp-red-dark);
        color: var(--sp-white);
        padding: var(--space-2xl) 0;
        margin-top: var(--space-3xl);
    }
    
    .sp-footer-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: var(--space-xl);
        margin-bottom: var(--space-xl);
    }
    
    .sp-footer-section h3 {
        color: var(--sp-gold);
        margin-bottom: var(--space-md);
        font-size: var(--text-lg);
        font-weight: var(--font-semibold);
    }
    
    .sp-footer-section p,
    .sp-footer-section a {
        color: var(--sp-ivory);
        text-decoration: none;
        transition: color var(--transition-fast);
    }
    
    .sp-footer-section a:hover {
        color: var(--sp-gold);
    }
    
    .sp-footer-bottom {
        text-align: center;
        padding-top: var(--space-xl);
        border-top: 1px solid rgba(248, 245, 231, 0.2);
        color: var(--sp-ivory);
    }
    
    @media (max-width: 768px) {
        .sp-footer {
            padding: var(--space-xl) 0;
            margin-top: var(--space-2xl);
        }
        
        .sp-footer-content {
            grid-template-columns: 1fr;
            gap: var(--space-lg);
            margin-bottom: var(--space-lg);
        }
        
        .sp-footer-section {
            text-align: center;
        }
        
        .sp-footer-bottom {
            padding-top: var(--space-lg);
        }
        
        .sp-footer-bottom > div > div {
            flex-direction: column;
            gap: var(--space-xs);
        }
        
        .sp-footer-bottom span:nth-child(even) {
            display: none; /* Remove separadores em mobile */
        }
    }
    
    @media (max-width: 480px) {
        .sp-footer {
            padding: var(--space-lg) 0;
        }
        
        .sp-footer-section h3 {
            font-size: var(--text-base);
        }
        
        .sp-footer-section p,
        .sp-footer-section a {
            font-size: var(--text-sm);
        }
    }
</style>