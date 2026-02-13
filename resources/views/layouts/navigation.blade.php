<nav class="navbar navbar-expand-lg border-bottom shadow-sm app-navbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
            <x-application-logo style="height: 34px; width: 34px;" class="me-2" />
            <div>
                <div class="fw-semibold">Paróquia São Paulo Apóstolo</div>
                <small class="text-muted">Área autenticada</small>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Alternar navegação">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-1"></i> Painel
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('group-requests.*') ? 'active' : '' }}" href="{{ route('group-requests.index') }}">
                        <i class="bi bi-person-check me-1"></i> Minhas solicitações
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                @auth
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">Meu perfil</a>
                            <a class="dropdown-item" href="{{ route('home') }}">Ver site público</a>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">Sair</button>
                            </form>
                        </div>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
