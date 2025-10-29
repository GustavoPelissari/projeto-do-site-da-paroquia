@extends('layouts.app')

@section('title', 'Solicitar Entrada em Grupo - Paróquia São Paulo Apóstolo')

@section('content')
    <div class="sp-container sp-py-large">
        {{-- Hero Section --}}
        <section class="sp-hero">
            <div class="sp-hero-content">
                <h1 class="sp-hero-title">🙏 Participar da Nossa Comunidade</h1>
                <p class="sp-hero-subtitle">
                    Envie uma solicitação para se juntar a um dos nossos grupos e pastorais
                </p>
            </div>
        </section>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="sp-alert sp-alert-success sp-mb-6">
                <div class="sp-alert-icon">✅</div>
                <div class="sp-alert-content">
                    <strong>Sucesso!</strong> {{ session('success') }}
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="sp-alert sp-alert-error sp-mb-6">
                <div class="sp-alert-icon">❌</div>
                <div class="sp-alert-content">
                    <strong>Atenção!</strong> Corrija os erros abaixo:
                    <ul class="sp-list sp-mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Main Content --}}
        <section class="sp-section">
            <div class="sp-content-wrapper">
                <div class="sp-grid sp-grid-2" style="gap: var(--space-8); align-items: start;">
                    
                    {{-- Formulário --}}
                    <div class="sp-card">
                        <div class="sp-card-header">
                            <h2 class="sp-card-title">📝 Formulário de Solicitação</h2>
                        </div>
                        
                        <form action="{{ route('group-requests.store') }}" method="POST" class="sp-card-content">
                            @csrf
                            
                            {{-- Grupo Desejado --}}
                            <div class="sp-form-group">
                                <label for="group_id" class="sp-label">
                                    🏛️ Grupo Desejado <span class="sp-text-error">*</span>
                                </label>
                                <select id="group_id" name="group_id" required class="sp-select">
                                    <option value="">Selecione um grupo...</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                                            {{ $group->name }}
                                            @if($group->description)
                                                - {{ Str::limit($group->description, 50) }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('group_id')
                                    <div class="sp-form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Mensagem --}}
                            <div class="sp-form-group">
                                <label for="message" class="sp-label">
                                    💬 Mensagem <span class="sp-text-error">*</span>
                                </label>
                                <textarea 
                                    id="message" 
                                    name="message" 
                                    rows="4" 
                                    required
                                    placeholder="Explique por que deseja participar deste grupo e como pode contribuir para a nossa missão..."
                                    class="sp-textarea"
                                >{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="sp-form-error">{{ $message }}</div>
                                @enderror
                                <div class="sp-form-help">
                                    💡 Mínimo de 10 caracteres. Seja claro sobre suas motivações e como deseja servir.
                                </div>
                            </div>

                            {{-- Disponibilidade --}}
                            <div class="sp-form-group">
                                <label for="availability" class="sp-label">
                                    📅 Disponibilidade
                                </label>
                                <textarea 
                                    id="availability" 
                                    name="availability" 
                                    rows="3" 
                                    placeholder="Descreva sua disponibilidade: dias da semana, horários preferenciais, compromissos..."
                                    class="sp-textarea"
                                >{{ old('availability') }}</textarea>
                                @error('availability')
                                    <div class="sp-form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Botões --}}
                            <div class="sp-form-actions">
                                <a href="{{ route('groups') }}" class="sp-btn sp-btn-outline">
                                    ← Voltar aos Grupos
                                </a>
                                <button type="submit" class="sp-btn sp-btn-gold sp-btn-lg">
                                    🚀 Enviar Solicitação
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Informações dos Grupos --}}
                    <div class="sp-card">
                        <div class="sp-card-header">
                            <h3 class="sp-card-title">🏛️ Grupos Disponíveis</h3>
                        </div>
                        <div class="sp-card-content">
                            @forelse($groups as $group)
                                <div class="sp-card sp-mb-4" style="border: 1px solid var(--sp-gray-200);">
                                    <div class="sp-card-content" style="padding: var(--space-4);">
                                        <h4 class="sp-text-lg sp-font-semibold sp-mb-2" style="color: var(--sp-red);">
                                            {{ $group->name }}
                                        </h4>
                                        
                                        @if($group->description)
                                            <p class="sp-text-sm sp-text-muted sp-mb-3">
                                                {{ $group->description }}
                                            </p>
                                        @endif

                                        @if($group->coordinator_name)
                                            <div class="sp-flex sp-items-center sp-text-xs sp-text-muted">
                                                <span class="sp-icon">👤</span>
                                                <span>Coordenador: {{ $group->coordinator_name }}</span>
                                            </div>
                                        @endif

                                        @if($group->meeting_info)
                                            <div class="sp-flex sp-items-center sp-text-xs sp-text-muted sp-mt-1">
                                                <span class="sp-icon">📅</span>
                                                <span>{{ $group->meeting_info }}</span>
                                            </div>
                                        @endif

                                        <div class="sp-badge sp-badge-{{ $group->category }}" style="margin-top: var(--space-2);">
                                            {{ $group->getCategoryName() }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="sp-text-center sp-py-8">
                                    <div class="sp-icon-large sp-mb-4" style="color: var(--sp-gray-light);">🏛️</div>
                                    <p class="sp-text-muted">Nenhum grupo disponível no momento.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Seção de Orientações --}}
        <section class="sp-section">
            <div class="sp-content-wrapper">
                <div class="sp-card" style="background: var(--sp-ivory); border-left: 4px solid var(--sp-gold);">
                    <div class="sp-card-header">
                        <h3 class="sp-card-title" style="color: var(--sp-red);">💡 Orientações Importantes</h3>
                    </div>
                    <div class="sp-card-content">
                        <div class="sp-grid sp-grid-2">
                            <div>
                                <h4 class="sp-font-semibold sp-mb-2" style="color: var(--sp-red-dark);">Antes de solicitar:</h4>
                                <ul class="sp-list">
                                    <li>Leia atentamente a descrição de cada grupo</li>
                                    <li>Considere sua disponibilidade real</li>
                                    <li>Pense em como pode contribuir</li>
                                    <li>Seja sincero em sua motivação</li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="sp-font-semibold sp-mb-2" style="color: var(--sp-red-dark);">Após enviar:</h4>
                                <ul class="sp-list">
                                    <li>Sua solicitação será analisada pelo coordenador</li>
                                    <li>Você receberá uma resposta em até 7 dias</li>
                                    <li>Pode acompanhar o status em "Minhas Solicitações"</li>
                                    <li>Em caso de dúvidas, procure o coordenador</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Call to Action --}}
        <section class="sp-section">
            <div class="sp-content-wrapper sp-text-center">
                <div class="sp-cta">
                    <h3 class="sp-cta-title">Precisa de mais informações?</h3>
                    <p class="sp-cta-text">
                        Converse conosco para esclarecer dúvidas sobre os grupos e pastorais.
                    </p>
                    <a href="{{ route('groups') }}" class="sp-btn sp-btn-outline sp-btn-lg">
                        📖 Conhecer Todos os Grupos
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection