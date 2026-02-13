<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 fw-semibold text-body">
            Painel do usuário
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-body p-4 p-md-5">
                    <p class="text-secondary mb-2">Bem-vindo(a), {{ Auth::user()->name }}.</p>
                    <h3 class="h5 mb-3">Sua área autenticada está ativa.</h3>
                    <p class="text-secondary mb-0">Aqui você pode acompanhar suas solicitações para grupos, manter seu perfil atualizado e acessar rapidamente o site público da paróquia.</p>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4">
                        <div class="card-body">
                            <h4 class="h6 mb-2">Minhas solicitações</h4>
                            <p class="text-secondary small mb-3">Consulte o andamento das solicitações de entrada em grupos.</p>
                            <a href="{{ route('group-requests.index') }}" class="btn btn-outline-primary btn-sm">Acessar</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4">
                        <div class="card-body">
                            <h4 class="h6 mb-2">Meu perfil</h4>
                            <p class="text-secondary small mb-3">Atualize nome, e-mail e senha da sua conta.</p>
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">Editar perfil</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4">
                        <div class="card-body">
                            <h4 class="h6 mb-2">Site público</h4>
                            <p class="text-secondary small mb-3">Acesse notícias, eventos e horários de missa publicados.</p>
                            <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm">Ver site</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
