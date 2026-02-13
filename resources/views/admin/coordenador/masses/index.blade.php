@extends('admin.layout')

@section('title', 'Horários de Missa')

@section('content')
<div class="mb-4">
    <p class="admin-overline mb-1">Coordenação pastoral</p>
    <h2 class="h3 mb-0">Horários de missa</h2>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($masses->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Dia</th>
                            <th>Horário</th>
                            <th>Local</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($masses as $mass)
                            <tr>
                                <td>{{ $mass->name }}</td>
                                <td>{{ $mass->day_name }}</td>
                                <td>{{ $mass->time->format('H:i') }}</td>
                                <td>{{ $mass->location }}</td>
                                <td><span class="badge {{ $mass->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $mass->is_active ? 'Ativo' : 'Inativo' }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-4 text-center text-secondary">Nenhum horário de missa cadastrado.</div>
        @endif
    </div>
</div>

@if($masses->hasPages())
    <div class="mt-4">{{ $masses->links() }}</div>
@endif
@endsection
