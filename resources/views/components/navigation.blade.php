<!-- Accessible Navigation Component -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" role="navigation" aria-label="Navegação principal">
    <div class="container-fluid pe-lg-5 ps-lg-5">
        <a class="navbar-brand fw-bold text-vinho" href="{{ route('home') }}" aria-current="page">
            <img src="{{ asset('images/sao-paulo-logo.png') }}" alt="Paróquia São Paulo Apóstolo" class="me-2" style="height: 40px;">
            <span>Paróquia</span>
        </a>

        <button 
            class="navbar-toggler" 
            type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#navbarNav" 
            aria-controls="navbarNav" 
            aria-expanded="false" 
            aria-label="Alternar menu de navegação"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto" role="menubar">
                <li class="nav-item" role="none">
                    <a class="nav-link" href="{{ route('home') }}" role="menuitem">Home</a>
                </li>
                <li class="nav-item" role="none">
                    <a class="nav-link" href="{{ route('groups') }}" role="menuitem">Grupos</a>
                </li>
                <li class="nav-item" role="none">
                    <a class="nav-link" href="{{ route('masses') }}" role="menuitem">Missas</a>
                </li>
                <li class="nav-item" role="none">
                    <a class="nav-link" href="{{ route('events') }}" role="menuitem">Eventos</a>
                </li>
                <li class="nav-item" role="none">
                    <a class="nav-link" href="{{ route('news') }}" role="menuitem">Notícias</a>
                </li>
                <li class="nav-item" role="none">
                    <a class="nav-link" href="{{ route('about') }}" role="menuitem">Sobre</a>
                </li>

                @auth
                    <li class="nav-item ms-2" role="none">
                        <a class="nav-link text-vinho fw-bold" href="{{ route('dashboard') }}" role="menuitem">
                            <i class="bi bi-speedometer2 me-1"></i>Dashboard
                        </a>
                    </li>
                @else
                    <li class="nav-item ms-2" role="none">
                        <a class="btn btn-outline-vinho btn-sm" href="{{ route('login') }}" role="menuitem">Entrar</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
