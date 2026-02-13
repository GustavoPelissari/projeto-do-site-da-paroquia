{{-- Header da Paróquia São Paulo Apóstolo --}}
<header class="sp-header" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(139, 30, 36, 0.1); box-shadow: 0 4px 20px rgba(139, 30, 36, 0.1);">
    <nav class="sp-nav sp-container">
        {{-- Logo da Paróquia --}}
        <a href="{{ route('home') }}" class="sp-logo" style="transition: all 0.3s ease;">
            <img src="{{ asset(config('branding.logo_path')) }}" 
                 alt="São Paulo Apóstolo"
                 style="height: 48px; width: auto; max-height: 60px; background: transparent; border: 0; border-radius: 0; box-shadow: none; transition: all 0.3s ease;"
                 onmouseover="this.style.transform='scale(1.1) rotate(5deg)'"
                 onmouseout="this.style.transform='scale(1) rotate(0deg)'">
            <div class="sp-logo-text">
                <div class="sp-logo-title" style="color: var(--sp-red); font-weight: 700; font-size: 1.1rem;">São Paulo Apóstolo</div>
                <div class="sp-logo-subtitle" style="color: var(--sp-gold-dark); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px;">Comunidade de Fé</div>
            </div>
        </a>

        {{-- Links de Navegação --}}
        <ul class="sp-nav-links">
            <li>
                <a href="{{ route('home') }}" 
                   class="sp-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    Início
                </a>
            </li>
            
            <li>
                <a href="{{ route('masses') }}" 
                   class="sp-nav-link {{ request()->routeIs('masses*') ? 'active' : '' }}">
                    Missas e Horários
                </a>
            </li>
            
            <li>
                <a href="{{ route('groups') }}" 
                   class="sp-nav-link {{ request()->routeIs('groups*') ? 'active' : '' }}">
                    Grupos e Pastorais
                </a>
            </li>
            
            @auth
                @if(auth()->user()->role !== 'visitante')
                <li>
                    <a href="{{ route('group-requests.create') }}" 
                       class="sp-nav-link {{ request()->routeIs('group-requests.create') ? 'active' : '' }}">
                        Participar
                    </a>
                </li>
                @endif
            @endauth
        </ul>

        {{-- Área do Usuário --}}
        <div class="sp-user-area">
            @auth
                {{-- Usuário Logado --}}
                <div class="sp-user-info">
                    {{-- Foto do usuário se existir --}}
                    @if(Auth::user()->profile_photo_path)
                        <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}" 
                             alt="{{ Auth::user()->name }}"
                             class="sp-user-photo">
                    @endif
                    
                    {{-- Nome do usuário --}}
                    <span class="sp-user-name">{{ Auth::user()->name }}</span>
                </div>
                
                {{-- Dropdown do usuário --}}
                <div style="position: relative;">
                    <button type="button" 
                            onclick="toggleDropdown()"
                            class="sp-btn sp-btn-outline sp-btn-sm"
                            style="padding: var(--space-xs) var(--space-sm);">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    {{-- Menu dropdown --}}
                    <div id="userDropdown" 
                         class="sp-hidden sp-card" 
                         style="position: absolute; right: 0; top: 100%; margin-top: var(--space-sm); min-width: 200px; z-index: 50; padding: var(--space-sm);">
                        
                        <a href="{{ route('profile.edit') }}" 
                           class="sp-nav-link" 
                           style="display: block; margin: 0; padding: var(--space-sm); border-radius: var(--radius-sm);">
                            👤 Meu Perfil
                        </a>
                        
                        {{-- Menu para usuário padrão --}}
                        @if(auth()->user()->role === 'usuario_padrao')
                            <a href="{{ route('group-requests.create') }}" 
                               style="display: block; padding: var(--space-sm); color: var(--sp-gray-dark); text-decoration: none; border-radius: var(--radius-sm); transition: background-color var(--transition-fast);"
                               onmouseover="this.style.backgroundColor='var(--sp-ivory)'"
                               onmouseout="this.style.backgroundColor='transparent'">
                                📝 Solicitar Entrada em Grupo
                            </a>
                            <a href="{{ route('group-requests.my-requests') }}" 
                               style="display: block; padding: var(--space-sm); color: var(--sp-gray-dark); text-decoration: none; border-radius: var(--radius-sm); transition: background-color var(--transition-fast);"
                               onmouseover="this.style.backgroundColor='var(--sp-ivory)'"
                               onmouseout="this.style.backgroundColor='transparent'">
                                📋 Minhas Solicitações
                            </a>
                        @endif

                        {{-- Menu para coordenadores --}}
                        @if(auth()->user()->role === 'coordenador_de_pastoral')
                            <a href="{{ route('group-requests.index') }}" 
                               style="display: block; padding: var(--space-sm); color: var(--sp-gray-dark); text-decoration: none; border-radius: var(--radius-sm); transition: background-color var(--transition-fast);"
                               onmouseover="this.style.backgroundColor='var(--sp-ivory)'"
                               onmouseout="this.style.backgroundColor='transparent'">
                                ✉️ Solicitações Pendentes
                            </a>
                            @if(Route::has('admin.schedules.index'))
                            <a href="{{ route('admin.schedules.index') }}" 
                               style="display: block; padding: var(--space-sm); color: var(--sp-gray-dark); text-decoration: none; border-radius: var(--radius-sm); transition: background-color var(--transition-fast);"
                               onmouseover="this.style.backgroundColor='var(--sp-ivory)'"
                               onmouseout="this.style.backgroundColor='transparent'">
                                📅 Gerenciar Escalas
                            </a>
                            @endif
                        @endif

                        {{-- Menu para administradores --}}
                        @if(auth()->user()->role === 'admin')
                            @if(Route::has('admin.users.index'))
                            <a href="{{ route('admin.users.index') }}" 
                               style="display: block; padding: var(--space-sm); color: var(--sp-gray-dark); text-decoration: none; border-radius: var(--radius-sm); transition: background-color var(--transition-fast);"
                               onmouseover="this.style.backgroundColor='var(--sp-ivory)'"
                               onmouseout="this.style.backgroundColor='transparent'">
                                👥 Gerenciar Usuários
                            </a>
                            @endif
                            @if(Route::has('admin.groups.index'))
                            <a href="{{ route('admin.groups.index') }}" 
                               style="display: block; padding: var(--space-sm); color: var(--sp-gray-dark); text-decoration: none; border-radius: var(--radius-sm); transition: background-color var(--transition-fast);"
                               onmouseover="this.style.backgroundColor='var(--sp-ivory)'"
                               onmouseout="this.style.backgroundColor='transparent'">
                                🏛️ Gerenciar Grupos
                            </a>
                            @endif
                        @endif
                        
                        {{-- Divisor --}}
                        <div style="border-top: 1px solid var(--sp-gray-light); margin: var(--space-sm) 0;"></div>
                        
                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" 
                                    style="display: block; width: 100%; text-align: left; padding: var(--space-sm); color: var(--sp-red); background: none; border: none; cursor: pointer; border-radius: var(--radius-sm); transition: background-color var(--transition-fast);"
                                    onmouseover="this.style.backgroundColor='var(--sp-ivory)'"
                                    onmouseout="this.style.backgroundColor='transparent'">
                                🚪 Sair
                            </button>
                        </form>
                    </div>
                </div>
                
            @else
                {{-- Usuário não logado --}}
                <div style="display: flex; align-items: center; gap: var(--space-sm);">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" 
                           class="sp-btn sp-btn-outline sp-btn-sm"
                           style="border-color: var(--sp-red); color: var(--sp-red); font-weight: 500; padding: var(--space-2) var(--space-4); transition: all 0.3s ease;"
                           onmouseover="this.style.background='var(--sp-red)'; this.style.color='white'; this.style.transform='translateY(-1px)'"
                           onmouseout="this.style.background='transparent'; this.style.color='var(--sp-red)'; this.style.transform='translateY(0)'">
                            🔑 Entrar
                        </a>
                    @endif
                    
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" 
                           class="sp-btn sp-btn-gold sp-btn-sm"
                           style="background: linear-gradient(135deg, var(--sp-gold) 0%, var(--sp-gold-light) 100%); color: var(--sp-red-900); border: none; font-weight: 600; padding: var(--space-2) var(--space-4); box-shadow: 0 2px 8px rgba(212,175,55,0.3); transition: all 0.3s ease;"
                           onmouseover="this.style.transform='translateY(-2px) scale(1.02)'; this.style.boxShadow='0 4px 15px rgba(212,175,55,0.4)'"
                           onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 2px 8px rgba(212,175,55,0.3)'">
                            ✨ Cadastrar
                        </a>
                    @endif
                </div>
            @endauth
        </div>
    </nav>
</header>

{{-- CSS específico para mobile --}}
<style>
    @media (max-width: 768px) {
        .sp-nav {
            flex-direction: column;
            gap: var(--space-md);
            padding: var(--space-md);
        }
        
        .sp-nav-links {
            flex-wrap: wrap;
            justify-content: center;
            gap: var(--space-sm);
        }
        
        .sp-user-area {
            order: -1;
            width: 100%;
            justify-content: center;
        }
        
        .sp-logo {
            flex-direction: column;
            text-align: center;
        }
        
        .sp-logo img {
            height: 40px;
        }
        
        .sp-logo-title {
            font-size: var(--text-base);
        }
        
        .sp-logo-subtitle {
            font-size: var(--text-xs);
        }
    }
    
    @media (max-width: 480px) {
        .sp-nav-links {
            flex-direction: column;
            width: 100%;
        }
        
        .sp-nav-link {
            text-align: center;
            width: 100%;
        }
        
        .sp-user-area {
            flex-direction: column;
            gap: var(--space-sm);
        }
        
        .sp-user-info {
            justify-content: center;
        }
    }
</style>