@extends('layouts.public')

@section('title', 'Pastorais e Movimentos - Paróquia São Paulo Apóstolo')
@section('description', 'Conheça as pastorais e movimentos da Paróquia São Paulo Apóstolo em Umuarama.')

@section('content')
<section class="py-5 bg-dark text-white text-center">
    <div class="container py-4">
        <h1 class="display-6 fw-bold mb-3">Pastorais e Movimentos</h1>
        <p class="lead mb-0">Conheça nossos grupos paroquiais e encontre seu lugar na comunidade.</p>
    </div>
</section>

<section class="py-4 bg-light">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-center gap-2" id="category-filters">
            <button class="btn btn-outline-primary active" data-category="all">Todas</button>
            <button class="btn btn-outline-primary" data-category="catequese">Catequese</button>
            <button class="btn btn-outline-primary" data-category="liturgia">Liturgia</button>
            <button class="btn btn-outline-primary" data-category="caridade">Caridade</button>
            <button class="btn btn-outline-primary" data-category="jovens">Jovens</button>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if($groups->count() > 0)
            <div class="text-center mb-4">
                <h2 class="h3">Nossos Grupos Ativos</h2>
                <p class="text-muted mb-0">Cada grupo tem sua missão especial na construção do Reino de Deus.</p>
            </div>
            <div class="row g-4" id="groups-container">
                @foreach($groups as $group)
                <div class="col-lg-4 col-md-6 group-card-item" data-category="{{ $group->category ?? 'geral' }}">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h3 class="h5 text-primary mb-0">{{ $group->name }}</h3>
                                <span class="badge bg-secondary">{{ ucfirst($group->category ?? 'Pastoral') }}</span>
                            </div>

                            @if($group->description)
                                <p class="text-muted flex-grow-1">{{ $group->description }}</p>
                            @endif

                            @if($group->coordinator_id)
                                <p class="small mb-2"><strong>Coordenador(a):</strong> {{ $group->coordinator->name ?? 'A definir' }}</p>
                            @endif

                            @if($group->meeting_day || $group->meeting_time)
                                <p class="small text-muted mb-2">
                                    <strong>Encontro:</strong>
                                    @if($group->meeting_day) {{ ucfirst($group->meeting_day) }} @endif
                                    @if($group->meeting_time) às {{ $group->meeting_time }} @endif
                                </p>
                            @endif

                            @if($group->users_count > 0)
                                <p class="small text-muted mb-3">{{ $group->users_count }} membros ativos</p>
                            @endif

                            <div class="mt-auto">
                                @auth
                                    @if($group->max_members && $group->users_count >= $group->max_members)
                                        <button class="btn btn-secondary w-100" disabled>Grupo Completo</button>
                                    @else
                                        <a href="{{ route('group-requests.create', ['group' => $group->id]) }}" class="btn btn-primary w-100">Participar</a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">Entrar para Participar</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="card shadow-sm text-center">
                <div class="card-body py-5">
                    <h3 class="h4 text-muted">Nenhum grupo encontrado</h3>
                    <p class="text-muted mb-0">Ainda não temos grupos cadastrados no momento.</p>
                </div>
            </div>
        @endif
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body p-4 p-lg-5">
                <h2 class="h4 mb-4 text-primary">Como Participar de uma Pastoral?</h2>
                <div class="row g-3 mb-4">
                    <div class="col-md-4"><div class="border rounded p-3 h-100"><strong>1.</strong> Escolha uma pastoral</div></div>
                    <div class="col-md-4"><div class="border rounded p-3 h-100"><strong>2.</strong> Solicite participação</div></div>
                    <div class="col-md-4"><div class="border rounded p-3 h-100"><strong>3.</strong> Aguarde aprovação</div></div>
                </div>
                <div class="d-flex flex-column flex-sm-row gap-3">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-primary">Criar Conta</a>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">Já tenho conta</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">Meu Painel</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryFilters = document.querySelectorAll('#category-filters [data-category]');
    const groupCards = document.querySelectorAll('.group-card-item');

    categoryFilters.forEach(filter => {
        filter.addEventListener('click', function() {
            const category = this.dataset.category;

            categoryFilters.forEach(btn => {
                btn.classList.remove('active');
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-outline-primary');
            });

            this.classList.add('active');
            this.classList.remove('btn-outline-primary');
            this.classList.add('btn-primary');

            groupCards.forEach(card => {
                const cardCategory = card.dataset.category;
                card.classList.toggle('d-none', !(category === 'all' || cardCategory === category));
            });
        });
    });
});
</script>
@endpush
