@extends('admin.layout')

@section('title', 'Minha Área - Paróquia São Paulo Apóstolo')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Page Header -->
    <div class="card border-0 shadow-lg mb-4" style="background: linear-gradient(135deg, #6B7280 0%, #4B5563 50%, #6B7280 100%); border-radius: 20px;">
        <div class="card-body text-white py-4 px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="display-6 fw-bold mb-2" style="color: #FFFFFF;">
                        <i class="bi bi-house-heart-fill me-2"></i>Bem-vindo, {{ $user->name }}!
                    </h1>
                    <p class="mb-0" style="color: #FFD66B; font-size: 1.1rem;">
                        Acompanhe as novidades e eventos da Paróquia São Paulo Apóstolo
                    </p>
                </div>
                <div class="text-end d-flex align-items-center gap-3">
                    @if(Auth::user()->profile_photo_path)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" 
                             alt="{{ Auth::user()->name }}" 
                             class="rounded-circle" 
                             style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #FFD66B;">
                    @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; border: 3px solid #FFD66B;">
                            <span class="display-4 text-dark">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    @endif
                    <a href="{{ route('home') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-globe me-1"></i> Ver Site Público
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <a href="{{ route('news') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body text-center py-4">
                        <i class="bi bi-newspaper" style="font-size: 3rem; color: #8B1538;"></i>
                        <h5 class="mt-3 mb-0">Notícias</h5>
                        <p class="text-muted small mb-0">Veja as últimas novidades</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('events') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body text-center py-4">
                        <i class="bi bi-calendar-event" style="font-size: 3rem; color: #8B1538;"></i>
                        <h5 class="mt-3 mb-0">Eventos</h5>
                        <p class="text-muted small mb-0">Confira a programação</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('masses') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body text-center py-4">
                        <i class="bi bi-calendar-week" style="font-size: 3rem; color: #8B1538;"></i>
                        <h5 class="mt-3 mb-0">Missas</h5>
                        <p class="text-muted small mb-0">Horários das celebrações</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('groups') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body text-center py-4">
                        <i class="bi bi-people-fill" style="font-size: 3rem; color: #8B1538;"></i>
                        <h5 class="mt-3 mb-0">Pastorais</h5>
                        <p class="text-muted small mb-0">Conheça os grupos</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Últimas Notícias -->
        <div class="col-lg-8">
            @if($user->parishGroup && $user->parishGroup->id == 5)
                <!-- Seção de Escalas para Coroinhas -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">
                                <i class="bi bi-calendar3 text-success"></i> Escalas dos Coroinhas
                            </h5>
                            <a href="{{ route('user.scales.index') }}" class="btn btn-sm btn-outline-success">
                                Ver Todas <i class="bi bi-arrow-right"></i>
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
                                    <i class="bi bi-file-earmark-pdf text-danger" style="font-size: 2rem;"></i>
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
                                <i class="bi bi-calendar-x" style="font-size: 2rem; color: #ddd;"></i>
                                <p class="text-muted small mt-2 mb-0">Nenhuma escala disponível no momento.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-newspaper text-primary"></i> Últimas Notícias
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($recentNews as $news)
                        <div class="d-flex mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            @if($news->featured_image)
                                <img src="{{ asset('storage/' . $news->featured_image) }}" 
                                     alt="{{ $news->title }}" 
                                     class="rounded me-3"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                     style="width: 80px; height: 80px;">
                                    <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="#" class="text-decoration-none text-dark">{{ $news->title }}</a>
                                </h6>
                                <p class="text-muted small mb-1">{{ Str::limit($news->summary ?? $news->content, 100) }}</p>
                                <small class="text-muted">
                                    <i class="bi bi-calendar"></i> {{ $news->published_at?->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="bi bi-newspaper" style="font-size: 3rem; color: #ddd;"></i>
                            <p class="text-muted mt-2 mb-0">Nenhuma notícia publicada ainda.</p>
                        </div>
                    @endforelse

                    @if($recentNews->count() > 0)
                        <div class="text-center mt-3">
                            <a href="{{ route('news') }}" class="btn btn-outline-primary">
                                Ver Todas as Notícias <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Próximos Eventos -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-calendar-event text-success"></i> Próximos Eventos
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($upcomingEvents as $event)
                        <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <h6 class="mb-1">{{ $event->title }}</h6>
                            <small class="text-muted">
                                <i class="bi bi-calendar"></i> {{ $event->start_date->format('d/m/Y') }}
                                @if($event->start_time)
                                    - {{ $event->start_time }}
                                @endif
                            </small>
                            @if($event->location)
                                <br>
                                <small class="text-muted">
                                    <i class="bi bi-geo-alt"></i> {{ $event->location }}
                                </small>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-3">
                            <i class="bi bi-calendar-x" style="font-size: 2rem; color: #ddd;"></i>
                            <p class="text-muted small mt-2 mb-0">Nenhum evento agendado.</p>
                        </div>
                    @endforelse

                    @if($upcomingEvents->count() > 0)
                        <div class="text-center mt-3">
                            <a href="{{ route('events') }}" class="btn btn-sm btn-outline-success">
                                Ver Todos <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Horários de Missas -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-clock text-warning"></i> Horários de Missas
                    </h5>
                </div>
                <div class="card-body">
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

                    @forelse($masses->groupBy('day_of_week') as $day => $dayMasses)
                        <div class="mb-3">
                            <strong class="text-primary">{{ $daysOfWeek[$day] ?? $day }}</strong>
                            @foreach($dayMasses as $mass)
                                <div class="text-muted small">
                                    <i class="bi bi-clock"></i> {{ $mass->time }}
                                    @if($mass->type)
                                        - {{ $mass->type }}
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @empty
                        <div class="text-center py-3">
                            <i class="bi bi-calendar-x" style="font-size: 2rem; color: #ddd;"></i>
                            <p class="text-muted small mt-2 mb-0">Horários não disponíveis.</p>
                        </div>
                    @endforelse

                    @if($masses->count() > 0)
                        <div class="text-center mt-3">
                            <a href="{{ route('masses') }}" class="btn btn-sm btn-outline-warning">
                                Ver Detalhes <i class="bi bi-arrow-right"></i>
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
