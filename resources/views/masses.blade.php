@extends('layouts.public')

@section('title', 'Horários de Missas - Paróquia São Paulo Apóstolo')
@section('description', 'Confira os horários das celebrações eucarísticas na Paróquia São Paulo Apóstolo em Umuarama - PR. Missas aos domingos, quartas, sábados e celebrações especiais.')

@section('content')
<x-public.hero
    title="Horários de Missas"
    subtitle="Confira os horários das nossas celebrações eucarísticas"
    description='"Fazei isto em memória de mim" - Venha participar da mesa eucarística e fortalecer sua fé em comunidade.' />

<section class="section-paroquia">
    <div class="sp-page-container">
        <x-public.section-header
            title="Horários Regulares"
            subtitle="Nossas celebrações semanais estão organizadas para atender toda a comunidade." />

        @if($masses->count() > 0)
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($masses as $mass)
                    <div>
                        <div class="card-paroquia h-full p-4 text-center">
                            <h5 class="text-vermelho mb-3 capitalize">{{ $mass->day_of_week }}</h5>
                            <i data-lucide="clock" class="icon-lg text-dourado mb-3"></i>
                            <h4 class="mb-2">{{ $mass->time->format('H:i') }}</h4>
                            <small class="text-gray-600">{{ $mass->type ?? 'Missa' }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <x-public.empty-state
                icon="clock"
                title="Horários não disponíveis"
                description="No momento não há horários de missa cadastrados. Em breve atualizaremos esta página." />
        @endif
    </div>
</section>
@endsection
