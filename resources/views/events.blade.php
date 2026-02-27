@extends('layouts.public')

@section('title', 'Eventos - Paróquia São Paulo Apóstolo')
@section('description', 'Acompanhe os eventos, celebrações especiais e atividades da Paróquia São Paulo Apóstolo em Umuarama.')

@section('content')
<x-public.hero
    title="Eventos"
    subtitle="Acompanhe nossa agenda paroquial"
    description="Celebrações especiais, encontros e atividades para toda a comunidade." />

<section class="section-paroquia">
    <div class="sp-page-container">
        @if($events->count() > 0)
            <x-public.section-header
                title="Próximos Eventos"
                subtitle="Participe da vida pastoral da nossa comunidade através dos eventos programados." />

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach($events as $event)
                    <div>
                        <div class="card-paroquia h-full">
                            <div class="card-header-paroquia">
                                <h5 class="mb-2">{{ $event->title }}</h5>
                                <small class="block text-gray-600">
                                    <i data-lucide="calendar-days" class="icon-paroquia"></i>
                                    {{ $event->start_date->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <div class="card-body flex flex-col">
                                <p class="grow text-gray-600">{{ Str::limit(strip_tags($event->description ?? ''), 140) }}</p>
                                @if($event->location)
                                    <p class="mb-0 text-gray-600"><i data-lucide="map-pin" class="icon-paroquia"></i>{{ $event->location }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($events->hasPages())
                <div class="mt-5 flex justify-center">
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
