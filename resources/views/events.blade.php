@extends('layouts.public')

@section('title', 'Eventos - Paróquia São Paulo Apóstolo')
@section('description', 'Acompanhe os eventos, celebrações especiais e atividades da Paróquia São Paulo Apóstolo em Umuarama.')

@section('content')
<x-public.hero
    title="Eventos"
    subtitle="Acompanhe nossa agenda paroquial"
    description="Celebrações especiais, encontros e atividades para toda a comunidade." />

<section class="section-paroquia">
    <div class="container">
        @if($events->count() > 0)
            <x-public.section-header
                title="Próximos Eventos"
                subtitle="Participe da vida pastoral da nossa comunidade através dos eventos programados." />

            <div class="row g-4">
                @foreach($events as $event)
                    <div class="col-lg-4 col-md-6">
                        <div class="card-paroquia h-100">
                            <div class="card-header-paroquia">
                                <h5 class="mb-2">{{ $event->title }}</h5>
                                <small class="text-muted d-block">
                                    <i data-lucide="calendar-days" class="icon-paroquia"></i>
                                    {{ $event->start_date->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <p class="text-muted flex-grow-1">{{ Str::limit(strip_tags($event->description ?? ''), 140) }}</p>
                                @if($event->location)
                                    <p class="mb-0 text-muted"><i data-lucide="map-pin" class="icon-paroquia"></i>{{ $event->location }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($events->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $events->links() }}
                </div>
            @endif
        @else
            <x-public.empty-state
                icon="calendar-x-2"
                title="Nenhum evento programado"
                description="Ainda não há eventos publicados. Volte em breve para acompanhar a programação paroquial." />
        @endif
    </div>
</section>
@endsection
