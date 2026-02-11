@extends('layout')

@section('title', 'Paróquia São José')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900 text-white overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-full h-full opacity-10">
                <div class="absolute top-10 left-10 text-6xl">✞</div>
                <div class="absolute top-32 right-20 text-4xl">⛪</div>
                <div class="absolute bottom-20 left-20 text-5xl">🕊️</div>
                <div class="absolute bottom-32 right-10 text-3xl">✞</div>
            </div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 py-20 text-center">
            <div class="mb-8">
                <div class="text-6xl mb-6">⛪</div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                    Paróquia São José
                </h1>
                <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Uma comunidade de fé, esperança e amor. Venha fazer parte da nossa família paroquial e crescer na caminhada cristã.
                </p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('groups') }}" 
                   class="bg-white text-blue-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-300 shadow-lg">
                    🤝 Nossos Grupos
                </a>
                @guest
                    <a href="{{ route('register') }}" 
                       class="border-2 border-white text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-blue-600 transition-all duration-300">
                        ✨ Cadastre-se
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" 
                       class="border-2 border-white text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-blue-600 transition-all duration-300">
                        📊 Meu Painel
                    </a>
                @endguest
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-6">
                    <div class="text-5xl mb-4 text-blue-600">{{ $groups->count() ?? 0 }}</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Grupos e Pastorais</h3>
                    <p class="text-gray-600">Comunidades ativas servindo nossa paróquia</p>
                </div>
                
                <div class="p-6">
                    <div class="text-5xl mb-4 text-green-600">{{ $recentSchedules->count() ?? 0 }}</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Escalas Ativas</h3>
                    <p class="text-gray-600">Cronogramas organizados para nossas atividades</p>
                </div>
                
                <div class="p-6">
                    <div class="text-5xl mb-4 text-purple-600">∞</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Fé e Esperança</h3>
                    <p class="text-gray-600">Unidos na caminhada cristã</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Groups Section -->
    @if($groups->count() > 0)
        <div class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Conheça Nossos Grupos</h2>
                    <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                        Cada grupo tem sua missão especial na construção do Reino de Deus
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($groups->take(6) as $group)
                        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 border border-gray-100">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-2xl">🙏</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $group->name }}</h3>
                            </div>
                            
                            @if($group->description)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit($group->description, 100) }}</p>
                            @endif
                            
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    ✅ Ativo
                                </span>
                                
                                @auth
                                    <a href="{{ route('group-requests.create') }}" 
                                       class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                        Participar →
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="text-center mt-8">
                    <a href="{{ route('groups') }}" 
                       class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition-all duration-300">
                        Ver Todos os Grupos →
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- CTA Section -->
    <div class="py-16 bg-gradient-to-r from-green-500 to-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Faça Parte da Nossa Comunidade</h2>
            <p class="text-xl text-green-100 mb-8 max-w-2xl mx-auto">
                Junte-se a nós nesta jornada de fé, amor e serviço ao próximo. Todos são bem-vindos!
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                    <a href="{{ route('register') }}" 
                       class="bg-white text-green-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-300 shadow-lg">
                        🚀 Cadastrar-se Agora
                    </a>
                    <a href="{{ route('login') }}" 
                       class="border-2 border-white text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-green-600 transition-all duration-300">
                        Já sou cadastrado
                    </a>
                @else
                    <a href="{{ route('group-requests.create') }}" 
                       class="bg-white text-green-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-300 shadow-lg">
                        ✋ Solicitar Participação em Grupo
                    </a>
                    <a href="{{ route('dashboard') }}" 
                       class="border-2 border-white text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-green-600 transition-all duration-300">
                        📊 Acessar Meu Painel
                    </a>
                @endguest
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">💬 Precisa de Ajuda?</h2>
            <p class="text-gray-600 text-lg mb-8 max-w-2xl mx-auto">
                Nossa equipe está sempre disponível para ajudar você. Entre em contato conosco!
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 border border-gray-200 rounded-xl">
                    <div class="text-3xl mb-3">📧</div>
                    <h3 class="font-bold text-gray-900 mb-2">Email</h3>
                    <a href="mailto:contato@paroquiasaojose.com" class="text-blue-600 hover:text-blue-800">
                        contato@paroquiasaojose.com
                    </a>
                </div>
                
                <div class="p-6 border border-gray-200 rounded-xl">
                    <div class="text-3xl mb-3">📱</div>
                    <h3 class="font-bold text-gray-900 mb-2">Telefone</h3>
                    <a href="tel:+5511999999999" class="text-blue-600 hover:text-blue-800">
                        (11) 99999-9999
                    </a>
                </div>
                
                <div class="p-6 border border-gray-200 rounded-xl">
                    <div class="text-3xl mb-3">📍</div>
                    <h3 class="font-bold text-gray-900 mb-2">Localização</h3>
                    <p class="text-gray-600">
                        Rua da Paróquia, 123<br>
                        Bairro Centro
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection