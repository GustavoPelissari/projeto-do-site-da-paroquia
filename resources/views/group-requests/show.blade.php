@extends('layouts.app')

@section('title', 'Detalhes da Solicitação - Paróquia São Paulo Apóstolo')

@section('content')
    <div class="sp-container sp-py-large">
        {{-- Hero Section --}}
        <section class="sp-hero">
            <div class="sp-hero-content">
                <div class="sp-flex sp-items-center sp-justify-between sp-mb-4">
                    <h1 class="sp-hero-title"> Detalhes da Solicitação</h1>
                    <a href="{{ route('group-requests.index') }}" class="sp-btn sp-btn-outline">
                        ← Voltar
                    </a>
                </div>
                <p class="sp-hero-subtitle">
                    Visualização completa da solicitação de entrada no grupo
                </p>
            </div>
        </section>

        {{-- Status da Solicitação --}}
        <section class="sp-section">
            <div class="sp-content-wrapper">
                <div class="sp-card" style="border-left: 4px solid {{ $request->status === 'pending' ? 'var(--sp-gold)' : ($request->status === 'approved' ? 'var(--sp-teal)' : 'var(--sp-red)') }};">
                    <div class="sp-card-header">
                        <div class="sp-flex sp-justify-between sp-items-center">
                            <h2 class="sp-card-title"> Status da Solicitação</h2>
                            <div class="sp-badge sp-badge-lg sp-badge-{{ $request->status === 'pending' ? 'warning' : ($request->status === 'approved' ? 'success' : 'error') }}">
                                @if($request->status === 'pending')
                                    ⏳ Aguardando Análise
                                @elseif($request->status === 'approved')
                                     Aprovada
                                @else
                                     Rejeitada
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="sp-card-content">
                        <div class="sp-grid sp-grid-3">
                            <div class="sp-stat">
                                <div class="sp-stat-icon"></div>
                                <div class="sp-stat-content">
                                    <div class="sp-stat-label">Data da Solicitação</div>
                                    <div class="sp-stat-value">{{ $request->created_at->format('d/m/Y') }}</div>
                                    <div class="sp-stat-description">{{ $request->created_at->format('H:i') }}</div>
                                </div>
                            </div>
                            
                            @if($request->status !== 'pending')
                                <div class="sp-stat">
                                    <div class="sp-stat-icon"></div>
                                    <div class="sp-stat-content">
                                        <div class="sp-stat-label">Data da Resposta</div>
                                        <div class="sp-stat-value">{{ ($request->approved_at ?? $request->rejected_at)->format('d/m/Y') }}</div>
                                        <div class="sp-stat-description">{{ ($request->approved_at ?? $request->rejected_at)->format('H:i') }}</div>
                                    </div>
                                </div>
                                
                                <div class="sp-stat">
                                    <div class="sp-stat-icon"></div>
                                    <div class="sp-stat-content">
                                        <div class="sp-stat-label">Tempo de Resposta</div>
                                        <div class="sp-stat-value">{{ $request->created_at->diffInDays($request->approved_at ?? $request->rejected_at) }}</div>
                                        <div class="sp-stat-description">dias</div>
                                    </div>
                                </div>
                            @else
                                <div class="sp-stat">
                                    <div class="sp-stat-icon">⏰</div>
                                    <div class="sp-stat-content">
                                        <div class="sp-stat-label">Tempo em Análise</div>
                                        <div class="sp-stat-value">{{ $request->created_at->diffInDays(now()) }}</div>
                                        <div class="sp-stat-description">dias</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Informações do Candidato --}}
        <section class="sp-section">
            <div class="sp-content-wrapper">
                <div class="sp-grid sp-grid-2">
                    
                    {{-- Dados Pessoais --}}
                    <div class="sp-card">
                        <div class="sp-card-header">
                            <h3 class="sp-card-title"> Dados do Candidato</h3>
                        </div>
                        <div class="sp-card-content">
                            <div class="sp-profile">
                                <div class="sp-profile-avatar">
                                    <div class="sp-avatar sp-avatar-xl">
                                        {{ strtoupper(substr($request->user->name, 0, 2)) }}
                                    </div>
                                </div>
                                <div class="sp-profile-info">
                                    <h4 class="sp-profile-name">{{ $request->user->name }}</h4>
                                    <p class="sp-profile-email"> {{ $request->user->email }}</p>
                                    @if($request->user->phone)
                                        <p class="sp-profile-phone"> {{ $request->user->phone }}</p>
                                    @endif
                                    <div class="sp-badge sp-badge-secondary sp-mt-2">
                                        Membro desde {{ $request->user->created_at->format('m/Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Informações do Grupo --}}
                    <div class="sp-card">
                        <div class="sp-card-header">
                            <h3 class="sp-card-title"> Grupo de Destino</h3>
                        </div>
                        <div class="sp-card-content">
                            <div class="sp-group-info">
                                <h4 class="sp-title-lg sp-mb-2">{{ $request->group->name }}</h4>
                                @if($request->group->description)
                                    <p class="sp-text-muted sp-mb-4">{{ $request->group->description }}</p>
                                @endif
                                
                                <div class="sp-info-grid">
                                    @if($request->group->meeting_day)
                                        <div class="sp-info-item">
                                            <span class="sp-info-label"> Dia da Reunião:</span>
                                            <span class="sp-info-value">{{ $request->group->meeting_day }}</span>
                                        </div>
                                    @endif
                                    
                                    @if($request->group->meeting_time)
                                        <div class="sp-info-item">
                                            <span class="sp-info-label">⏰ Horário:</span>
                                            <span class="sp-info-value">{{ $request->group->meeting_time }}</span>
                                        </div>
                                    @endif
                                    
                                    @if($request->group->location)
                                        <div class="sp-info-item">
                                            <span class="sp-info-label"> Local:</span>
                                            <span class="sp-info-value">{{ $request->group->location }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Mensagem do Candidato --}}
        @if($request->message)
            <section class="sp-section">
                <div class="sp-content-wrapper">
                    <div class="sp-card" style="background: var(--sp-ivory); border-left: 4px solid var(--sp-gold);">
                        <div class="sp-card-header">
                            <h3 class="sp-card-title"> Mensagem do Candidato</h3>
                        </div>
                        <div class="sp-card-content">
                            <div class="sp-quote">
                                <div class="sp-quote-icon">"</div>
                                <div class="sp-quote-content">
                                    <p class="sp-quote-text">{{ $request->message }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Disponibilidade --}}
        @if($request->availability)
            <section class="sp-section">
                <div class="sp-content-wrapper">
                    <div class="sp-card" style="background: var(--sp-cream); border-left: 4px solid var(--sp-teal);">
                        <div class="sp-card-header">
                            <h3 class="sp-card-title"> Disponibilidade Informada</h3>
                        </div>
                        <div class="sp-card-content">
                            <p class="sp-text-lg">{{ $request->availability }}</p>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Resposta do Coordenador --}}
        @if($request->status !== 'pending' && $request->response_message)
            <section class="sp-section">
                <div class="sp-content-wrapper">
                    <div class="sp-card" style="background: {{ $request->status === 'approved' ? 'var(--sp-teal-50)' : 'var(--sp-red-50)' }}; border-left: 4px solid {{ $request->status === 'approved' ? 'var(--sp-teal)' : 'var(--sp-red)' }};">
                        <div class="sp-card-header">
                            <h3 class="sp-card-title" style="color: {{ $request->status === 'approved' ? 'var(--sp-teal)' : 'var(--sp-red)' }};">
                                @if($request->status === 'approved')
                                     Resposta de Aprovação
                                @else
                                     Resposta de Rejeição
                                @endif
                            </h3>
                        </div>
                        <div class="sp-card-content">
                            <div class="sp-response">
                                <div class="sp-response-meta">
                                    <div class="sp-response-avatar">
                                        <div class="sp-avatar">CO</div>
                                    </div>
                                    <div class="sp-response-info">
                                        <div class="sp-response-author">Coordenador do Grupo</div>
                                        <div class="sp-response-date">{{ ($request->approved_at ?? $request->rejected_at)->format('d/m/Y \à\s H:i') }}</div>
                                    </div>
                                </div>
                                <div class="sp-response-content">
                                    <p>{{ $request->response_message }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Ações Administrativas --}}
        @if($request->status === 'pending')
            <section class="sp-section">
                <div class="sp-content-wrapper">
                    <div class="sp-card" style="background: var(--sp-gray-50); border-left: 4px solid var(--sp-red);">
                        <div class="sp-card-header">
                            <h3 class="sp-card-title" style="color: var(--sp-red);"> Ações Disponíveis</h3>
                        </div>
                        <div class="sp-card-content">
                            <div class="sp-alert sp-alert-info sp-mb-6">
                                <div class="sp-alert-icon"></div>
                                <div class="sp-alert-content">
                                    <strong>Orientação:</strong> Analise cuidadosamente as informações do candidato antes de tomar uma decisão. 
                                    Uma resposta personalizada ajuda a criar um ambiente acolhedor.
                                </div>
                            </div>

                            <form action="{{ route('group-requests.approve', $request) }}" method="POST" id="approve-form" class="sp-hidden">
                                @csrf
                                <input type="hidden" name="response_message" id="approve-message">
                            </form>
                            
                            <form action="{{ route('group-requests.reject', $request) }}" method="POST" id="reject-form" class="sp-hidden">
                                @csrf
                                <input type="hidden" name="response_message" id="reject-message">
                            </form>

                            <div class="sp-form-group">
                                <label for="response_message" class="sp-label">
                                     Mensagem de Resposta
                                </label>
                                <textarea 
                                    id="response_message" 
                                    rows="4" 
                                    placeholder="Deixe uma mensagem personalizada para o candidato..."
                                    class="sp-textarea"
                                ></textarea>
                                <div class="sp-form-help">
                                     Uma mensagem calorosa faz toda a diferença na experiência do candidato.
                                </div>
                            </div>
                            
                            <div class="sp-form-actions">
                                <button 
                                    type="button"
                                    onclick="approveRequest()"
                                    class="sp-btn sp-btn-success sp-btn-lg"
                                >
                                     Aprovar Solicitação
                                </button>
                                <button 
                                    type="button"
                                    onclick="rejectRequest()"
                                    class="sp-btn sp-btn-error sp-btn-lg"
                                >
                                     Rejeitar Solicitação
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Timeline de Histórico --}}
        <section class="sp-section">
            <div class="sp-content-wrapper">
                <div class="sp-card">
                    <div class="sp-card-header">
                        <h3 class="sp-card-title"> Histórico da Solicitação</h3>
                    </div>
                    <div class="sp-card-content">
                        <div class="sp-timeline">
                            {{-- Solicitação Criada --}}
                            <div class="sp-timeline-item sp-timeline-item-active">
                                <div class="sp-timeline-marker sp-timeline-marker-success"></div>
                                <div class="sp-timeline-content">
                                    <h4 class="sp-timeline-title">Solicitação Enviada</h4>
                                    <p class="sp-timeline-description">
                                        {{ $request->user->name }} enviou a solicitação para entrar no grupo "{{ $request->group->name }}"
                                    </p>
                                    <div class="sp-timeline-meta">{{ $request->created_at->format('d/m/Y \à\s H:i') }}</div>
                                </div>
                            </div>

                            @if($request->status === 'approved')
                                {{-- Solicitação Aprovada --}}
                                <div class="sp-timeline-item sp-timeline-item-active">
                                    <div class="sp-timeline-marker sp-timeline-marker-success"></div>
                                    <div class="sp-timeline-content">
                                        <h4 class="sp-timeline-title">Solicitação Aprovada</h4>
                                        <p class="sp-timeline-description">
                                            O coordenador aprovou a entrada no grupo
                                            @if($request->response_message)
                                                e deixou uma mensagem de boas-vindas
                                            @endif
                                        </p>
                                        <div class="sp-timeline-meta">{{ $request->approved_at->format('d/m/Y \à\s H:i') }}</div>
                                    </div>
                                </div>
                            @elseif($request->status === 'rejected')
                                {{-- Solicitação Rejeitada --}}
                                <div class="sp-timeline-item sp-timeline-item-active">
                                    <div class="sp-timeline-marker sp-timeline-marker-error"></div>
                                    <div class="sp-timeline-content">
                                        <h4 class="sp-timeline-title">Solicitação Rejeitada</h4>
                                        <p class="sp-timeline-description">
                                            O coordenador não aprovou a entrada no grupo
                                            @if($request->response_message)
                                                e deixou uma explicação
                                            @endif
                                        </p>
                                        <div class="sp-timeline-meta">{{ $request->rejected_at->format('d/m/Y \à\s H:i') }}</div>
                                    </div>
                                </div>
                            @else
                                {{-- Aguardando Resposta --}}
                                <div class="sp-timeline-item">
                                    <div class="sp-timeline-marker sp-timeline-marker-warning">⏳</div>
                                    <div class="sp-timeline-content">
                                        <h4 class="sp-timeline-title">Aguardando Análise</h4>
                                        <p class="sp-timeline-description">
                                            A solicitação está sendo analisada pelo coordenador do grupo
                                        </p>
                                        <div class="sp-timeline-meta">Em andamento</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- JavaScript para as ações --}}
    @if($request->status === 'pending')
        <script>
            function approveRequest() {
                if (confirm(' Tem certeza que deseja APROVAR esta solicitação?\n\nO candidato será notificado e poderá participar do grupo.')) {
                    const message = document.getElementById('response_message').value;
                    document.getElementById('approve-message').value = message;
                    document.getElementById('approve-form').submit();
                }
            }

            function rejectRequest() {
                if (confirm(' Tem certeza que deseja REJEITAR esta solicitação?\n\nO candidato será notificado da decisão.')) {
                    const message = document.getElementById('response_message').value;
                    document.getElementById('reject-message').value = message;
                    document.getElementById('reject-form').submit();
                }
            }
        </script>
    @endif

    {{-- Custom Styles para esta página --}}
    <style>
        .sp-profile {
            display: flex;
            align-items: center;
            gap: var(--space-4);
        }

        .sp-profile-avatar .sp-avatar {
            width: 4rem;
            height: 4rem;
            font-size: 1.25rem;
        }

        .sp-profile-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--sp-red-dark);
            margin: 0 0 var(--space-1) 0;
        }

        .sp-profile-email, .sp-profile-phone {
            color: var(--sp-gray);
            margin: var(--space-1) 0;
        }

        .sp-info-grid {
            display: grid;
            gap: var(--space-2);
        }

        .sp-info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: var(--space-2);
            background: var(--sp-white);
            border-radius: var(--border-radius);
            border: 1px solid var(--sp-gray-200);
        }

        .sp-info-label {
            font-weight: 500;
            color: var(--sp-gray);
        }

        .sp-info-value {
            font-weight: 600;
            color: var(--sp-red-dark);
        }

        .sp-quote {
            position: relative;
            padding: var(--space-6) var(--space-4);
        }

        .sp-quote-icon {
            position: absolute;
            top: 0;
            left: 0;
            font-size: 3rem;
            color: var(--sp-gold);
            line-height: 1;
        }

        .sp-quote-text {
            font-size: 1.125rem;
            font-style: italic;
            color: var(--sp-gray-dark);
            margin: 0;
            padding-left: var(--space-8);
        }

        .sp-response {
            display: flex;
            flex-direction: column;
            gap: var(--space-4);
        }

        .sp-response-meta {
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .sp-response-author {
            font-weight: 600;
            color: var(--sp-red-dark);
        }

        .sp-response-date {
            font-size: 0.875rem;
            color: var(--sp-gray);
        }

        .sp-response-content {
            background: var(--sp-white);
            padding: var(--space-4);
            border-radius: var(--border-radius);
            border-left: 3px solid var(--sp-gold);
        }

        .sp-stat {
            text-align: center;
            padding: var(--space-4);
            background: var(--sp-white);
            border-radius: var(--border-radius);
            border: 1px solid var(--sp-gray-200);
        }

        .sp-stat-icon {
            font-size: 2rem;
            margin-bottom: var(--space-2);
        }

        .sp-stat-label {
            font-size: 0.875rem;
            color: var(--sp-gray);
            margin-bottom: var(--space-1);
        }

        .sp-stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--sp-red-dark);
            margin-bottom: var(--space-1);
        }

        .sp-stat-description {
            font-size: 0.75rem;
            color: var(--sp-gray-light);
        }

        @media (max-width: 768px) {
            .sp-profile {
                flex-direction: column;
                text-align: center;
            }

            .sp-grid-3 {
                grid-template-columns: 1fr;
            }

            .sp-info-item {
                flex-direction: column;
                text-align: center;
                gap: var(--space-1);
            }
        }
    </style>
@endsection