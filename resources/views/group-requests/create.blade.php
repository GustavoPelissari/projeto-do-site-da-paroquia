@extends('layout')

@section('title', 'Solicitar Entrada em Grupo - Paróquia São Paulo Apóstolo')

@section('content')
<x-hero title="Participar da Nossa Comunidade" subtitle="Envie uma solicitação para se juntar a um dos nossos grupos e pastorais">
    <p class="mb-0" style="opacity: 0.9;">
        Seja bem-vindo! Preencha o formulário abaixo para solicitar sua participação.
    </p>
</x-hero>

<div class="container my-5">
    @if (session('success'))
        <x-alert type="success">
            <strong>Sucesso!</strong> {{ session('success') }}
        </x-alert>
    @endif

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

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card-paroquia">
                <div class="card-header-paroquia">
                    <h2 class="card-title-paroquia mb-0">
                        <i data-lucide="file-text" class="me-2"></i>
                        Formulário de Solicitação
                    </h2>
                </div>
                
                <form action="{{ route('group-requests.store') }}" method="POST" class="card-body-paroquia">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="group_id" class="form-label fw-bold">
                            <i data-lucide="users" class="icon-paroquia"></i>
                            Grupo Desejado <span class="text-danger">*</span>
                        </label>
                        <select id="group_id" name="group_id" required class="form-select form-select-lg">
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
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="message" class="form-label fw-bold">
                            <i data-lucide="message-square" class="icon-paroquia"></i>
                            Mensagem <span class="text-danger">*</span>
                        </label>
                        <textarea 
                            id="message" 
                            name="message" 
                            rows="5" 
                            required
                            placeholder="Explique por que deseja participar deste grupo e como pode contribuir para a nossa missão..."
                            class="form-control"
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i data-lucide="info" class="icon-paroquia"></i>
                            Mínimo de 10 caracteres. Seja claro sobre suas motivações e como deseja servir.
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn-paroquia btn-primary-paroquia">
                            <i data-lucide="send" class="icon-paroquia"></i>
                            Enviar Solicitação
                        </button>
                        <a href="{{ route('groups') }}" class="btn-paroquia btn-outline-paroquia">
                            <i data-lucide="arrow-left" class="icon-paroquia"></i>
                            Voltar aos Grupos
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-paroquia">
                <div class="card-header-paroquia">
                    <h3 class="card-title-paroquia mb-0">
                        <i data-lucide="users" class="me-2"></i>
                        Grupos Disponíveis
                    </h3>
                </div>
                <div class="card-body-paroquia">
                    @forelse($groups as $group)
                        <div class="mb-3 pb-3 border-bottom">
                            <h5 class="fw-bold mb-2" style="color: var(--vermelho-profundo);">
                                {{ $group->name }}
                            </h5>
                            
                            @if($group->description)
                                <p class="small text-muted mb-2">
                                    {{ Str::limit($group->description, 100) }}
                                </p>
                            @endif

                            @if($group->coordinator_name)
                                <div class="d-flex align-items-center small text-muted mb-1">
                                    <i data-lucide="user" style="width: 14px; height: 14px;" class="me-1"></i>
                                    <span>Coord.: {{ $group->coordinator_name }}</span>
                                </div>
                            @endif

                            @if($group->meeting_info)
                                <div class="d-flex align-items-center small text-muted">
                                    <i data-lucide="calendar" style="width: 14px; height: 14px;" class="me-1"></i>
                                    <span>{{ $group->meeting_info }}</span>
                                </div>
                            @endif

                            <span class="badge mt-2" style="background-color: var(--dourado-suave); color: var(--vermelho-profundo);">
                                {{ $group->category_name }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i data-lucide="users-2" class="text-muted mb-3" style="width: 48px; height: 48px;"></i>
                            <p class="text-muted mb-0">Nenhum grupo disponível no momento.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <section class="section-paroquia section-bg-bege mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card-paroquia" style="border-left: 4px solid var(--dourado-suave);">
                        <div class="card-header-paroquia">
                            <h3 class="card-title-paroquia mb-0">
                                <i data-lucide="info" class="me-2"></i>
                                Orientações Importantes
                            </h3>
                        </div>
                        <div class="card-body-paroquia">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <h4 class="h6 fw-bold mb-3" style="color: var(--vermelho-profundo);">
                                        <i data-lucide="check-square" class="icon-paroquia"></i>
                                        Antes de solicitar:
                                    </h4>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i data-lucide="chevron-right" class="icon-paroquia text-vermelho"></i>
                                            Leia atentamente a descrição de cada grupo
                                        </li>
                                        <li class="mb-2">
                                            <i data-lucide="chevron-right" class="icon-paroquia text-vermelho"></i>
                                            Considere sua disponibilidade real
                                        </li>
                                        <li class="mb-2">
                                            <i data-lucide="chevron-right" class="icon-paroquia text-vermelho"></i>
                                            Pense em como pode contribuir
                                        </li>
                                        <li class="mb-2">
                                            <i data-lucide="chevron-right" class="icon-paroquia text-vermelho"></i>
                                            Seja sincero em sua motivação
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="h6 fw-bold mb-3" style="color: var(--vermelho-profundo);">
                                        <i data-lucide="clock" class="icon-paroquia"></i>
                                        Após enviar:
                                    </h4>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i data-lucide="chevron-right" class="icon-paroquia text-vermelho"></i>
                                            Sua solicitação será analisada pelo coordenador
                                        </li>
                                        <li class="mb-2">
                                            <i data-lucide="chevron-right" class="icon-paroquia text-vermelho"></i>
                                            Você receberá uma resposta em até 7 dias
                                        </li>
                                        <li class="mb-2">
                                            <i data-lucide="chevron-right" class="icon-paroquia text-vermelho"></i>
                                            Pode acompanhar o status na área "Minhas Solicitações"
                                        </li>
                                        <li class="mb-2">
                                            <i data-lucide="chevron-right" class="icon-paroquia text-vermelho"></i>
                                            Aguarde o contato do coordenador
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>
@endpush