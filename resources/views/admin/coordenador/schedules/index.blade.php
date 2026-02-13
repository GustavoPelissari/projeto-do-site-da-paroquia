@extends('admin.layout')

@section('title', 'Escalas legadas')

@section('content')
<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
    <div>
        <p class="admin-overline mb-1">Coordenação pastoral</p>
        <h2 class="h3 mb-0">Escalas legadas do grupo</h2>
    </div>
    <span class="badge text-bg-light border">Cadastro disponível em breve</span>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($schedules->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Período</th>
                            <th>Status</th>
                            <th class="text-end">Arquivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $schedule)
                            @php $badge = $schedule->getStatusBadge(); @endphp
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $schedule->title }}</div>
                                    <small class="text-secondary">{{ Str::limit($schedule->description ?: 'Sem descrição', 90) }}</small>
                                </td>
                                <td>{{ $schedule->start_date?->format('d/m/Y') }} - {{ $schedule->end_date?->format('d/m/Y') }}</td>
                                <td><span class="badge text-bg-secondary">{{ $badge['text'] }}</span></td>
                                <td class="text-end">
                                    @if($schedule->pdf_path)
                                        <a class="btn btn-sm btn-outline-secondary" href="{{ Storage::url($schedule->pdf_path) }}" target="_blank" rel="noopener">Abrir PDF</a>
                                    @else
                                        <span class="text-secondary small">Sem arquivo</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-4 text-center text-secondary">Nenhuma escala legada cadastrada para o grupo.</div>
        @endif
    </div>
</div>

@if($schedules->hasPages())
    <div class="mt-4">{{ $schedules->links() }}</div>
@endif
@endsection
