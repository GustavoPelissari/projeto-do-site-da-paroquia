@extends('admin.layout')

@section('title', 'Visão do Sistema - Admin Global')

@section('content')
<div class="mb-4">
    <p class="admin-overline mb-1">Operação técnica</p>
    <h2 class="h3 mb-1">Visão geral do sistema</h2>
    <p class="text-secondary mb-0">Status dos serviços, informações de ambiente e uso de recursos.</p>
</div>

<div class="row g-4">
    <div class="col-12 col-xl-8">
        <div class="card h-100">
            <div class="card-header"><h3 class="h5 mb-0">Status dos serviços</h3></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6"><div class="border rounded-3 p-3"><div class="d-flex align-items-center gap-2 mb-1"><span class="badge text-bg-success">Online</span><strong>Sistema principal</strong></div><small class="text-secondary">Funcionando normalmente</small></div></div>
                    <div class="col-md-6"><div class="border rounded-3 p-3"><div class="d-flex align-items-center gap-2 mb-1"><span class="badge text-bg-success">Conectado</span><strong>Banco de dados</strong></div><small class="text-secondary">Conexão estável</small></div></div>
                    <div class="col-md-6"><div class="border rounded-3 p-3"><div class="d-flex align-items-center gap-2 mb-1"><span class="badge text-bg-success">Ativo</span><strong>Cache</strong></div><small class="text-secondary">Desempenho otimizado</small></div></div>
                    <div class="col-md-6"><div class="border rounded-3 p-3"><div class="d-flex align-items-center gap-2 mb-1"><span class="badge text-bg-warning">Atenção</span><strong>Backup</strong></div><small class="text-secondary">Último backup: {{ optional($overview['last_backup'] ?? null)?->format('d/m/Y H:i') ?? 'não disponível' }}</small></div></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-4">
        <div class="card h-100">
            <div class="card-header"><h3 class="h5 mb-0">Ambiente</h3></div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between"><span>Versão sistema</span><strong>v1.0.0</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Laravel</span><strong>{{ app()->version() }}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>PHP</span><strong>{{ PHP_VERSION }}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Timezone</span><strong>{{ config('app.timezone') }}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Sessões ativas</span><strong>{{ $overview['active_sessions'] ?? 0 }}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Visitantes/mês</span><strong>{{ $overview['monthly_visitors'] ?? 0 }}</strong></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="h5 mb-0">Uso de recursos</h3>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-outline-primary" type="button">Limpar cache</button>
            <button class="btn btn-sm btn-outline-secondary" type="button">Backup manual</button>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3"><div class="border rounded-3 p-3"><small class="text-secondary">Memória PHP</small><div class="h5 mb-0">{{ number_format(memory_get_usage(true) / 1024 / 1024, 2) }} MB</div></div></div>
            <div class="col-md-3"><div class="border rounded-3 p-3"><small class="text-secondary">Limite de memória</small><div class="h5 mb-0">{{ ini_get('memory_limit') }}</div></div></div>
            <div class="col-md-3"><div class="border rounded-3 p-3"><small class="text-secondary">Tempo de execução</small><div class="h5 mb-0">{{ ini_get('max_execution_time') }}s</div></div></div>
            <div class="col-md-3"><div class="border rounded-3 p-3"><small class="text-secondary">Upload máximo</small><div class="h5 mb-0">{{ ini_get('upload_max_filesize') }}</div></div></div>
        </div>
    </div>
</div>
@endsection
