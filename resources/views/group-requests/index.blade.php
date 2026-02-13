@extends('layouts.public')

@section('title', 'Gerenciar Solicitações - Paróquia São Paulo Apóstolo')

@section('content')
    <div class="container py-5">
        {{-- Hero Section --}}
        <section class="section-paroquia">
            <div class="section-header">
                <h1> Gerenciar Solicitações</h1>
                <p class="lead">
                    Analise e responda às solicitações de entrada no seu grupo ou pastoral
                </p>
            </div>
        </section>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="alert alert-success d-flex align-items-center mb-4">
                <div class="me-3"></div>
                <div>
                    <strong>Sucesso!</strong> {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger d-flex align-items-center mb-4">
                <div class="me-3"></div>
                <div>
                    <strong>Erro!</strong> {{ session('error') }}
                </div>
            </div>
        @endif

        {{-- Main Content --}}
        <section class="section-paroquia">
            <div class="container">
                @forelse($requests as $request)
                    <div class="card-paroquia mb-4" style="border-left: 4px solid {{ $request->status === 'pending' ? 'var(--sp-dourado-principal)' : ($request->status === 'approved' ? 'var(--sp-azul-celestial)' : 'var(--sp-vermelho-sangue)') }};">
                        
                        {{-- Header --}}
                        <div class="card-header-paroquia">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="d-flex align-items-center mb-2">
                                        <h3 class="h5 mb-0"> {{ $request->user->name }}</h3>
                                        <span class="badge bg-secondary ms-3">
                                            {{ $request->user->email }}
                                        </span>
                                    </div>
                                    <p class="text-muted small">
                                         Solicitado em {{ $request->created_at->format('d/m/Y \à\s H:i') }}
                                    </p>
                                </div>
                                
                                <span class="badge bg-{{ $request->status === 'pending' ? 'warning' : ($request->status === 'approved' ? 'success' : 'danger') }}">
                                    @if($request->status === 'pending')
                                        ⏳ Aguardando Análise
                                    @elseif($request->status === 'approved')
                                         Aprovada
                                    @else
                                         Rejeitada
                                    @endif
                                </span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="card-body">
                            
                            {{-- Mensagem do Candidato --}}
                            @if($request->message)
                                <div class="card mb-3" style="background: var(--sp-pergaminho); border: 1px solid rgba(200, 134, 13, 0.2);">
                                    <div class="card-header py-2">
                                        <h6 class="mb-0 fw-semibold text-dourado"> Mensagem do Candidato</h6>
                                    </div>
                                    <div class="card-body py-2">
                                        <p class="small fst-italic text-muted mb-0">
                                            "{{ $request->message }}"
                                        </p>
                                    </div>
                                </div>
                            @endif

                            {{-- Disponibilidade (se houver) --}}
                            @if($request->availability)
                                <div class="card mb-3" style="background: var(--sp-marfim); border: 1px solid rgba(59, 130, 246, 0.2);">
                                    <div class="card-header py-2">
                                        <h6 class="mb-0 fw-semibold text-celestial"> Disponibilidade Informada</h6>
                                    </div>
                                    <div class="card-body py-2">
                                        <p class="small text-muted mb-0">
                                            {{ $request->availability }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            {{-- Ações para Solicitações Pendentes --}}
                            @if($request->status === 'pending')
                                <div class="card" style="background: var(--sp-marfim); border: 1px solid rgba(107, 114, 128, 0.2);">
                                    <div class="card-header">
                                        <h5 class="mb-0 fw-semibold text-azul"> Tomar Decisão</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('group-requests.approve', $request) }}" method="POST" id="approve-form-{{ $request->id }}" class="d-none">
                                            @csrf
                                            <input type="hidden" name="response_message" id="approve-message-{{ $request->id }}">
                                        </form>
                                        
                                        <form action="{{ route('group-requests.reject', $request) }}" method="POST" id="reject-form-{{ $request->id }}" class="d-none">
                                            @csrf
                                            <input type="hidden" name="response_message" id="reject-message-{{ $request->id }}">
                                        </form>

                                        <div class="mb-3">
                                            <label for="response_message_{{ $request->id }}" class="form-label fw-semibold">
                                                 Mensagem de Resposta (opcional)
                                            </label>
                                            <textarea 
                                                id="response_message_{{ $request->id }}" 
                                                rows="3" 
                                                placeholder="Deixe uma mensagem para o candidato explicando sua decisão..."
                                                class="form-control"
                                            ></textarea>
                                            <div class="form-text">
                                                 Uma mensagem personalizada ajuda o candidato a entender sua decisão.
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex gap-3">
                                            <button 
                                                type="button"
                                                onclick="approveRequest({{ $request->id }})"
                                                class="btn btn-success btn-lg"
                                            >
                                                 Aprovar Solicitação
                                            </button>
                                            <button 
                                                type="button"
                                                onclick="rejectRequest({{ $request->id }})"
                                                class="btn btn-danger btn-lg"
                                            >
                                                 Rejeitar Solicitação
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{-- Informações da Resposta Dada --}}
                                <div class="card" style="background: {{ $request->status === 'approved' ? 'rgba(59, 130, 246, 0.1)' : 'rgba(185, 28, 28, 0.1)' }}; border: 1px solid {{ $request->status === 'approved' ? 'var(--sp-azul-celestial)' : 'var(--sp-vermelho-sangue)' }};">
                                    <div class="card-header">
                                        <h5 class="mb-0 fw-semibold" style="color: {{ $request->status === 'approved' ? 'var(--sp-azul-celestial)' : 'var(--sp-vermelho-sangue)' }};">
                                            @if($request->status === 'approved')
                                                 Solicitação Aprovada
                                            @else
                                                 Solicitação Rejeitada
                                            @endif
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="small text-muted mb-2">
                                            Respondido em {{ ($request->approved_at ?? $request->rejected_at)->format('d/m/Y \à\s H:i') }}
                                        </p>
                                        @if($request->response_message)
                                            <div class="card" style="background: white; border: 1px solid rgba(107, 114, 128, 0.2);">
                                                <div class="card-body py-2">
                                                    <p class="small mb-0">
                                                        <strong>Sua resposta:</strong> {{ $request->response_message }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="card-paroquia text-center">
                        <div class="card-body py-5">
                            <div class="mb-4" style="font-size: 4rem; color: var(--sp-cinza-pedra);"></div>
                            <h3 class="h4 mb-3">Nenhuma solicitação encontrada</h3>
                            <p class="text-muted mb-4">
                                Não há solicitações para o seu grupo no momento. Quando alguém solicitar entrada, aparecerá aqui.
                            </p>
                            <a href="{{ \App\Helpers\DashboardHelper::getDashboardRoute(auth()->user()->role) }}" class="btn btn-outline-primary btn-lg">
                                 Voltar ao Painel
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- Guidelines Section --}}
        <section class="section-paroquia">
            <div class="container">
                <div class="card-paroquia" style="background: var(--sp-pergaminho); border-left: 4px solid var(--sp-dourado-principal);">
                    <div class="card-header-paroquia">
                        <h3 class="text-azul"> Orientações para Coordenadores</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="fw-semibold mb-3 text-azul">Ao aprovar:</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"> Certifique-se de que o candidato tem disponibilidade</li>
                                    <li class="mb-2"> Verifique se entendeu bem a motivação</li>
                                    <li class="mb-2"> Deixe uma mensagem acolhedora</li>
                                    <li class="mb-2"> Explique os próximos passos</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-semibold mb-3 text-azul">Ao rejeitar:</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"> Seja respeitoso e construtivo</li>
                                    <li class="mb-2"> Explique os motivos da decisão</li>
                                    <li class="mb-2"> Sugira outras formas de participação</li>
                                    <li class="mb-2"> Mantenha a porta aberta para o futuro</li>
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
            if (confirm(' Tem certeza que deseja APROVAR esta solicitação?\n\nO candidato será notificado e poderá participar do grupo.')) {
                const message = document.getElementById(`response_message_${requestId}`).value;
                document.getElementById(`approve-message-${requestId}`).value = message;
                document.getElementById(`approve-form-${requestId}`).submit();
            }
        }

        function rejectRequest(requestId) {
            if (confirm(' Tem certeza que deseja REJEITAR esta solicitação?\n\nO candidato será notificado da decisão.')) {
                const message = document.getElementById(`response_message_${requestId}`).value;
                document.getElementById(`reject-message-${requestId}`).value = message;
                document.getElementById(`reject-form-${requestId}`).submit();
            }
        }
    </script>
@endsection