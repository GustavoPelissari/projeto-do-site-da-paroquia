@extends('admin.layout')

@section('title', 'Escalas PDF do Grupo')

@section('content')
<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
    <div>
        <p class="admin-overline mb-1">Coordenação pastoral</p>
        <h2 class="h3 mb-0">Escalas PDF {{ $group ? ' - '.$group->name : '' }}</h2>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header"><h3 class="h5 mb-0">Enviar nova escala</h3></div>
    <div class="card-body">
        <form action="{{ route('admin.coordenador.scales.upload') }}" method="POST" enctype="multipart/form-data" class="row g-3">
            @csrf
            <div class="col-md-6">
                <label class="form-label" for="title">Título</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="file">Arquivo PDF</label>
                <input type="file" class="form-control" id="file" name="file" accept=".pdf" required>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="valid_from">Válido de</label>
                <input type="date" class="form-control" id="valid_from" name="valid_from">
            </div>
            <div class="col-md-3">
                <label class="form-label" for="valid_until">Válido até</label>
                <input type="date" class="form-control" id="valid_until" name="valid_until">
            </div>
            <div class="col-md-6">
                <label class="form-label" for="description">Descrição</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Descrição opcional">
            </div>
            <div class="col-12 d-grid d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary"><i class="bi bi-upload me-1"></i>Enviar PDF</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="h5 mb-0">Arquivos enviados</h3>
        <small class="text-secondary">{{ $scales->total() }} registro{{ $scales->total() === 1 ? '' : 's' }}</small>
    </div>
    <div class="card-body p-0">
        @if($scales->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Arquivo</th>
                            <th>Validade</th>
                            <th>Status</th>
                            <th>Envio</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($scales as $scale)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $scale->title }}</div>
                                    @if($scale->description)
                                        <small class="text-secondary">{{ Str::limit($scale->description, 80) }}</small>
                                    @endif
                                </td>
                                <td>
                                    {{ $scale->original_filename }}<br>
                                    <small class="text-secondary">{{ $scale->file_size_human }}</small>
                                </td>
                                <td>
                                    <small>
                                        {{ $scale->valid_from ? $scale->valid_from->format('d/m/Y') : '—' }}
                                        até
                                        {{ $scale->valid_until ? $scale->valid_until->format('d/m/Y') : '—' }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge {{ $scale->isValid() ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $scale->isValid() ? 'Ativo' : 'Inativo' }}</span>
                                </td>
                                <td>
                                    <small>{{ $scale->created_at->format('d/m/Y H:i') }}</small>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.coordenador.scales.download', $scale) }}" class="btn btn-outline-secondary">Baixar</a>
                                        <form method="POST" action="{{ route('admin.coordenador.scales.destroy', $scale) }}" onsubmit="return confirm('Remover esta escala?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">Excluir</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-4 text-center text-secondary">Nenhuma escala enviada ainda.</div>
        @endif
    </div>
</div>

@if($scales->hasPages())
    <div class="mt-4">{{ $scales->links() }}</div>
@endif
@endsection
