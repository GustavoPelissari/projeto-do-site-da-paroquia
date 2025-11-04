@extends('admin.layout')

@section('title', $mass->name)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h1 class="h4 mb-1">{{ $mass->name }}</h1>
            <div class="text-muted small d-flex align-items-center gap-2 flex-wrap">
                <span>{{ $mass->day_name }}</span>
                <span>•</span>
                <span>{{ $mass->time ? $mass->time->format('H:i') : '' }}</span>
                <span>•</span>
                <span class="badge {{ $mass->is_active ? 'bg-success' : 'bg-danger' }}">{{ $mass->is_active ? 'Ativo' : 'Inativo' }}</span>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.global.masses.edit', $mass) }}" class="btn btn-primary">Editar</a>
            <a href="{{ route('admin.global.masses.index') }}" class="btn btn-outline-secondary">Voltar</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="mb-2">Detalhes</h6>
                        <div class="small text-muted">
                            <div><span class="fw-semibold">Dia:</span> {{ $mass->day_name }}</div>
                            <div><span class="fw-semibold">Hora:</span> {{ $mass->time ? $mass->time->format('H:i') : '' }}</div>
                            <div><span class="fw-semibold">Local:</span> {{ $mass->location }}</div>
                        </div>
                    </div>
                    @if($mass->description)
                        <div>
                            <h6 class="mb-2">Descrição</h6>
                            <div class="text-muted">{!! nl2br(e($mass->description)) !!}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="card-title mb-3">Ações</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.global.masses.edit', $mass) }}" class="btn btn-primary">✏️ Editar</a>
                        <form method="POST" action="{{ route('admin.global.masses.destroy', $mass) }}" onsubmit="return confirm('Tem certeza que deseja excluir este horário? Esta ação não pode ser desfeita.')">
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
                        <a href="{{ route('admin.global.masses.index') }}" class="btn btn-link text-start">← Todos os Horários</a>
                        <a href="{{ \App\Helpers\DashboardHelper::getDashboardRoute(auth()->user()->role) }}" class="btn btn-link text-start">🏠 Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
