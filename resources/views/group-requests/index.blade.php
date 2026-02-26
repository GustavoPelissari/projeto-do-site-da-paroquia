@extends('layout')

@section('title', 'Gerenciar Solicitações - Paróquia São Paulo Apóstolo')

@section('content')
    <div class="container py-5">
        {{-- Hero Section --}}
        <section class="section-paroquia">
            <div class="section-header">
                <h1><i class="bi bi-inbox"></i> Gerenciar Solicitações</h1>
                <p class="lead">
                    Analise e responda às solicitações de entrada no seu grupo ou pastoral
                </p>
            </div>
        </section>

        {{-- Alerts --}}
        @if (session('success'))
            <x-alert type="success">
                <i class="bi bi-check-circle"></i> <strong>Sucesso!</strong> {{ session('success') }}
            </x-alert>
        @endif

        @if (session('error'))
            <x-alert type="error">
                <i class="bi bi-exclamation-triangle"></i> <strong>Erro!</strong> {{ session('error') }}
            </x-alert>
        @endif

        {{-- Main Content --}}
        <section class="section-paroquia">
            @forelse($requests as $request)
                <div class="card-paroquia mb-4 status-{{ $request->status }}">
                    
                    {{-- Header --}}
                    <div class="card-header-paroquia">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="d-flex align-items-center mb-2">
                                    <h3 class="h5 mb-0">
                                        <i class="bi bi-person" aria-hidden="true"></i> 
                                        {{ $request->user?->name ?? 'Usuário não encontrado' }}
                                    </h3>
                                    @if($request->user?->email)
                                        <span class="badge bg-secondary ms-3" aria-label="Email do candidato">
                                            {{ $request->user->email }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-muted small" aria-label="Data da solicitação">
                                    <i class="bi bi-calendar" aria-hidden="true"></i>
                                    Solicitado em
                                    <time datetime="{{ $request->created_at?->toISOString() }}">
                                        {{ $request->created_at?->format('d/m/Y \à\s H:i') ?? 'Data não disponível' }}
                                    </time>
                                </p>
                            </div>                                <span class="badge bg-{{ $request->status === 'pending' ? 'warning' : ($request->status === 'approved' ? 'success' : 'danger') }}">
                                    @if($request->status === 'pending')
                                        <i class="bi bi-clock"></i> Aguardando Análise
                                    @elseif($request->status === 'approved')
                                        <i class="bi bi-check-circle"></i> Aprovada
                                    @else
                                        <i class="bi bi-x-circle"></i> Rejeitada
                                    @endif
                                </span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="card-body">
                            
                            {{-- Mensagem do Candidato --}}
                            @if($request->message)
                                <div class="card mb-3 candidate-message">
                                    <div class="card-header py-2">
                                        <h6 class="mb-0 fw-semibold text-brand-vinho">
                                            <i class="bi bi-chat-text" aria-hidden="true"></i> Mensagem do Candidato
                                        </h6>
                                    </div>
                                    <div class="card-body py-2">
                                        <blockquote class="small fst-italic text-muted mb-0">
                                            {{ $request->message }}
                                        </blockquote>
                                    </div>
                                </div>
                            @endif

                            {{-- Disponibilidade (se houver) --}}
                            @if($request->availability)
                                <div class="card mb-3 availability-info">
                                    <div class="card-header py-2">
                                        <h6 class="mb-0 fw-semibold text-primary">
                                            <i class="bi bi-calendar-check" aria-hidden="true"></i> Disponibilidade Informada
                                        </h6>
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
                                <div class="card action-panel">
                                    <div class="card-header">
                                        <h5 class="mb-0 fw-semibold text-primary">
                                            <i class="bi bi-gear" aria-hidden="true"></i> Tomar Decisão
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        {{-- Forms para envio via JS --}}
                                        <form action="{{ route('group-requests.approve', $request) }}" method="POST" 
                                              id="approve-form-{{ $request->id }}" class="d-none" aria-hidden="true">
                                            @csrf
                                            <input type="hidden" name="response_message" id="approve-message-{{ $request->id }}">
                                        </form>
                                        
                                        <form action="{{ route('group-requests.reject', $request) }}" method="POST" 
                                              id="reject-form-{{ $request->id }}" class="d-none" aria-hidden="true">
                                            @csrf
                                            <input type="hidden" name="response_message" id="reject-message-{{ $request->id }}">
                                        </form>

                                        <div class="mb-3">
                                            <label for="response_message_{{ $request->id }}" class="form-label fw-semibold">
                                                <i class="bi bi-envelope" aria-hidden="true"></i> Mensagem de Resposta (opcional)
                                            </label>
                                            <textarea 
                                                id="response_message_{{ $request->id }}" 
                                                rows="3" 
                                                placeholder="Deixe uma mensagem para o candidato explicando sua decisão..."
                                                class="form-control"
                                                aria-describedby="responseHelp_{{ $request->id }}"
                                                maxlength="500"
                                            ></textarea>
                                            <div id="responseHelp_{{ $request->id }}" class="form-text">
                                                <i class="bi bi-lightbulb" aria-hidden="true"></i> 
                                                Uma mensagem personalizada ajuda o candidato a entender sua decisão.
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex gap-3">
                                            <button 
                                                type="button"
                                                data-request-id="{{ $request->id }}"
                                                class="btn btn-success btn-lg approve-btn"
                                                aria-describedby="approveHelp_{{ $request->id }}"
                                            >
                                                <i class="bi bi-check-circle" aria-hidden="true"></i> Aprovar Solicitação
                                            </button>
                                            <button 
                                                type="button"
                                                data-request-id="{{ $request->id }}"
                                                class="btn btn-danger btn-lg reject-btn"
                                                aria-describedby="rejectHelp_{{ $request->id }}"
                                            >
                                                <i class="bi bi-x-circle" aria-hidden="true"></i> Rejeitar Solicitação
                                            </button>
                                        </div>
                                        <div id="approveHelp_{{ $request->id }}" class="visually-hidden">
                                            Aprovar permitirá que o candidato faça parte do grupo
                                        </div>
                                        <div id="rejectHelp_{{ $request->id }}" class="visually-hidden">
                                            Rejeitar negará a entrada do candidato no grupo
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{-- Informações da Resposta Dada --}}
                                <div class="card response-card response-{{ $request->status }}">
                                    <div class="card-header">
                                        <h5 class="mb-0 fw-semibold response-title-{{ $request->status }}">
                                            @if($request->status === 'approved')
                                                <i class="bi bi-check-circle" aria-hidden="true"></i> Solicitação Aprovada
                                            @else
                                                <i class="bi bi-x-circle" aria-hidden="true"></i> Solicitação Rejeitada
                                            @endif
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="small text-muted mb-2">
                                            Respondido em
                                            <time datetime="{{ ($request->approved_at ?? $request->rejected_at)?->toISOString() }}">
                                                {{
                                                    $request->approved_at?->format('d/m/Y \à\s H:i') ??
                                                    $request->rejected_at?->format('d/m/Y \à\s H:i') ??
                                                    'Data não disponível'
                                                }}
                                            </time>
                                        </p>
                                        @if($request->response_message)
                                            <div class="card response-message">
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
                    <div class="card-paroquia text-center empty-state">
                        <div class="card-body py-5">
                            <div class="mb-4 empty-icon" aria-hidden="true">
                                <i class="bi bi-inbox"></i>
                            </div>
                            <h3 class="h4 mb-3">Nenhuma solicitação encontrada</h3>
                            <p class="text-muted mb-4">
                                Não há solicitações para o seu grupo no momento. Quando alguém solicitar entrada, aparecerá aqui.
                            </p>
                            <a href="{{ \App\Helpers\DashboardHelper::getDashboardRoute(auth()->user()->role) }}" 
                               class="btn btn-outline-primary btn-lg">
                                <i class="bi bi-speedometer2" aria-hidden="true"></i> Voltar ao Dashboard
                            </a>
                        </div>
                    </div>
                @endforelse
        </section>

        {{-- Guidelines Section --}}
        <section class="section-paroquia">
            <div class="card-paroquia guidelines-card">
                <div class="card-header-paroquia">
                    <h3 class="text-brand-vinho">
                        <i class="bi bi-lightbulb" aria-hidden="true"></i> Orientações para Coordenadores
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="fw-semibold mb-3 text-success">
                                <i class="bi bi-check-square" aria-hidden="true"></i> Ao aprovar:
                            </h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bi bi-check text-success" aria-hidden="true"></i> 
                                    Certifique-se de que o candidato tem disponibilidade
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check text-success" aria-hidden="true"></i> 
                                    Verifique se entendeu bem a motivação
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check text-success" aria-hidden="true"></i> 
                                    Deixe uma mensagem acolhedora
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check text-success" aria-hidden="true"></i> 
                                    Explique os próximos passos
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-semibold mb-3 text-warning">
                                <i class="bi bi-exclamation-triangle" aria-hidden="true"></i> Ao rejeitar:
                            </h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bi bi-check text-warning" aria-hidden="true"></i> 
                                    Seja respeitoso e construtivo
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check text-warning" aria-hidden="true"></i> 
                                    Explique os motivos da decisão
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check text-warning" aria-hidden="true"></i> 
                                    Sugira outras formas de participação
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check text-warning" aria-hidden="true"></i> 
                                    Mantenha a porta aberta para o futuro
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- JavaScript para as ações --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event listeners para botões de aprovar
            document.querySelectorAll('.approve-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const requestId = this.getAttribute('data-request-id');
                    approveRequest(requestId);
                });
            });

            // Event listeners para botões de rejeitar
            document.querySelectorAll('.reject-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const requestId = this.getAttribute('data-request-id');
                    rejectRequest(requestId);
                });
            });
        });

        // Função para aprovar solicitação
        function approveRequest(requestId) {
            if (!confirm('🤝 Tem certeza que deseja APROVAR esta solicitação?\n\nO candidato será notificado e poderá participar do grupo.')) {
                return;
            }

            const textarea = document.getElementById(`response_message_${requestId}`);
            const message = textarea ? textarea.value.trim() : '';

            // Validação básica
            if (message.length > 500) {
                alert('A mensagem de resposta deve ter no máximo 500 caracteres.');
                textarea.focus();
                return;
            }

            const hidden = document.getElementById(`approve-message-${requestId}`);
            if (hidden) {
                hidden.value = message;
            }

            const form = document.getElementById(`approve-form-${requestId}`);
            if (form) {
                disableActionButtons(form);
                form.submit();
            }
        }

        // Função para rejeitar solicitação
        function rejectRequest(requestId) {
            if (!confirm('❌ Tem certeza que deseja REJEITAR esta solicitação?\n\nO candidato será notificado da decisão.')) {
                return;
            }

            const textarea = document.getElementById(`response_message_${requestId}`);
            const message = textarea ? textarea.value.trim() : '';

            // Validação básica
            if (message.length > 500) {
                alert('A mensagem de resposta deve ter no máximo 500 caracteres.');
                textarea.focus();
                return;
            }

            const hidden = document.getElementById(`reject-message-${requestId}`);
            if (hidden) {
                hidden.value = message;
            }

            const form = document.getElementById(`reject-form-${requestId}`);
            if (form) {
                disableActionButtons(form);
                form.submit();
            }
        }

        // Função para desabilitar botões e prevenir cliques múltiplos
        function disableActionButtons(formElement) {
            const card = formElement.closest('.card') || document;
            const buttons = card.querySelectorAll('button[data-request-id]');
            buttons.forEach(function(btn) {
                btn.disabled = true;
                btn.setAttribute('aria-disabled', 'true');
                
                // Adiciona spinner visual
                const icon = btn.querySelector('i');
                if (icon) {
                    icon.className = 'bi bi-arrow-repeat spin';
                }
                
                // Adiciona texto de loading
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-arrow-repeat spin" aria-hidden="true"></i> Processando...';
            });
        }
    </script>

    {{-- CSS adicional para os estilos customizados --}}
    <style>
        .status-pending {
            border-left: 4px solid #FFD66B;
        }
        
        .status-approved {
            border-left: 4px solid #28a745;
        }
        
        .status-rejected {
            border-left: 4px solid #dc3545;
        }
        
        .candidate-message {
            background: var(--bg-light, #f8f9fa);
            border: 1px solid rgba(139, 30, 63, 0.2);
        }
        
        .availability-info {
            background: var(--bg-light, #f8f9fa);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }
        
        .action-panel {
            background: var(--bg-light, #f8f9fa);
            border: 1px solid rgba(107, 114, 128, 0.2);
        }
        
        .response-card.response-approved {
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid #28a745;
        }
        
        .response-card.response-rejected {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid #dc3545;
        }
        
        .response-title-approved {
            color: #28a745;
        }
        
        .response-title-rejected {
            color: #dc3545;
        }
        
        .response-message {
            background: white;
            border: 1px solid rgba(107, 114, 128, 0.2);
        }
        
        .empty-state .empty-icon {
            font-size: 4rem;
            color: var(--gray-400, #9ca3af);
        }
        
        .guidelines-card {
            background: var(--bg-light, #f8f9fa);
            border-left: 4px solid var(--brand-vinho, #8b1e3f);
        }
        
        .spin {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        @media (max-width: 768px) {
            .d-flex.gap-3 {
                flex-direction: column;
            }
            
            .d-flex.gap-3 > * {
                margin-bottom: 0.5rem;
            }
        }
    </style>
@endsection
