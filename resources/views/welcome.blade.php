@extends('layouts.public')

@section('title', 'Paróquia São Paulo Apóstolo')

@section('content')
<section class="section-paroquia">
    <div class="mx-auto max-w-5xl px-4 py-16 text-center sm:px-6 lg:px-8">
        <h1 class="mb-4">Paróquia São Paulo Apóstolo</h1>
        <p class="mx-auto mb-8 max-w-3xl text-lg text-gray-600">
            Comunidade de fé, esperança e caridade. Acompanhe horários, notícias,
            eventos e participe das pastorais.
        </p>

        <div class="flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ route('home') }}" class="btn-paroquia btn-primary-paroquia">Ir para Início</a>
            <a href="{{ route('groups') }}" class="btn-paroquia btn-outline-paroquia">Conhecer Pastorais</a>
        </div>
    </div>
</section>
@endsection
