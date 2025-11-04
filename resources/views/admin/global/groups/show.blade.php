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
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="mb-2">Sobre o Grupo</h6>
                    <div class="text-muted">{!! nl2br(e($group->description)) !!}</div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3">Informações</h6>
                    <div class="row g-3 small text-muted">
                        @if($group->coordinator_name)
                        <div class="col-md-6">
                            <div><span class="fw-semibold">Coordenador:</span> {{ $group->coordinator_name }}</div>
                            @if($group->coordinator_email)
                                <div><span class="fw-semibold">E-mail:</span> {{ $group->coordinator_email }}</div>
                            @endif
                            @if($group->coordinator_phone)
                                <div><span class="fw-semibold">Telefone:</span> {{ $group->coordinator_phone }}</div>
                            @endif
                        </div>
                        @endif
                        @if($group->meeting_info)
                        <div class="col-md-6">
                            <div><span class="fw-semibold">Encontros:</span> {{ $group->meeting_info }}</div>
                        </div>
                        @endif
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
