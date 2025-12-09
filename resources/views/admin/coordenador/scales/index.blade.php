@extends('admin.layout')

@section('title', 'Gerenciar Escalas PDF')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #8B1538 0%, #6E1530 50%, #8B1538 100%); border-radius: 15px;">
        <div class="card-body text-white py-4 px-4">
            <h1 class="h2 fw-bold mb-2" style="color: #FFFFFF;"><i class="bi bi-file-earmark-pdf"></i> Escalas PDF - {{ $group->name }}</h1>
            <p class="mb-0" style="color: #FFD66B;">Gerencie as escalas em PDF do seu grupo</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3"><h5 class="mb-0 fw-bold"><i class="bi bi-cloud-upload"></i> Enviar Nova Escala</h5></div>
        <div class="card-body">
            <form action="{{ route('admin.coordenador.scales.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label fw-semibold"><i class="bi bi-card-heading"></i> Título da Escala</label>
                        <input type="text" id="title" name="title" class="form-control" required placeholder="Ex: Escala de Coroinhas - Dezembro 2025">
                    </div>
                    <div class="col-md-6">
                        <label for="file" class="form-label fw-semibold"><i class="bi bi-file-pdf"></i> Arquivo PDF</label>
                        <input type="file" id="file" name="file" class="form-control" accept=".pdf" required>
                        <small class="text-muted">Apenas arquivos PDF, máximo 10MB</small>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="valid_from" class="form-label fw-semibold"><i class="bi bi-calendar-check"></i> Válido a partir de</label>
                        <input type="date" id="valid_from" name="valid_from" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="valid_until" class="form-label fw-semibold"><i class="bi bi-calendar-x"></i> Válido até</label>
                        <input type="date" id="valid_until" name="valid_until" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold"><i class="bi bi-text-paragraph"></i> Descrição (Opcional)</label>
                    <textarea id="description" name="description" class="form-control" rows="3" placeholder="Informações adicionais sobre a escala..."></textarea>
                </div>
                <div class="text-end"><button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-cloud-upload me-2"></i>Enviar Escala</button></div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3"><h5 class="mb-0 fw-bold"><i class="bi bi-file-earmark-text"></i> Escalas Enviadas</h5></div>
        @if($scales->count() > 0)
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light"><tr><th>Título</th><th>Arquivo</th><th>Período</th><th class="text-center">Status</th><th>Enviado</th><th class="text-center">Ações</th></tr></thead>
                        <tbody>
                            @foreach($scales as $scale)
                                <tr>
                                    <td><strong>{{ $scale->title }}</strong>@if($scale->description)<br><small class="text-muted">{{ Str::limit($scale->description, 50) }}</small>@endif</td>
                                    <td><div class="d-flex align-items-center gap-2"><i class="bi bi-file-pdf-fill text-danger" style="font-size: 1.5rem;"></i><div><div>{{ $scale->original_filename }}</div><small class="text-muted">({{ $scale->file_size_human }})</small></div></div></td>
                                    <td>@if($scale->valid_from || $scale->valid_until)@if($scale->valid_from)<div><small class="text-muted">De:</small> {{ $scale->valid_from->format('d/m/Y') }}</div>@endif @if($scale->valid_until)<div><small class="text-muted">Até:</small> {{ $scale->valid_until->format('d/m/Y') }}</div>@endif @else <span class="badge bg-secondary">Indefinido</span>@endif</td>
                                    <td class="text-center">@if($scale->isValid())<span class="badge bg-success"><i class="bi bi-check-circle"></i> Ativo</span>@else<span class="badge bg-warning"><i class="bi bi-pause-circle"></i> Inativo</span>@endif</td>
                                    <td><div>{{ $scale->created_at->format('d/m/Y H:i') }}</div><small class="text-muted">por {{ $scale->uploader->name }}</small></td>
                                    <td class="text-center"><div class="d-flex gap-2 justify-content-center"><button type="button" class="btn btn-sm btn-outline-success" onclick="viewPDF('{{ asset('storage/' . $scale->file_path) }}', '{{ $scale->title }}')" title="Visualizar PDF"><i class="bi bi-eye me-1"></i>Ver</button><a href="{{ route('admin.coordenador.scales.download', $scale) }}" class="btn btn-sm btn-outline-primary" title="Baixar PDF"><i class="bi bi-download me-1"></i>Baixar</a><form action="{{ route('admin.coordenador.scales.destroy', $scale) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja remover esta escala?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger" title="Remover"><i class="bi bi-trash me-1"></i>Remover</button></form></div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if($scales->hasPages())<div class="card-footer">{{ $scales->links() }}</div>@endif
        @else
            <div class="card-body text-center py-5">
                <div class="mb-4"><i class="bi bi-file-earmark-pdf" style="font-size: 4rem; color: #dee2e6;"></i></div>
                <h3 class="fw-bold text-muted mb-3">Nenhuma escala enviada</h3>
                <p class="text-muted mb-0">Use o formulário acima para enviar a primeira escala PDF do seu grupo.</p>
            </div>
        @endif
    </div>

    <div class="alert alert-info mt-4" role="alert">
        <x-alert type="info" class="mt-4">
            <h5 class="alert-heading"><i class="bi bi-info-circle"></i> Sobre as Escalas PDF</h5>
            <hr>
            <ul class="mb-0">
                <li>Apenas arquivos PDF são aceitos (máximo 10MB)</li>
                <li>Você pode definir um período de validade para cada escala</li>
                <li>Escalas ativas são marcadas com badge verde</li>
                <li>Apenas coordenadores do grupo podem gerenciar as escalas</li>
            </ul>
        </x-alert>
</div>

<!-- Modal de Visualização de PDF -->
<div class="modal fade" id="pdfViewerModal" tabindex="-1" aria-labelledby="pdfViewerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #8B1538 0%, #6E1530 100%);">
                <h5 class="modal-title text-white" id="pdfViewerModalLabel">
                    <i class="bi bi-file-earmark-pdf me-2"></i>
                    <span id="pdfTitle">Visualizar Escala</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body p-0" style="height: 80vh;">
                <iframe id="pdfIframe" 
                        style="width: 100%; height: 100%; border: none;" 
                        src="">
                </iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Fechar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function viewPDF(pdfUrl, title) {
    document.getElementById('pdfTitle').textContent = title;
    document.getElementById('pdfIframe').src = pdfUrl;
    
    const modal = new bootstrap.Modal(document.getElementById('pdfViewerModal'));
    modal.show();
}

// Limpar iframe ao fechar modal
document.getElementById('pdfViewerModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('pdfIframe').src = '';
});
</script>
@endsection
