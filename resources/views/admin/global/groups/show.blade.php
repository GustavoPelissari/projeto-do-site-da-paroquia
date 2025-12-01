@extends('admin.layout')

@section('title', $group->name)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h1 class="h4 mb-1">{{ $group->name }}</h1>
            <div class="text-muted small d-flex align-items-center gap-2 flex-wrap">
                <span class="badge bg-secondary">{{ $group->category_name }}</span>
                <span>•</span>
                <span class="badge {{ $group->is_active ? 'bg-success' : 'bg-danger' }}">{{ $group->is_active ? 'Ativo' : 'Inativo' }}</span>
                @if(isset($group->members_count))
                    <span>•</span>
                    <span>{{ $group->members_count }} membro(s)</span>
                @endif
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.global.groups.edit', $group) }}" class="btn btn-primary">Editar</a>
            <a href="{{ route('admin.global.groups.index') }}" class="btn btn-outline-secondary">Voltar</a>
        </div>
    </div>

    @if(session('success'))
        <x-alert type="success">
            {{ session('success') }}
        </x-alert>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            @if($group->image)
            <div class="card shadow-sm mb-3">
                <div class="card-body text-center">
                    <h6 class="mb-3">Logo do Grupo</h6>
                    <img src="{{ asset('storage/' . $group->image) }}" 
                         alt="{{ $group->name }}" 
                         class="img-thumbnail"
                         style="max-height: 200px;">
                </div>
            </div>
            @endif

            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="mb-2">Sobre o Grupo</h6>
                    <div class="text-muted">{!! nl2br(e($group->description)) !!}</div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3">Informações do Coordenador</h6>
                    <div class="row g-3 small text-muted">
                        <div class="col-md-6">
                            @if($group->coordinator_name)
                                <div class="mb-2"><span class="fw-semibold">Nome:</span> {{ $group->coordinator_name }}</div>
                            @else
                                <div class="text-muted fst-italic">Nenhum coordenador cadastrado</div>
                            @endif
                            @if($group->coordinator_phone)
                                <div class="mb-2"><span class="fw-semibold">Telefone:</span> {{ $group->coordinator_phone }}</div>
                            @endif
                            @if($group->coordinator_email)
                                <div class="mb-2"><span class="fw-semibold">E-mail:</span> {{ $group->coordinator_email }}</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($group->meeting_info)
                                <div><span class="fw-semibold">Informações de Reunião:</span></div>
                                <div class="mt-1">{{ $group->meeting_info }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="card-title mb-3">Ações</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.global.groups.edit', $group) }}" class="btn btn-primary">✏️ Editar</a>
                        <form method="POST" action="{{ route('admin.global.groups.destroy', $group) }}" onsubmit="return confirm('Tem certeza que deseja excluir este grupo? Esta ação não pode ser desfeita.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">🗑️ Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3">Navegação</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.global.groups.index') }}" class="btn btn-link text-start">← Todos os Grupos</a>
                        <a href="{{ \App\Helpers\DashboardHelper::getDashboardRoute(auth()->user()->role) }}" class="btn btn-link text-start">🏠 Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
