@extends('layout')

@section('title', 'Sobre a Paróquia - Paróquia São Paulo Apóstolo')

@section('content')
<!-- Hero Section -->
<x-hero title="Sobre Nossa Paróquia" subtitle="Conheça a história e missão da Paróquia São Paulo Apóstolo">
    <p class="mb-0" style="opacity: 0.9;">
        "Ide por todo o mundo e pregai o Evangelho a toda criatura" - Mc 16,15
    </p>
</x-hero>

<!-- Clero -->
<section class="section-paroquia bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="mb-3">Nosso Clero</h2>
            <p class="lead text-muted">Conheça os sacerdotes que servem nossa comunidade</p>
        </div>

        <div class="row g-4 justify-content-center">
            @forelse($clergy as $member)
                <div class="col-lg-5 col-md-6">
                    <div class="card-paroquia h-100 overflow-hidden">
                        <div style="position: relative; background: white;">
                            @if($member->photo)
                                <img src="{{ asset($member->photo) }}" 
                                     alt="{{ $member->name }}" 
                                     class="w-100"
                                     style="height: 450px; object-fit: contain;">
                            @else
                                <div class="w-100 d-flex align-items-center justify-content-center"
                                     style="height: 400px; background: linear-gradient(135deg, var(--vermelho) 0%, var(--vermelho-profundo) 100%);">
                                    <i data-lucide="user" style="width: 120px; height: 120px; color: white;"></i>
                                </div>
                            @endif
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(139, 28, 35, 0.95), transparent); padding: 60px 20px 20px;">
                                <h3 class="h4 fw-bold mb-2 text-white text-center">
                                    {{ $member->name }}
                                </h3>
                                <div class="text-center">
                                    <span class="badge" style="background-color: var(--dourado); color: white; font-size: 0.95rem; padding: 6px 16px; font-weight: 600;">
                                        {{ $member->role_name }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body-paroquia" style="padding: 25px;">
                            @if($member->bio)
                                <p class="text-muted mb-3" style="line-height: 1.6;">{{ $member->bio }}</p>
                            @endif

                            @if($member->email || $member->phone)
                                <div class="border-top pt-3 mt-3">
                                    @if($member->email)
                                        <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                                            <i data-lucide="mail" class="icon-paroquia text-vermelho"></i>
                                            <small class="text-muted">{{ $member->email }}</small>
                                        </div>
                                    @endif
                                    @if($member->phone)
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <i data-lucide="phone" class="icon-paroquia text-vermelho"></i>
                                            <small class="text-muted">{{ $member->phone }}</small>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Informações do clero serão atualizadas em breve.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Capelas -->
<section class="section-paroquia section-bg-bege">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="mb-3">Nossas Capelas</h2>
            <p class="lead text-muted">Conheça as capelas vinculadas à nossa paróquia</p>
        </div>

        <div class="row g-4">
            @forelse($chapels as $chapel)
                <div class="col-lg-6">
                    <div class="card-paroquia h-100 overflow-hidden">
                        @if($chapel->image)
                            <div style="position: relative;">
                                <img src="{{ asset($chapel->image) }}?v={{ time() }}" 
                                     alt="{{ $chapel->name }}" 
                                     class="w-100"
                                     style="height: 300px; object-fit: cover;">
                                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: var(--vermelho); padding: 20px;">
                                    <h3 class="mb-0 text-white text-center">{{ $chapel->name }}</h3>
                                </div>
                            </div>
                        @endif
                        <div class="card-body-paroquia">
                            <div class="mb-3">
                                <div class="d-flex align-items-start gap-2 mb-2">
                                    <i data-lucide="map-pin" class="icon-paroquia text-vermelho mt-1"></i>
                                    <div>
                                        <strong>Endereço:</strong><br>
                                        {{ $chapel->address }}
                                        @if($chapel->neighborhood)
                                            <br>Bairro {{ $chapel->neighborhood }}
                                        @endif
                                        <br>{{ $chapel->city }} - {{ $chapel->state }}
                                    </div>
                                </div>
                            </div>

                            @if($chapel->description)
                                <div class="d-flex align-items-start gap-2 mb-3">
                                    <i data-lucide="clock" class="icon-paroquia text-verde mt-1"></i>
                                    <div>
                                        <strong>Horário:</strong><br>
                                        {{ $chapel->description }}
                                    </div>
                                </div>
                            @endif

                            @if($chapel->map_link)
                                <div class="mt-3">
                                    <a href="{{ $chapel->map_link }}" 
                                       target="_blank" 
                                       class="btn-paroquia btn-primary-paroquia w-100">
                                        <i data-lucide="map" class="icon-paroquia"></i>
                                        Ver no Mapa
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Informações das capelas serão atualizadas em breve.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- História da Paróquia -->
<section class="section-paroquia bg-white">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <img src="{{ asset('images/Imagem_da_paroquia.png') }}" 
                     alt="Igreja Matriz São Paulo Apóstolo" 
                     class="img-fluid rounded shadow-lg"
                     style="border-radius: 15px !important;">
            </div>
            <div class="col-lg-6">
                <h2 class="mb-4">Nossa História</h2>
                <p class="text-muted mb-3">
                    A Paróquia São Paulo Apóstolo é uma comunidade vibrante de fé, 
                    localizada na Diocese de Umuarama, servindo aos fiéis com dedicação 
                    e amor ao Evangelho.
                </p>
                <p class="text-muted mb-3">
                    Nossa missão é levar a Palavra de Deus a todos, promover a evangelização 
                    e fortalecer a comunhão entre os irmãos através da liturgia, dos sacramentos 
                    e do serviço aos mais necessitados.
                </p>
                <p class="text-muted mb-4">
                    Com diversas pastorais e grupos ativos, buscamos ser sal da terra e luz do mundo, 
                    testemunhando o amor de Cristo em cada ação.
                </p>
                <a href="{{ route('groups') }}" class="btn-paroquia btn-primary-paroquia">
                    <i data-lucide="users" class="icon-paroquia"></i>
                    Conheça Nossas Pastorais
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>
@endpush
