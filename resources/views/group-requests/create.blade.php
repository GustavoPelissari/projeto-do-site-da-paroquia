@extends('layout')

@section('title', 'Solicitar Entrada em Grupo - Paróquia São Paulo Apóstolo')

@section('content')
<x-hero title="Participar da Nossa Comunidade" subtitle="Junte-se aos nossos grupos e pastorais">
    <p class="mb-0" style="opacity: 0.9;">
        Preencha o formulário abaixo para solicitar sua participação em um grupo paroquial
    </p>
</x-hero>

<div class="container my-5">
    {{-- Removido alerta local de sucesso para evitar duplicidade (layout já exibe) --}}

    @if ($errors->any())
        <x-alert type="error">
            <strong>Atenção!</strong> Corrija os erros abaixo:
            <ul class="mt-2 mb-0 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    @if(isset($currentGroup))
        {{-- Alerta informativo sobre grupo atual --}}
        <div class="alert mb-4" style="background: linear-gradient(135deg, #FFF5F0 0%, #FFEEE5 100%); border-left: 4px solid var(--brand-vinho); border-radius: 10px; box-shadow: 0 2px 8px rgba(139, 30, 63, 0.1);">
            <div class="d-flex align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" 
                     style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--brand-vinho) 0%, #6B0F2A 100%); display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-check-circle-fill" style="font-size: 24px; color: white !important; margin: 0; line-height: 1; vertical-align: middle;"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1" style="color: var(--brand-vinho);">
                        Você já participa do grupo: {{ $currentGroup->name }}
                    </h6>
                    <p class="mb-0 small text-muted">
                        Você pode solicitar participação em outros grupos para ampliar seu serviço na paróquia.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card-paroquia shadow-sm">
                <div class="card-header-paroquia" style="background: linear-gradient(135deg, var(--brand-vinho) 0%, #6B0F2A 100%);">
                    <h2 class="card-title-paroquia mb-0 text-white">
                        <i class="bi bi-file-text me-2"></i>
                        Formulário de Solicitação
                    </h2>
                </div>
                
                <form action="{{ route('group-requests.store') }}" method="POST" class="card-body-paroquia p-4">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="group_id" class="form-label fw-bold d-flex align-items-center mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-2" 
                                 style="width: 32px; height: 32px; background-color: var(--bg-rose); display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-people-fill" style="font-size: 16px; color: var(--brand-vinho) !important; margin: 0; line-height: 1; vertical-align: middle;"></i>
                            </div>
                            <span style="color: var(--brand-vinho);">Grupo Desejado <span class="text-danger">*</span></span>
                        </label>
                        <select id="group_id" name="group_id" required class="form-select form-select-lg" style="border: 2px solid var(--bg-rose); border-radius: 8px;">
                            <option value="">Selecione um grupo...</option>
                            @foreach($groups as $group)
                                @if(!isset($currentGroup) || $currentGroup->id !== $group->id)
                                    <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                                        {{ $group->name }}
                                        @if($group->description)
                                            - {{ Str::limit($group->description, 50) }}
                                        @endif
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('group_id')
                            <div class="text-danger small mt-2">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="message" class="form-label fw-bold d-flex align-items-center mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-2" 
                                 style="width: 32px; height: 32px; background-color: var(--bg-rose); display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-pencil-fill" style="font-size: 16px; color: var(--brand-vinho) !important; margin: 0; line-height: 1; vertical-align: middle;"></i>
                            </div>
                            <span style="color: var(--brand-vinho);">Mensagem <span class="text-danger">*</span></span>
                        </label>
                        <textarea 
                            id="message" 
                            name="message" 
                            rows="6" 
                            required
                            placeholder="Explique por que deseja participar deste grupo e como pode contribuir para a nossa missão..."
                            class="form-control"
                            style="border: 2px solid var(--bg-rose); border-radius: 8px; resize: vertical;"
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <div class="text-danger small mt-2">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text mt-2">
                            <i class="bi bi-info-circle"></i>
                            Mínimo de 10 caracteres. Seja claro sobre suas motivações e disponibilidade.
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4 flex-wrap">
                        <button type="submit" class="btn-paroquia btn-primary-paroquia px-4">
                            <i class="bi bi-send-fill me-2"></i>
                            Enviar Solicitação
                        </button>
                        <a href="{{ route('groups') }}" class="btn btn-outline-secondary px-4 d-flex align-items-center justify-content-center" style="border: 2px solid var(--brand-vinho); color: var(--brand-vinho); text-decoration: none;">
                            <i class="bi bi-arrow-left me-2"></i>
                            Voltar aos Grupos
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card-paroquia shadow-sm">
                <div class="card-header-paroquia" style="background: linear-gradient(135deg, var(--brand-vinho) 0%, #6B0F2A 100%);">
                    <h3 class="card-title-paroquia mb-0 text-white">
                        <i class="bi bi-list-ul me-2"></i>
                        Grupos Disponíveis
                    </h3>
                </div>
                <div class="card-body-paroquia p-3" style="max-height: 600px; overflow-y: auto;">
                    @php
                        $availableGroups = $groups->filter(function($group) use ($currentGroup) {
                            return !isset($currentGroup) || $currentGroup->id !== $group->id;
                        });
                    @endphp
                    
                    @forelse($availableGroups as $group)
                        <div class="mb-3 p-3 border-bottom" style="border-color: var(--bg-rose) !important;">
                            <h5 class="fw-bold mb-2 d-flex align-items-center" style="color: var(--brand-vinho);">
                                <i class="bi bi-circle-fill me-2" style="font-size: 8px;"></i>
                                {{ $group->name }}
                            </h5>
                            
                            @if($group->description)
                                <p class="small text-muted mb-2" style="line-height: 1.5;">
                                    {{ Str::limit($group->description, 100) }}
                                </p>
                            @endif

                            <div class="d-flex flex-column gap-1 mt-2">
                                @if($group->coordinator_name)
                                    <div class="d-flex align-items-center small text-muted">
                                        <i class="bi bi-person-fill me-2" style="font-size: 14px; color: var(--brand-vinho);"></i>
                                        <span><strong>Coord.:</strong> {{ $group->coordinator_name }}</span>
                                    </div>
                                @endif

                                @if($group->meeting_info)
                                    <div class="d-flex align-items-center small text-muted">
                                        <i class="bi bi-calendar-event me-2" style="font-size: 14px; color: var(--brand-vinho);"></i>
                                        <span>{{ $group->meeting_info }}</span>
                                    </div>
                                @endif
                            </div>

                            <span class="badge mt-2" style="background-color: var(--dourado-suave); color: var(--brand-vinho); font-size: 0.75rem;">
                                {{ $group->category_name }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-people" style="font-size: 64px; opacity: 0.3; color: #6c757d;"></i>
                            <p class="text-muted mb-0 mt-3">Nenhum grupo disponível no momento.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <section class="section-paroquia section-bg-bege mt-5">
        <div class="container">
            <div class="text-center mb-4">
                <h3 class="fw-bold" style="color: var(--brand-vinho);">
                    <i class="bi bi-info-circle me-2"></i>
                    Orientações Importantes
                </h3>
            </div>
            
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-3">
                    <div class="card-paroquia h-100 text-center shadow-sm" style="border-top: 3px solid var(--brand-vinho);">
                        <div class="card-body-paroquia pt-5">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--brand-vinho) 0%, #6B0F2A 100%); display: flex; align-items: center; justify-content: center; margin-top: -50px;">
                                <i class="bi bi-book" style="font-size: 28px; color: white !important; margin: 0; line-height: 1; vertical-align: middle;"></i>
                            </div>
                            <h5 class="fw-bold mb-2" style="color: var(--brand-vinho);">Leia a Descrição</h5>
                            <p class="small text-muted mb-0">
                                Conheça bem o grupo antes de solicitar participação
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card-paroquia h-100 text-center shadow-sm" style="border-top: 3px solid var(--brand-vinho);">
                        <div class="card-body-paroquia pt-5">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--brand-vinho) 0%, #6B0F2A 100%); display: flex; align-items: center; justify-content: center; margin-top: -50px;">
                                <i class="bi bi-clock" style="font-size: 28px; color: white !important; margin: 0; line-height: 1; vertical-align: middle;"></i>
                            </div>
                            <h5 class="fw-bold mb-2" style="color: var(--brand-vinho);">Disponibilidade</h5>
                            <p class="small text-muted mb-0">
                                Considere seu tempo e compromisso com o grupo
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card-paroquia h-100 text-center shadow-sm" style="border-top: 3px solid var(--brand-vinho);">
                        <div class="card-body-paroquia pt-5">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--brand-vinho) 0%, #6B0F2A 100%); display: flex; align-items: center; justify-content: center; margin-top: -50px;">
                                <i class="bi bi-heart-fill" style="font-size: 28px; color: white !important; margin: 0; line-height: 1; vertical-align: middle;"></i>
                            </div>
                            <h5 class="fw-bold mb-2" style="color: var(--brand-vinho);">Motivação</h5>
                            <p class="small text-muted mb-0">
                                Seja sincero sobre como deseja contribuir
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card-paroquia h-100 text-center shadow-sm" style="border-top: 3px solid var(--brand-vinho);">
                        <div class="card-body-paroquia pt-5">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--brand-vinho) 0%, #6B0F2A 100%); display: flex; align-items: center; justify-content: center; margin-top: -50px;">
                                <i class="bi bi-calendar-check-fill" style="font-size: 28px; color: white !important; margin: 0; line-height: 1; vertical-align: middle;"></i>
                            </div>
                            <h5 class="fw-bold mb-2" style="color: var(--brand-vinho);">Resposta em 7 dias</h5>
                            <p class="small text-muted mb-0">
                                O coordenador analisará sua solicitação
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection