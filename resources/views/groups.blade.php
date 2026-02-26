@extends('layouts.public')

@section('title', 'Pastorais e Movimentos - Paróquia São Paulo Apóstolo')
@section('description', 'Conheça as pastorais e movimentos da Paróquia São Paulo Apóstolo em Umuarama. Encontre seu lugar de serviço e crescimento espiritual em nossa comunidade de fé.')

@section('content')
<x-public.hero
    title="Pastorais e Movimentos"
    subtitle="Conheça nossos grupos paroquiais e encontre seu lugar na nossa comunidade de fé"
    description="Seguindo o exemplo missionário de São Paulo Apóstolo, cada pastoral tem sua missão especial na construção do Reino de Deus." />

<section class="section-paroquia section-bg-bege">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-center gap-2" id="category-filters">
            <button class="btn-paroquia btn-outline-paroquia active" data-category="all"><i data-lucide="grid-3x3" class="icon-paroquia"></i>Todas</button>
            <button class="btn-paroquia btn-outline-paroquia" data-category="catequese"><i data-lucide="graduation-cap" class="icon-paroquia"></i>Catequese</button>
            <button class="btn-paroquia btn-outline-paroquia" data-category="liturgia"><i data-lucide="church" class="icon-paroquia"></i>Liturgia</button>
            <button class="btn-paroquia btn-outline-paroquia" data-category="caridade"><i data-lucide="heart-handshake" class="icon-paroquia"></i>Caridade</button>
            <button class="btn-paroquia btn-outline-paroquia" data-category="jovens"><i data-lucide="zap" class="icon-paroquia"></i>Jovens</button>
        </div>
    </div>
</section>

<section class="section-paroquia">
    <div class="container">
        @if($groups->count() > 0)
            <x-public.section-header
                title="Nossos Grupos Ativos"
                subtitle="Cada grupo tem sua missão especial na construção do Reino de Deus. Encontre aquele que mais se alinha com seu carisma e chamado." />

            <div class="row g-4" id="groups-container">
                @foreach($groups as $group)
                    <div class="col-lg-4 col-md-6 group-card-item" data-category="{{ $group->category ?? 'geral' }}">
                        <div class="card-paroquia h-100">
                            <div class="card-header-paroquia text-center">
                                <div class="mb-3">
                                    @switch($group->category ?? 'geral')
                                        @case('catequese') <i data-lucide="graduation-cap" class="icon-lg text-vermelho"></i> @break
                                        @case('liturgia') <i data-lucide="church" class="icon-lg text-vermelho"></i> @break
                                        @case('caridade') <i data-lucide="heart-handshake" class="icon-lg text-vermelho"></i> @break
                                        @case('jovens') <i data-lucide="zap" class="icon-lg text-vermelho"></i> @break
                                        @default <i data-lucide="users" class="icon-lg text-vermelho"></i>
                                    @endswitch
                                </div>
                                <h4 class="mb-0">{{ $group->name }}</h4>
                                <small class="text-muted text-uppercase">{{ ucfirst($group->category ?? 'Pastoral') }}</small>
                            </div>

                            <div class="card-body d-flex flex-column">
                                <p class="text-muted flex-grow-1">{{ $group->description ?? 'Grupo ativo da nossa paróquia.' }}</p>
                                <div class="public-meta-box mb-3 text-center">
                                    <small class="text-muted d-block">Coordenador(a):</small>
                                    <strong>{{ $group->coordinator->name ?? 'A definir' }}</strong>
                                </div>
                                <div class="text-center mt-auto">
                                    @auth
                                        <a href="{{ route('group-requests.create', ['group' => $group->id]) }}" class="btn-paroquia btn-primary-paroquia">
                                            <i data-lucide="user-plus" class="icon-paroquia"></i>Participar
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn-paroquia btn-outline-paroquia">
                                            <i data-lucide="log-in" class="icon-paroquia"></i>Entrar para Participar
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <x-public.empty-state
                icon="users"
                title="Nenhum grupo encontrado"
                description="Ainda não temos grupos cadastrados, mas em breve teremos várias opções para você participar da nossa comunidade." />
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const categoryFilters = document.querySelectorAll('#category-filters [data-category]');
    const groupCards = document.querySelectorAll('.group-card-item');

    categoryFilters.forEach((filter) => {
        filter.addEventListener('click', function () {
            const category = this.dataset.category;

            categoryFilters.forEach((btn) => btn.classList.remove('active'));
            this.classList.add('active');

            groupCards.forEach((card) => {
                const visible = category === 'all' || card.dataset.category === category;
                card.classList.toggle('d-none', !visible);
            });
        });
    });
});
</script>
@endpush
