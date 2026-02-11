<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Front-end removido</title>
    <meta name="robots" content="noindex,nofollow">
    <style>html,body{height:100%;margin:0;font-family:Arial, Helvetica, sans-serif;background:#fff;color:#111} .placeholder{display:flex;flex-direction:column;align-items:center;justify-content:center;height:100vh;text-align:center;padding:2rem} .placeholder h1{color:#2C2F6B;margin-bottom:.5rem} .placeholder p{color:#444;opacity:.9}</style>
</head>
<body>
    <div class="placeholder">
        <h1>Front-end temporariamente removido</h1>
        <p>As views públicas foram limpas. Reconstruiremos o front-end do zero.</p>
        <p style="margin-top:1rem"><a href="{{ route('login') }}">Ir para login</a></p>
    </div>
</body>
</html>
                                </a>
                                
                                <!-- Menu para usuários padrão -->
                                @if(auth()->user()->role === 'usuario_padrao')
                                    <a href="{{ route('group-requests.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <span class="mr-2">📝</span> Solicitar Entrada em Grupo
                                    </a>
                                    <a href="{{ route('group-requests.my-requests') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <span class="mr-2">📋</span> Minhas Solicitações
                                    </a>
                                @endif

                                <!-- Menu para coordenadores -->
                                @if(auth()->user()->role === 'coordenador_de_pastoral')
                                    <a href="{{ route('admin.coordenador.requests.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <span class="mr-2">✉️</span> Solicitações Pendentes
                                    </a>
                                    <a href="{{ route('admin.coordenador.scales.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <span class="mr-2">📅</span> Gerenciar Escalas
                                    </a>
                                @endif
                                
                                <!-- Menu administrativo -->
                                @if(in_array(auth()->user()->role, ['admin_global', 'administrativo', 'coordenador_de_pastoral']))
                                    <div class="border-t border-gray-100 my-1"></div>
                                    @if(auth()->user()->role === 'admin_global')
                                        <a href="{{ route('admin.global.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <span class="mr-2">⚙️</span> Admin Global
                                        </a>
                                    @elseif(auth()->user()->role === 'coordenador_de_pastoral')
                                        <a href="{{ route('admin.coordenador.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <span class="mr-2">⚙️</span> Painel Coordenador
                                        </a>
                                    @elseif(auth()->user()->role === 'administrativo')
                                        <a href="{{ route('admin.administrativo.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <span class="mr-2">⚙️</span> Painel Administrativo
                                        </a>
                                    @endif
                                    <a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <span class="mr-2">🏠</span> Área Pública
                                    </a>
                                @endif
                                
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <span class="mr-2">🚪</span> Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 transition">
                            Entrar
                        </a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            Cadastrar
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button type="button" class="text-gray-600 hover:text-blue-600" onclick="toggleMobileMenu()">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-4">
                <div class="space-y-2">
                    <a href="{{ route('home') }}" class="block text-gray-600 hover:text-blue-600 transition py-2">Início</a>
                    <a href="{{ route('groups') }}" class="block text-gray-600 hover:text-blue-600 transition py-2">Grupos</a>
                    
                    @auth
                        <div class="border-t pt-2 mt-2">
                            <a href="{{ route('profile.edit') }}" class="block text-gray-600 hover:text-blue-600 transition py-2">Perfil</a>
                            @if(in_array(Auth::user()->role, ['admin_global', 'administrativo', 'coordenador_de_pastoral']))
                                @if(Auth::user()->role === 'admin_global')
                                    <a href="{{ route('admin.global.dashboard') }}" class="block text-gray-600 hover:text-blue-600 transition py-2">Admin Global</a>
                                @elseif(Auth::user()->role === 'coordenador_de_pastoral')
                                    <a href="{{ route('admin.coordenador.dashboard') }}" class="block text-gray-600 hover:text-blue-600 transition py-2">Painel Coordenador</a>
                                @elseif(Auth::user()->role === 'administrativo')
                                    <a href="{{ route('admin.administrativo.dashboard') }}" class="block text-gray-600 hover:text-blue-600 transition py-2">Painel Administrativo</a>
                                @endif
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left text-gray-600 hover:text-blue-600 transition py-2">Sair</button>
                            </form>
                        </div>
                    @else
                        <div class="border-t pt-2 mt-2">
                            <a href="{{ route('login') }}" class="block text-gray-600 hover:text-blue-600 transition py-2">Entrar</a>
                            <a href="{{ route('register') }}" class="block text-gray-600 hover:text-blue-600 transition py-2">Cadastrar</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-4 max-w-7xl mx-auto">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-4 max-w-7xl mx-auto">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="paulo-footer">
        <div class="paulo-container">
            <div class="paulo-footer-content">
                <!-- About -->
                <div class="paulo-footer-section">
                    <h3>Paróquia São Paulo Apóstolo</h3>
                    <p style="margin-bottom: var(--space-md);">
                        Uma comunidade de fé inspirada no exemplo missionário de São Paulo Apóstolo, 
                        levando o Evangelho a todos os corações.
                    </p>
                    <p style="font-style: italic; color: var(--paulo-gold-light);">
                        "Ai de mim se não evangelizar!" - 1 Cor 9:16
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="paulo-footer-section">
                    <h3>Links Rápidos</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: var(--space-sm);"><a href="{{ route('home') }}">⛪ Início</a></li>
                        <li style="margin-bottom: var(--space-sm);"><a href="{{ route('groups') }}">👥 Grupos e Pastorais</a></li>
                        @auth
                            <li style="margin-bottom: var(--space-sm);">
                                <a href="@userDashboard">📊 @userAreaLabel</a>
                            </li>
                            <li style="margin-bottom: var(--space-sm);"><a href="{{ route('group-requests.create') }}">✋ Participar de Grupo</a></li>
                        @else
                            <li style="margin-bottom: var(--space-sm);"><a href="{{ route('register') }}">🚀 Cadastre-se</a></li>
                            <li style="margin-bottom: var(--space-sm);"><a href="{{ route('login') }}">🔑 Entrar</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Contact -->
                <div class="paulo-footer-section">
                    <h3>Contato</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: var(--space-sm);">📍 Rua São Paulo Apóstolo, 123<br>&nbsp;&nbsp;&nbsp;&nbsp;Bairro Centro - São Paulo/SP</li>
                        <li style="margin-bottom: var(--space-sm);">📞 <a href="tel:+5511999999999">(11) 99999-9999</a></li>
                        <li style="margin-bottom: var(--space-sm);">✉️ <a href="mailto:contato@saopauloapostolo.com">contato@saopauloapostolo.com</a></li>
                        <li style="margin-bottom: var(--space-sm);">⏰ Seg-Sex: 8h-17h | Sáb: 8h-12h</li>
                    </ul>
                </div>
            </div>

            <div class="paulo-footer-bottom">
                <p>&copy; {{ date('Y') }} Paróquia São Paulo Apóstolo. Todos os direitos reservados.</p>
                <p style="margin-top: var(--space-sm); font-size: 0.875rem;">
                    "Graça e paz da parte de Deus nosso Pai e do Senhor Jesus Cristo" - Ef 1:2
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const button = event.target.closest('button');
            
            if (!button || !button.onclick || button.onclick.toString().indexOf('toggleDropdown') === -1) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>