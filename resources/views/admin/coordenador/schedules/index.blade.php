@extends('admin.layout')

@section('title', 'Escalas Legadas')

@section('content')
<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
    <div>
        <p class="admin-overline mb-1">Coordenação pastoral</p>
        <h2 class="h3 mb-0">Escalas legadas do grupo</h2>
    </div>
    <a href="{{ route('admin.coordenador.schedules.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i>Nova escala</a>
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
                            <th class="text-end">Ações</th>
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
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.coordenador.schedules.edit', $schedule->id) }}" class="btn btn-outline-primary">Editar</a>
                                        <form method="POST" action="{{ route('admin.coordenador.schedules.destroy', $schedule->id) }}" onsubmit="return confirm('Remover esta escala?')">
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
            <div class="p-4 text-center text-secondary">Nenhuma escala legada cadastrada para o grupo.</div>
        @endif
    </div>
</div>

@if($schedules->hasPages())
    <div class="mt-4">{{ $schedules->links() }}</div>
@endif
@endsection
