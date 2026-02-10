@extends('admin.layout')

@section('title', 'Escalas - Coroinhas')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Page Header -->
    <div class="card border-0 shadow-lg mb-4 header-coroinhas">
        <div class="card-body text-white py-4 px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="display-6 fw-bold mb-2" style="color: #FFFFFF;">
                        <i class="bi bi-calendar3 me-2" aria-hidden="true"></i>Escalas dos Coroinhas
                    </h1>
                    <p class="mb-0" style="color: #FFD66B; font-size: 1.1rem;">
                        Confira as escalas de atividades do grupo
                    </p>
                </div>
                <div class="text-end">
                    <i class="bi bi-file-earmark-pdf" style="font-size: 4rem; color: #FFD66B; opacity: 0.8;" aria-hidden="true"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Alert -->
    <div class="alert alert-info d-flex align-items-center mb-4 shadow-sm"
         style="background: #E8F4FF; border: 1px solid #B8E1FF; color: #084C8A; border-radius: 12px;">
        <div class="d-flex align-items-start">
            <div class="me-3 circle-center"
                 style="width: 40px; height: 40px; background: #B8E1FF; border-radius: 50%;">
                <i class="bi bi-info-circle-fill" style="font-size: 1.25rem; color: #084C8A !important;"></i>
            </div>
            <div>
                <div class="fw-bold" style="color: #084C8A;">Visualização apenas</div>
                <div class="small" style="color: #0B5EAC;">
                    Você pode visualizar e baixar as escalas do seu grupo. Somente coordenadores podem criar, editar ou excluir escalas.
                </div>
            </div>
        </div>
    </div>

    <!-- Escalas Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($scales->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4">Título</th>
                                <th>Arquivo</th>
                                <th>Período</th>
                                <th>Status</th>
                                <th>Enviado por</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($scales as $scale)
                                <tr>
                                    <td class="px-4">
                                        <strong>{{ $scale->title }}</strong>
                                        @if($scale->description)
                                            <br>
                                            <small class="text-muted">{{ Str::limit($scale->description, 60) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <i class="bi bi-file-earmark-pdf text-danger" aria-hidden="true"></i>
                                        <small class="text-muted">{{ $scale->file_name }}</small>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar-range" aria-hidden="true"></i>
                                            {{ $scale->valid_from->format('d/m/Y') }}
                                            até
                                            {{ $scale->valid_until->format('d/m/Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($scale->valid_from <= now() && $scale->valid_until >= now())
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle"></i> Ativo
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="bi bi-clock"></i> Inativo
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $scale->uploader->name ?? 'N/A' }}
                                            <br>
                                            <i class="bi bi-clock" aria-hidden="true"></i> {{ $scale->created_at->diffForHumans() }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" 
                                                class="btn btn-sm btn-success me-1" 
                                                onclick="viewPDF('{{ asset('storage/' . $scale->file_path) }}', '{{ addslashes($scale->title) }}')"
                                                title="Visualizar PDF">
                                            <i class="bi bi-eye" aria-hidden="true"></i> Visualizar
                                        </button>
                                        <a href="{{ route('user.scales.download', $scale) }}" 
                                           class="btn btn-sm btn-primary" 
                                           title="Baixar PDF">
                                            <i class="bi bi-download" aria-hidden="true"></i> Baixar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($scales->hasPages())
                    <div class="d-flex justify-content-center p-3">
                        {{ $scales->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <i class="bi bi-calendar-x" style="font-size: 4rem; color: #ddd;" aria-hidden="true"></i>
                    <h4 class="mt-3 text-muted">Nenhuma escala disponível</h4>
                    <p class="text-muted mb-0">As escalas do grupo serão exibidas aqui quando forem cadastradas.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de Visualização de PDF -->
<div class="modal fade" id="pdfViewerModal" tabindex="-1" aria-labelledby="pdfViewerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="pdfViewerModalLabel">
                    <i class="bi bi-file-earmark-pdf me-2" aria-hidden="true"></i>
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
                    <i class="bi bi-x-circle" aria-hidden="true"></i> Fechar
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.header-coroinhas {
    background: linear-gradient(135deg, #2C5F2D 0%, #1E4620 50%, #2C5F2D 100%);
    border-radius: 20px;
}

.table-hover tbody tr:hover {
    background-color: rgba(44, 95, 45, 0.05);
}
</style>

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
