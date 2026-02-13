@extends('admin.layout')

@section('title', 'Gerenciar Escalas PDF')

@section('content')
<div class="sp-admin-dashboard">
    <div class="sp-dashboard-header">
        <h1 class="sp-page-title"> Escalas PDF - {{ $group->name }}</h1>
        <p class="sp-page-subtitle">Gerencie as escalas em PDF do seu grupo</p>
    </div>

    <!-- Upload Form -->
    <div class="sp-dashboard-section">
        <h2> Enviar Nova Escala</h2>
        <form action="{{ route('admin.coordenador.scales.upload') }}" method="POST" enctype="multipart/form-data" class="sp-form">
            @csrf
            
            <div class="sp-form-row">
                <div class="sp-form-group">
                    <label for="title" class="sp-form-label">Título da Escala</label>
                    <input type="text" id="title" name="title" class="sp-form-input" required>
                </div>
                
                <div class="sp-form-group">
                    <label for="file" class="sp-form-label">Arquivo PDF</label>
                    <input type="file" id="file" name="file" class="sp-form-input" accept=".pdf" required>
                    <small class="sp-form-help">Apenas arquivos PDF, máximo 10MB</small>
                </div>
            </div>

            <div class="sp-form-row">
                <div class="sp-form-group">
                    <label for="valid_from" class="sp-form-label">Válido a partir de</label>
                    <input type="date" id="valid_from" name="valid_from" class="sp-form-input">
                </div>
                
                <div class="sp-form-group">
                    <label for="valid_until" class="sp-form-label">Válido até</label>
                    <input type="date" id="valid_until" name="valid_until" class="sp-form-input">
                </div>
            </div>

            <div class="sp-form-group">
                <label for="description" class="sp-form-label">Descrição</label>
                <textarea id="description" name="description" class="sp-form-textarea" rows="3" placeholder="Informações adicionais sobre a escala..."></textarea>
            </div>

            <div class="sp-form-actions">
                <button type="submit" class="sp-btn sp-btn-primary">
                     Enviar Escala
                </button>
            </div>
        </form>
    </div>

    <!-- Scales List -->
    <div class="sp-dashboard-section">
        <h2> Escalas Enviadas</h2>
        
        @if($scales->count() > 0)
            <div class="sp-table-container">
                <table class="sp-table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Arquivo</th>
                            <th>Período</th>
                            <th>Status</th>
                            <th>Enviado</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($scales as $scale)
                            <tr>
                                <td>
                                    <strong>{{ $scale->title }}</strong>
                                    @if($scale->description)
                                        <br><small class="sp-text-muted">{{ Str::limit($scale->description, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="sp-file-info">
                                        <i class="fas fa-file-pdf sp-text-red"></i>
                                        <span>{{ $scale->original_filename }}</span>
                                        <small>({{ $scale->file_size_human }})</small>
                                    </div>
                                </td>
                                <td>
                                    @if($scale->valid_from || $scale->valid_until)
                                        @if($scale->valid_from)
                                            De: {{ $scale->valid_from->format('d/m/Y') }}<br>
                                        @endif
                                        @if($scale->valid_until)
                                            Até: {{ $scale->valid_until->format('d/m/Y') }}
                                        @endif
                                    @else
                                        <span class="sp-badge sp-badge-secondary">Indefinido</span>
                                    @endif
                                </td>
                                <td>
                                    @if($scale->isValid())
                                        <span class="sp-badge sp-badge-success">
                                            <i class="fas fa-check"></i> Ativo
                                        </span>
                                    @else
                                        <span class="sp-badge sp-badge-warning">
                                            <i class="fas fa-pause"></i> Inativo
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    {{ $scale->created_at->format('d/m/Y H:i') }}
                                    <br><small>por {{ $scale->uploader->name }}</small>
                                </td>
                                <td>
                                    <div class="sp-action-buttons">
                                        <a href="{{ route('admin.coordenador.scales.download', $scale) }}" 
                                           class="sp-btn sp-btn-sm sp-btn-secondary" 
                                           title="Baixar PDF">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.coordenador.scales.destroy', $scale) }}" 
                                              method="POST" 
                                              style="display: inline;"
                                              onsubmit="return confirm('Tem certeza que deseja remover esta escala?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="sp-btn sp-btn-sm sp-btn-danger" 
                                                    title="Remover">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="sp-pagination">
                {{ $scales->links() }}
            </div>
        @else
            <div class="sp-empty-state">
                <i class="fas fa-file-pdf"></i>
                <h3>Nenhuma escala enviada</h3>
                <p>Use o formulário acima para enviar a primeira escala PDF do seu grupo.</p>
            </div>
        @endif
    </div>

    <!-- Information -->
    <div class="sp-dashboard-section">
        <div class="sp-notice sp-notice-info">
            <i class="fas fa-info-circle"></i>
            <div>
                <h4>Sobre as Escalas PDF</h4>
                <ul>
                    <li>Apenas arquivos PDF são aceitos (máximo 10MB)</li>
                    <li>Você pode definir um período de validade para cada escala</li>
                    <li>Escalas ativas são marcadas com badge verde</li>
                    <li>Apenas coordenadores do grupo podem gerenciar as escalas</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.sp-file-info {
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.sp-action-buttons {
    display: flex;
    gap: var(--space-1);
}

.sp-badge {
    display: inline-flex;
    align-items: center;
    gap: var(--space-1);
    padding: var(--space-1) var(--space-2);
    border-radius: var(--border-radius);
    font-size: 0.875rem;
    font-weight: 500;
}

.sp-badge-success {
    background: rgba(34, 197, 94, 0.1);
    color: rgb(34, 197, 94);
}

.sp-badge-warning {
    background: rgba(245, 158, 11, 0.1);
    color: rgb(245, 158, 11);
}

.sp-badge-secondary {
    background: rgba(107, 114, 128, 0.1);
    color: rgb(107, 114, 128);
}

.sp-empty-state {
    text-align: center;
    padding: var(--space-8);
    color: var(--sp-text-muted);
}

.sp-empty-state i {
    font-size: 3rem;
    margin-bottom: var(--space-4);
    opacity: 0.5;
}
</style>
@endsection