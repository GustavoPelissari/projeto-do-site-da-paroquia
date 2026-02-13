@extends('layouts.public')

@section('title', 'Paróquia São Paulo Apóstolo - Diocese de Umuarama')
@section('description', 'Paróquia São Paulo Apóstolo em Umuarama - PR. Comunidade católica acolhedora com missas, sacramentos, pastorais e eventos.')

@section('content')
<section class="py-5 bg-light text-center">
    <div class="container py-4">
        <h1 class="display-5 fw-bold mb-3 text-primary">Bem-vindos à nossa paróquia</h1>
        <p class="lead mb-4 text-primary">Igreja: lugar onde a cidade encontra a graça</p>
        <p class="mb-4 text-muted">Somos uma comunidade católica inspirada no exemplo de São Paulo Apóstolo, dedicada a evangelizar, acolher e servir.</p>
        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
            <a href="{{ route('masses') }}" class="btn btn-primary">Ver Horários de Missa</a>
            <a href="{{ route('groups') }}" class="btn btn-outline-primary">Conhecer Pastorais</a>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body p-4 text-center">
                        <h2 class="h4 mb-4 text-primary">Próxima Missa</h2>
                        @php
                            $nextMass = $masses->first();
                        @endphp
                        @if($nextMass)
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="border rounded p-3 h-100">
                                        <small class="text-muted d-block">Dia</small>
                                        <strong>{{ ucfirst($nextMass->day_of_week) }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-3 h-100">
                                        <small class="text-muted d-block">Horário</small>
                                        <strong>{{ $nextMass->time->format('H:i') }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-3 h-100">
                                        <small class="text-muted d-block">Local</small>
                                        <strong>{{ $nextMass->location ?? 'Igreja Matriz' }}</strong>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-muted mb-0">Horários de missa em atualização.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="h3">Nossa Missão</h2>
            <p class="text-muted mb-0">Acolher, evangelizar e servir com amor fraterno.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h3 class="h5 text-primary">Palavra de Deus</h3>
                        <p class="text-muted mb-0">Aprofundamos a fé por meio das Escrituras e da tradição apostólica.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h3 class="h5 text-primary">Caridade</h3>
                        <p class="text-muted mb-0">Praticamos o amor ao próximo em obras de misericórdia e serviço.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h3 class="h5 text-primary">Comunhão</h3>
                        <p class="text-muted mb-0">Crescemos juntos na caminhada da fé como família paroquial.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if(isset($groups) && $groups->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="h3">Pastorais e Movimentos</h2>
            <p class="text-muted mb-0">Encontre seu lugar de serviço e crescimento espiritual.</p>
        </div>
        <div class="row g-4">
            @foreach($groups->take(6) as $group)
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h3 class="h5 text-primary">{{ $group->name }}</h3>
                        <p class="text-muted flex-grow-1">{{ Str::limit($group->description ?? 'Grupo ativo da nossa paróquia.', 120) }}</p>
                        @auth
                            <a href="{{ route('group-requests.create', ['group' => $group->id]) }}" class="btn btn-outline-primary">Participar</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">Entrar para Participar</a>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('groups') }}" class="btn btn-primary">Ver Todas as Pastorais</a>
        </div>
    </div>
</section>
@endif

<section class="py-5">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body p-4 p-lg-5 text-center">
                <h2 class="h4 text-primary mb-3">Seja Parte da Nossa Família</h2>
                <p class="mb-4 text-muted">"Assim como o corpo é um só e tem muitos membros..." (1 Coríntios 12:12)</p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    @guest
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary">Cadastrar-se</a>
                        @endif
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">Fazer Login</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Acessar Painel</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
