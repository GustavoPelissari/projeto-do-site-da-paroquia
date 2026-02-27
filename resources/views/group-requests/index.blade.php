@extends('layouts.public')

@section('title', 'Gerenciar Solicitações - Paróquia São Paulo Apóstolo')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Hero Section --}}
        <section class="section-paroquia">
            <div class="section-header">
                <h1>📥 Gerenciar Solicitações</h1>
                <p class="text-lg text-gray-600">
                    Analise e responda às solicitações de entrada no seu grupo ou pastoral
                </p>
            </div>
        </section>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="mb-4 flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 p-4 text-green-800">
                <div>✅</div>
                <div>
                    <strong>Sucesso!</strong> {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 flex items-center gap-3 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700">
                <div>❌</div>
                <div>
                    <strong>Erro!</strong> {{ session('error') }}
                </div>
            </div>
        @endif

        {{-- Main Content --}}
        <section class="section-paroquia">
            <div>
                @forelse($requests as $request)
                    <div class="card-paroquia mb-4" style="border-left: 4px solid {{ $request->status === 'pending' ? 'var(--sp-dourado-principal)' : ($request->status === 'approved' ? 'var(--sp-azul-celestial)' : 'var(--sp-vermelho-sangue)') }};">
                        
                        {{-- Header --}}
                        <div class="card-header-paroquia">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="mb-2 flex items-center gap-3">
                                        <h3 class="mb-0 text-lg">👤 {{ $request->user->name }}</h3>
                                        <span class="rounded-full bg-gray-200 px-2 py-1 text-xs text-gray-700">
                                            {{ $request->user->email }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600">
                                        📅 Solicitado em {{ $request->created_at->format('d/m/Y \à\s H:i') }}
                                    </p>
                                </div>
                                
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($request->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-700') }}">
                                    @if($request->status === 'pending')
                                        ⏳ Aguardando Análise
                                    @elseif($request->status === 'approved')
                                        ✅ Aprovada
                                    @else
                                        ❌ Rejeitada
                                    @endif
                                </span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="card-body">
                            
                            {{-- Mensagem do Candidato --}}
                            @if($request->message)
                                <div class="mb-3 rounded-lg border border-yellow-200 bg-yellow-50">
                                    <div class="px-4 py-2">
                                        <h6 class="mb-0 font-semibold text-dourado">💬 Mensagem do Candidato</h6>
                                    </div>
                                    <div class="px-4 py-2">
                                        <p class="mb-0 text-sm italic text-gray-600">
                                            "{{ $request->message }}"
                                        </p>
                                    </div>
                                </div>
                            @endif

                            {{-- Disponibilidade (se houver) --}}
                            @if($request->availability)
                                <div class="mb-3 rounded-lg border border-blue-200 bg-blue-50">
                                    <div class="px-4 py-2">
                                        <h6 class="mb-0 font-semibold text-celestial">📅 Disponibilidade Informada</h6>
                                    </div>
                                    <div class="px-4 py-2">
                                        <p class="mb-0 text-sm text-gray-600">
                                            {{ $request->availability }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            {{-- Ações para Solicitações Pendentes --}}
                            @if($request->status === 'pending')
                                <div class="rounded-lg border border-gray-200 bg-[var(--sp-marfim)]">
                                    <div class="px-4 py-3">
                                        <h5 class="mb-0 font-semibold text-azul">🎯 Tomar Decisão</h5>
                                    </div>
                                    <div class="p-4">
                                        <form action="{{ route('group-requests.approve', $request) }}" method="POST" id="approve-form-{{ $request->id }}" class="hidden">
                                            @csrf
                                            <input type="hidden" name="response_message" id="approve-message-{{ $request->id }}">
                                        </form>
                                        
                                        <form action="{{ route('group-requests.reject', $request) }}" method="POST" id="reject-form-{{ $request->id }}" class="hidden">
                                            @csrf
                                            <input type="hidden" name="response_message" id="reject-message-{{ $request->id }}">
                                        </form>

                                        <div class="mb-3">
                                            <label for="response_message_{{ $request->id }}" class="font-semibold">
                                                💌 Mensagem de Resposta (opcional)
                                            </label>
                                            <textarea 
                                                id="response_message_{{ $request->id }}" 
                                                rows="3" 
                                                placeholder="Deixe uma mensagem para o candidato explicando sua decisão..."
                                                class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2"
                                            ></textarea>
                                            <div class="mt-1 text-sm text-gray-600">
                                                💡 Uma mensagem personalizada ajuda o candidato a entender sua decisão.
                                            </div>
                                        </div>
                                        
                                        <div class="flex flex-col gap-3 sm:flex-row">
                                            <button 
                                                type="button"
                                                onclick="approveRequest({{ $request->id }})"
                                                class="rounded-lg bg-green-600 px-5 py-3 font-semibold text-white hover:bg-green-700"
                                            >
                                                ✅ Aprovar Solicitação
                                            </button>
                                            <button 
                                                type="button"
                                                onclick="rejectRequest({{ $request->id }})"
                                                class="rounded-lg bg-red-600 px-5 py-3 font-semibold text-white hover:bg-red-700"
                                            >
                                                ❌ Rejeitar Solicitação
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{-- Informações da Resposta Dada --}}
                                <div class="rounded-lg border p-3" style="background: {{ $request->status === 'approved' ? 'rgba(59, 130, 246, 0.1)' : 'rgba(185, 28, 28, 0.1)' }}; border-color: {{ $request->status === 'approved' ? 'var(--sp-azul-celestial)' : 'var(--sp-vermelho-sangue)' }};">
                                    <div class="px-1 py-2">
                                        <h5 class="mb-0 font-semibold" style="color: {{ $request->status === 'approved' ? 'var(--sp-azul-celestial)' : 'var(--sp-vermelho-sangue)' }};">
                                            @if($request->status === 'approved')
                                                ✅ Solicitação Aprovada
                                            @else
                                                ❌ Solicitação Rejeitada
                                            @endif
                                        </h5>
                                    </div>
                                    <div class="px-1 py-2">
                                        <p class="mb-2 text-sm text-gray-600">
                                            Respondido em {{ ($request->approved_at ?? $request->rejected_at)->format('d/m/Y \à\s H:i') }}
                                        </p>
                                        @if($request->response_message)
                                            <div class="rounded-lg border border-gray-200 bg-white px-4 py-2">
                                                    <p class="mb-0 text-sm">
                                                        <strong>Sua resposta:</strong> {{ $request->response_message }}
                                                    </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="card-paroquia text-center">
                        <div class="py-5">
                            <div class="mb-4" style="font-size: 4rem; color: var(--sp-cinza-pedra);">📥</div>
                            <h3 class="mb-3 text-xl">Nenhuma solicitação encontrada</h3>
                            <p class="mb-4 text-gray-600">
                                Não há solicitações para o seu grupo no momento. Quando alguém solicitar entrada, aparecerá aqui.
                            </p>
                            <a href="{{ \App\Helpers\DashboardHelper::getDashboardRoute(auth()->user()->role) }}" class="inline-flex items-center rounded-lg border border-blue-500 px-5 py-3 font-semibold text-blue-600 hover:bg-blue-50">
                                📊 Voltar ao Dashboard
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- Guidelines Section --}}
        <section class="section-paroquia">
            <div>
                <div class="card-paroquia" style="background: var(--sp-pergaminho); border-left: 4px solid var(--sp-dourado-principal);">
                    <div class="card-header-paroquia">
                        <h3 class="text-azul">💡 Orientações para Coordenadores</h3>
                    </div>
                    <div class="card-body">
                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <h5 class="mb-3 font-semibold text-azul">Ao aprovar:</h5>
                                <ul>
                                    <li class="mb-2">✓ Certifique-se de que o candidato tem disponibilidade</li>
                                    <li class="mb-2">✓ Verifique se entendeu bem a motivação</li>
                                    <li class="mb-2">✓ Deixe uma mensagem acolhedora</li>
                                    <li class="mb-2">✓ Explique os próximos passos</li>
                                </ul>
                            </div>
                            <div>
                                <h5 class="mb-3 font-semibold text-azul">Ao rejeitar:</h5>
                                <ul>
                                    <li class="mb-2">✓ Seja respeitoso e construtivo</li>
                                    <li class="mb-2">✓ Explique os motivos da decisão</li>
                                    <li class="mb-2">✓ Sugira outras formas de participação</li>
                                    <li class="mb-2">✓ Mantenha a porta aberta para o futuro</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- JavaScript para as ações --}}
    <script>
        function approveRequest(requestId) {
            if (confirm('🤝 Tem certeza que deseja APROVAR esta solicitação?\n\nO candidato será notificado e poderá participar do grupo.')) {
                const message = document.getElementById(`response_message_${requestId}`).value;
                document.getElementById(`approve-message-${requestId}`).value = message;
                document.getElementById(`approve-form-${requestId}`).submit();
            }
        }

        function rejectRequest(requestId) {
            if (confirm('❌ Tem certeza que deseja REJEITAR esta solicitação?\n\nO candidato será notificado da decisão.')) {
                const message = document.getElementById(`response_message_${requestId}`).value;
                document.getElementById(`reject-message-${requestId}`).value = message;
                document.getElementById(`reject-form-${requestId}`).submit();
            }
        }
    </script>
@endsection