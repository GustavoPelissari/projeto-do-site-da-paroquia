@extends('admin.layout')

@section('title', 'Minha Área - Paróquia São Paulo Apóstolo')

@section('content')
<div class="container-fluid px-2 px-md-4 py-3 py-md-4">
    <!-- Page Header -->
    <div class="card border-0 shadow-lg mb-3 mb-md-4" style="background: linear-gradient(135deg, var(--brand-vinho) 0%, var(--brand-vinho-dark) 100%); border-radius: 15px;">
        <div class="card-body text-white py-3 px-3 py-md-4 px-md-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h3 h2-md fw-bold mb-2">
                        <i class="bi bi-house-heart-fill me-2" aria-hidden="true"></i>Bem-vindo, {{ $user->name }}!
                    </h1>
                    <p class="mb-2 opacity-90 small d-none d-md-block" style="font-size: 1.1rem;">
                        Acompanhe as novidades e eventos da Paróquia São Paulo Apóstolo
                    </p>
                    @if($user->email_verified_at)
                        <small class="opacity-75">
                            <i class="bi bi-check-circle-fill me-1" aria-hidden="true"></i> E-mail verificado
                        </small>
                    @else
                        <small class="bg-warning text-dark px-2 py-1 rounded">
                            <i class="bi bi-exclamation-triangle me-1" aria-hidden="true"></i> E-mail não verificado
                        </small>
                    @endif
                </div>
                <div class="col-md-4 text-center text-md-end d-none d-md-block">
                    @if(Auth::user()->profile_photo_path)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" 
                             alt="{{ Auth::user()->name }}" 
                             class="rounded-circle" 
                             style="width: 100px; height: 100px; object-fit: cover; border: 4px solid rgba(255,255,255,0.3);">
                    @else
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" 
                             style="width: 100px; height: 100px; border: 4px solid rgba(255,255,255,0.3);">
                            <span class="display-3 text-dark">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Atalhos Rápidos -->
    <div class="row g-2 g-md-3 mb-3 mb-md-4">
        <div class="col-6 col-md-3">
            <a href="{{ route('news') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body text-center p-2 p-md-3">
                        <div class="text-primary mb-1 mb-md-2">
                            <i class="bi bi-newspaper" style="font-size: 2rem;" aria-hidden="true"></i>
                        </div>
                        <h4 class="mb-0 fw-bold h5">{{ $recentNews->count() }}</h4>
                        <small class="text-muted" style="font-size: 0.7rem;">Notícias</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('events') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body text-center p-2 p-md-3">
                        <div class="text-success mb-1 mb-md-2">
                            <i class="bi bi-calendar-event" style="font-size: 2rem;" aria-hidden="true"></i>
                        </div>
                        <h4 class="mb-0 fw-bold h5">{{ $upcomingEvents->count() }}</h4>
                        <small class="text-muted" style="font-size: 0.7rem;">Eventos</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('masses') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body text-center p-2 p-md-3">
                        <div class="text-warning mb-1 mb-md-2">
                            <i class="bi bi-clock" style="font-size: 2rem;" aria-hidden="true"></i>
                        </div>
                        <h4 class="mb-0 fw-bold h5">{{ $masses->count() }}</h4>
                        <small class="text-muted" style="font-size: 0.7rem;">Missas</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('groups') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body text-center p-2 p-md-3">
                        <div class="text-info mb-1 mb-md-2">
                            <i class="bi bi-people" style="font-size: 2rem;" aria-hidden="true"></i>
                        </div>
                        <h4 class="mb-0 fw-bold h5">{{ $totalGroups }}</h4>
                        <small class="text-muted" style="font-size: 0.7rem;">Pastorais</small>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row g-3 g-md-4">
        <!-- Últimas Notícias -->
        <div class="col-12 col-lg-8">
            @if($user->parishGroup && $user->parishGroup->id == 5)
                <!-- Seção de Escalas para Coroinhas -->
                <div class="card border-0 shadow-sm mb-3 mb-md-4">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">
                                <i class="bi bi-calendar3 text-success" aria-hidden="true"></i> Escalas dos Coroinhas
                            </h5>
                            <a href="{{ route('user.scales.index') }}" class="btn btn-sm btn-outline-success">
                                Ver Todas <i class="bi bi-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            $userScales = \App\Models\Scale::where('group_id', 5)
                                ->where('valid_until', '>=', now())
                                ->latest()
                                ->take(3)
                                ->get();
                        @endphp

                        @forelse($userScales as $scale)
                            <div class="d-flex mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div class="bg-success bg-opacity-10 rounded me-3 d-flex align-items-center justify-content-center"
                                     style="width: 60px; height: 60px; min-width: 60px;">
                                    <i class="bi bi-file-earmark-pdf text-danger" style="font-size: 2rem;" aria-hidden="true"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $scale->title }}</h6>
                                    <p class="text-muted small mb-1">{{ Str::limit($scale->description, 80) }}</p>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar-range"></i> 
                                        {{ $scale->valid_from->format('d/m/Y') }} até {{ $scale->valid_until->format('d/m/Y') }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    <a href="{{ route('user.scales.download', $scale) }}" 
                                       class="btn btn-sm btn-success" 
                                       title="Baixar PDF">
                                        <i class="bi bi-download"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-3">
                                <i class="bi bi-calendar-x" aria-hidden="true" style="font-size: 2rem; color: #ddd;"></i>
                                <p class="text-muted small mt-2 mb-0">Nenhuma escala disponível no momento.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif

            <div class="card border-0 shadow-sm mb-3 mb-md-4">
                <div class="card-header bg-white border-0 py-2 py-md-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">
                            <i class="bi bi-newspaper text-primary" aria-hidden="true"></i> Últimas Notícias
                        </h5>
                        @if($recentNews->count() > 0)
                            <a href="{{ route('news') }}" class="btn btn-sm btn-outline-primary">
                                Ver Todas <i class="bi bi-arrow-right" aria-hidden="true"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body p-2 p-md-3">
                    @forelse($recentNews->take(3) as $news)
                        <div class="card border mb-2 mb-md-3 hover-card">
                            <div class="row g-0">
                                <div class="col-5 col-md-4">
                                    @if($news->featured_image)
                                        <img src="{{ asset('storage/' . $news->featured_image) }}" 
                                            alt="{{ $news->title }}" 
                                            class="img-fluid w-100 h-100"
                                            style="object-fit: cover; border-radius: 0.375rem 0 0 0.375rem;" loading="lazy">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center h-100"
                                             style="border-radius: 0.375rem 0 0 0.375rem;">
                                            <i class="bi bi-image text-muted" aria-hidden="true" style="font-size: 2.5rem;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="card-body p-2 p-md-3">
                                        <h6 class="card-title mb-1 mb-md-2 small">
                                            <a href="#" class="text-decoration-none text-dark stretched-link">
                                                {{ Str::limit($news->title, 60) }}
                                            </a>
                                        </h6>
                                        <p class="card-text text-muted small mb-1 mb-md-2 d-none d-md-block">
                                            {{ Str::limit($news->summary ?? $news->content, 70) }}
                                        </p>
                                        <small class="text-muted" style="font-size: 0.7rem;">
                                            <i class="bi bi-calendar" aria-hidden="true"></i> {{ $news->published_at?->format('d/m/Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-newspaper" aria-hidden="true" style="font-size: 4rem; color: #ddd;"></i>
                            <p class="text-muted mt-3 mb-0">Nenhuma notícia publicada ainda.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-12 col-lg-4">
            <!-- Próximos Eventos -->
            <div class="card border-0 shadow-sm mb-3 mb-md-4">
                <div class="card-header bg-success text-white border-0 py-2 py-md-3">
                    <h5 class="mb-0">
                        <i class="bi bi-calendar-event" aria-hidden="true"></i> Próximos Eventos
                    </h5>
                </div>
                <div class="card-body p-2 p-md-3">
                    @forelse($upcomingEvents->take(4) as $event)
                        <div class="card border-start border-success border-3 border-md-4 mb-2 mb-md-3 shadow-sm">
                            <div class="card-body p-2 p-md-3">
                                <h6 class="mb-1 mb-md-2 fw-bold small">{{ Str::limit($event->title, 40) }}</h6>
                                <div class="small text-muted mb-1" style="font-size: 0.75rem;">
                                    <i class="bi bi-calendar3" aria-hidden="true"></i> {{ $event->start_date->format('d/m/Y') }}
                                    @if($event->start_time)
                                        às {{ $event->start_time }}
                                    @endif
                                </div>
                                @if($event->location)
                                    <div class="small text-muted d-none d-md-block">
                                        <i class="bi bi-geo-alt-fill" aria-hidden="true"></i> {{ Str::limit($event->location, 30) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="bi bi-calendar-x" aria-hidden="true" style="font-size: 3rem; color: #ddd;"></i>
                            <p class="text-muted mt-2 mb-0">Nenhum evento agendado.</p>
                        </div>
                    @endforelse

                    @if($upcomingEvents->count() > 0)
                        <div class="d-grid">
                            <a href="{{ route('events') }}" class="btn btn-outline-success btn-sm">
                                Ver Todos os Eventos <i class="bi bi-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Horários de Missas -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark border-0 py-2 py-md-3">
                    <h5 class="mb-0">
                        <i class="bi bi-clock"></i> Horários de Missas
                    </h5>
                </div>
                <div class="card-body p-2 p-md-3">
                    @php
                        $daysOfWeek = [
                            0 => 'Domingo',
                            1 => 'Segunda',
                            2 => 'Terça',
                            3 => 'Quarta',
                            4 => 'Quinta',
                            5 => 'Sexta',
                            6 => 'Sábado',
                            'sunday' => 'Domingo',
                            'monday' => 'Segunda',
                            'tuesday' => 'Terça',
                            'wednesday' => 'Quarta',
                            'thursday' => 'Quinta',
                            'friday' => 'Sexta',
                            'saturday' => 'Sábado'
                        ];
                    @endphp

                    @forelse($masses->groupBy('day_of_week')->take(4) as $day => $dayMasses)
                        <div class="card border-start border-warning border-3 border-md-4 mb-2 shadow-sm">
                            <div class="card-body p-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2 me-md-3 d-none d-md-block">
                                        <div class="bg-warning bg-opacity-10 rounded p-2">
                                            <i class="bi bi-calendar-day text-warning" style="font-size: 1.5rem;"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <strong class="text-dark d-block mb-1 small">{{ $daysOfWeek[$day] ?? $day }}</strong>
                                        @foreach($dayMasses as $mass)
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">
                                                <i class="bi bi-clock-fill"></i> {{ $mass->time }}
                                                @if($mass->type)
                                                    <span class="badge bg-light text-dark" style="font-size: 0.65rem;">{{ $mass->type }}</span>
                                                @endif
                                            </small>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="bi bi-calendar-x" style="font-size: 3rem; color: #ddd;"></i>
                            <p class="text-muted mt-2 mb-0">Horários não disponíveis.</p>
                        </div>
                    @endforelse

                    @if($masses->count() > 0)
                        <div class="d-grid mt-3">
                            <a href="{{ route('masses') }}" class="btn btn-outline-warning btn-sm">
                                Ver Todos os Horários <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(139, 21, 56, 0.15) !important;
}
</style>
@endsection
