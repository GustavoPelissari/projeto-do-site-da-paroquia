@extends('admin.layout')

@section('title', 'Estatísticas Paroquiais - Admin Global')

@section('content')
<div class="mb-4">
    <p class="admin-overline mb-1">Indicadores da paróquia</p>
    <h2 class="h3 mb-1">Estatísticas paroquiais</h2>
    <p class="text-secondary mb-0">Acompanhe evolução mensal/anual e os grupos com mais participantes.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card h-100"><div class="card-body"><small class="text-secondary">Novos membros (mês)</small><div class="display-6 fw-semibold text-primary">{{ $stats['monthly_stats']['new_members'] ?? 0 }}</div></div></div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card h-100"><div class="card-body"><small class="text-secondary">Eventos realizados (mês)</small><div class="display-6 fw-semibold text-primary">{{ $stats['monthly_stats']['events_held'] ?? 0 }}</div></div></div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card h-100"><div class="card-body"><small class="text-secondary">Notícias publicadas (mês)</small><div class="display-6 fw-semibold text-primary">{{ $stats['monthly_stats']['news_published'] ?? 0 }}</div></div></div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card h-100"><div class="card-body"><small class="text-secondary">Solicitações de grupos (mês)</small><div class="display-6 fw-semibold text-primary">{{ $stats['monthly_stats']['group_requests'] ?? 0 }}</div></div></div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h3 class="h5 mb-0">Resumo anual</h3>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3"><div class="border rounded-3 p-3 h-100"><small class="text-secondary">Membros no ano</small><div class="h4 mb-0">{{ $stats['yearly_stats']['total_members_joined'] ?? 0 }}</div></div></div>
            <div class="col-md-3"><div class="border rounded-3 p-3 h-100"><small class="text-secondary">Eventos no ano</small><div class="h4 mb-0">{{ $stats['yearly_stats']['total_events'] ?? 0 }}</div></div></div>
            <div class="col-md-3"><div class="border rounded-3 p-3 h-100"><small class="text-secondary">Notícias no ano</small><div class="h4 mb-0">{{ $stats['yearly_stats']['total_news'] ?? 0 }}</div></div></div>
            <div class="col-md-3"><div class="border rounded-3 p-3 h-100"><small class="text-secondary">Grupos criados no ano</small><div class="h4 mb-0">{{ $stats['yearly_stats']['groups_created'] ?? 0 }}</div></div></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="h5 mb-0">Top grupos por membros</h3>
    </div>
    <div class="card-body p-0">
        @if(($stats['top_groups'] ?? collect())->count())
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Grupo</th>
                            <th>Categoria</th>
                            <th>Status</th>
                            <th class="text-end">Membros</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['top_groups'] as $group)
                            <tr>
                                <td class="fw-semibold">{{ $group->name }}</td>
                                <td>{{ $group->category_name }}</td>
                                <td><span class="badge {{ $group->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $group->is_active ? 'Ativo' : 'Inativo' }}</span></td>
                                <td class="text-end">{{ $group->members_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-4 text-center text-secondary">Sem dados de grupos para exibir.</div>
        @endif
    </div>
</div>
@endsection
