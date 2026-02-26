@extends('layouts.public')

@section('title', 'Notícias - Paróquia São Paulo Apóstolo')
@section('description', 'Fique por dentro das notícias e comunicados da Paróquia São Paulo Apóstolo em Umuarama.')

@section('content')
<x-public.hero
    title="Notícias"
    subtitle="Comunicados e novidades da paróquia"
    description="Acompanhe as atualizações, ações pastorais e notícias importantes para nossa comunidade." />

<section class="section-paroquia">
    <div class="container">
        @if($news->count() > 0)
            <x-public.section-header
                title="Últimas Publicações"
                subtitle="Informações oficiais e novidades da vida paroquial." />

            <div class="row g-4">
                @foreach($news as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="card-paroquia h-100">
                            <div class="card-header-paroquia">
                                <h5 class="mb-2">{{ $item->title }}</h5>
                                <small class="text-muted d-block">
                                    <i data-lucide="calendar" class="icon-paroquia"></i>
                                    {{ $item->created_at->format('d/m/Y') }}
                                </small>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <p class="text-muted flex-grow-1">{{ Str::limit($item->summary ?: strip_tags($item->content), 160) }}</p>
                                @if($item->category)
                                    <small class="text-muted text-uppercase">{{ $item->category }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($news->hasPages())
                <div class="d-flex justify-content-center mt-5">{{ $news->links() }}</div>
            @endif
        @else
            <x-public.empty-state
                icon="newspaper"
                title="Nenhuma notícia disponível"
                description="Ainda não há notícias publicadas. Volte em breve para conferir as novidades da nossa paróquia." />
        @endif
    </div>
</section>
@endsection
