<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h5 mb-0">
                {{ $schedule->title }}
            </h2>
            <div class="d-flex gap-2">
                @if(auth()->user()->canManageSchedules())
                    <a href="{{ route('admin.schedules.edit', $schedule) }}" 
                       class="btn btn-warning btn-sm">
                        Editar
                    </a>
                @endif
                <a href="{{ route('admin.schedules.download', $schedule) }}" 
                   class="btn btn-success btn-sm">
                    Baixar PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="container-lg">
            <!-- Informações da Escala -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <h3 class="h6 fw-semibold mb-3">Informações Gerais</h3>
                            
                            <div class="d-grid gap-2">
                                <div>
                                    <span class="text-muted small fw-semibold">Grupo:</span>
                                    <p class="mb-0">{{ $schedule->group->name }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-muted small fw-semibold">Período:</span>
                                    <p class="mb-0">
                                        {{ $schedule->start_date->format('d/m/Y') }} até {{ $schedule->end_date->format('d/m/Y') }}
                                    </p>
                                </div>
                                
                                <div>
                                    <span class="text-muted small fw-semibold">Status:</span>
                                    @php
                                        $status = $schedule->getStatusBadge();
                                        $statusClass = [
                                            'gray' => 'secondary',
                                            'blue' => 'primary',
                                            'red' => 'danger',
                                            'green' => 'success',
                                        ][$status['color']] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">
                                        {{ $status['text'] }}
                                    </span>
                                </div>
                                
                                <div>
                                    <span class="text-muted small fw-semibold">Criada por:</span>
                                    <p class="mb-0">{{ $schedule->user->name }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-muted small fw-semibold">Criada em:</span>
                                    <p class="mb-0">{{ $schedule->created_at->format('d/m/Y \à\s H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h3 class="h6 fw-semibold mb-3">Arquivo PDF</h3>
                            
                            <div class="border rounded p-3">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-file-earmark-pdf text-danger fs-3" aria-hidden="true"></i>
                                    </div>
                                    <div class="flex-grow-1" style="min-width: 0;">
                                        <p class="mb-0 fw-semibold text-truncate">
                                            {{ $schedule->pdf_filename }}
                                        </p>
                                        <p class="mb-0 text-muted small">{{ $schedule->getPdfSize() }}</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.schedules.download', $schedule) }}" 
                                       class="btn btn-outline-primary btn-sm flex-fill">
                                        Baixar
                                    </a>
                                    <button type="button"
                                            class="btn btn-outline-secondary btn-sm flex-fill"
                                            data-bs-toggle="modal"
                                            data-bs-target="#pdfModal"
                                            data-pdf-url="{{ $schedule->getPdfUrl() }}">
                                        Visualizar
                                    </button>
                                </div>
                            </div>
                            
                            <div class="alert alert-warning small mt-3 mb-0">
                                <strong>Arquivo oficial:</strong> este é o documento oficial da escala. Sempre consulte o PDF para informações atualizadas.
                            </div>
                        </div>
                    </div>

                    @if($schedule->description)
                        <div class="border-top pt-4">
                            <h3 class="h6 fw-semibold mb-3">Descrição</h3>
                            <p class="mb-0" style="white-space: pre-line;">{{ $schedule->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Membros do Grupo -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="h6 fw-semibold mb-4">
                        Membros do Grupo ({{ $schedule->group->getMembersCount() }})
                    </h3>
                    
                    @if($schedule->group->members->count() > 0)
                        <div class="row g-3">
                            @foreach($schedule->group->members as $member)
                                <div class="col-md-6 col-lg-4">
                                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded">
                                        <div class="flex-shrink-0">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <span class="small fw-semibold">
                                                {{ substr($member->name, 0, 1) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1" style="min-width: 0;">
                                            <p class="mb-0 fw-semibold text-truncate">
                                                {{ $member->name }}
                                            </p>
                                            @if($member->isVerified())
                                                <span class="small text-success">✓ Verificado</span>
                                            @else
                                                <span class="small text-muted">Não verificado</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="text-muted fs-3 mb-2">👥</div>
                            <p class="text-muted mb-0">Nenhum membro cadastrado no grupo ainda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para visualizar PDF -->
    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">{{ $schedule->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="pdfFrame" class="w-100 border-0" style="height: 75vh;"></iframe>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>