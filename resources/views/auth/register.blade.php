@extends('layout')@extends('layout')@extends('layout')@extends('layout')@extends('layout')



@section('title', 'Cadastrar - Paróquia São Paulo Apóstolo')



@section('content')@section('title', 'Cadastrar - Paróquia São Paulo Apóstolo')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6 col-lg-5">

            <div class="card shadow-lg border-0">@section('content')@section('title', 'Cadastrar - Paróquia São Paulo Apóstolo')

                <div class="card-body p-5">

                    <div class="text-center mb-4"><div class="container py-5">

                        <img src="{{ asset('images/sao-paulo-logo.png') }}" alt="São Paulo Apóstolo" class="mb-3" style="height: 60px;">

                        <h2 class="h4 text-brand-vinho mb-2">Cadastrar na Paróquia</h2>    <div class="row justify-content-center">

                        <p class="text-muted">Junte-se à nossa comunidade de fé</p>

                    </div>        <div class="col-md-6 col-lg-5">



                    <form method="POST" action="{{ route('register') }}">            <div class="card shadow-lg border-0">@section('content')@section('title', 'Cadastrar - Paróquia São Paulo Apóstolo')@section('title', 'Cadastrar - Paróquia São Paulo Apóstolo')

                        @csrf

                <div class="card-body p-5">

                        <!-- Name -->

                        <div class="mb-3">                    <div class="text-center mb-4"><div class="container py-5">

                            <label for="name" class="form-label">

                                <i class="bi bi-person"></i> Nome Completo                        <img src="{{ asset('images/sao-paulo-logo.png') }}" alt="São Paulo Apóstolo" class="mb-3" style="height: 60px;">

                            </label>

                            <input id="name"                         <h2 class="h4 text-brand-vinho mb-2">Cadastrar na Paróquia</h2>    <div class="row justify-content-center">

                                   class="form-control @error('name') is-invalid @enderror"

                                   type="text"                         <p class="text-muted">Junte-se à nossa comunidade de fé São Paulo Apóstolo</p>

                                   name="name"

                                   value="{{ old('name') }}"                    </div>        <div class="col-md-6 col-lg-5">

                                   required 

                                   autofocus 

                                   autocomplete="name" 

                                   placeholder="Seu nome completo" />                    <form method="POST" action="{{ route('register') }}">            <div class="card shadow-lg border-0">@section('content')@section('content')

                            @error('name')

                                <div class="invalid-feedback">{{ $message }}</div>                        @csrf

                            @enderror

                        </div>                <div class="card-body p-5">



                        <!-- Email Address -->                        <div class="mb-3">

                        <div class="mb-3">

                            <label for="email" class="form-label">                            <label for="name" class="form-label">                    <div class="text-center mb-4"><div class="container py-5"><div class="container py-5">

                                <i class="bi bi-envelope"></i> Email

                            </label>                                <i class="bi bi-person"></i> Nome Completo

                            <input id="email" 

                                   class="form-control @error('email') is-invalid @enderror"                            </label>                        <img src="{{ asset('images/sao-paulo-logo.png') }}" alt="São Paulo Apóstolo" class="mb-3" style="height: 60px;">

                                   type="email" 

                                   name="email"                            <input id="name" 

                                   value="{{ old('email') }}"

                                   required                                    class="form-control @error('name') is-invalid @enderror"                         <h2 class="h4 text-brand-vinho mb-2">Cadastrar na Paróquia</h2>    <div class="row justify-content-center">    <div class="row justify-content-center">

                                   autocomplete="username" 

                                   placeholder="seu.email@exemplo.com" />                                   type="text" 

                            @error('email')

                                <div class="invalid-feedback">{{ $message }}</div>                                   name="name"                         <p class="text-muted">Junte-se à nossa comunidade de fé São Paulo Apóstolo</p>

                            @enderror

                        </div>                                   value="{{ old('name') }}" 



                        <!-- Password -->                                   required                     </div>        <div class="col-md-6 col-lg-5">        <div class="col-md-6 col-lg-5">

                        <div class="mb-3">

                            <label for="password" class="form-label">                                   autofocus 

                                <i class="bi bi-lock"></i> Senha

                            </label>                                   autocomplete="name"

                            <input id="password"

                                   class="form-control @error('password') is-invalid @enderror"                                   placeholder="Digite seu nome completo" />

                                   type="password"

                                   name="password"                            @error('name')                    <form method="POST" action="{{ route('register') }}">            <div class="card shadow-lg border-0">            <div class="card shadow-lg border-0">

                                   required 

                                   autocomplete="new-password"                                <div class="invalid-feedback">{{ $message }}</div>

                                   placeholder="Crie uma senha segura" />

                            @error('password')                            @enderror                        @csrf

                                <div class="invalid-feedback">{{ $message }}</div>

                            @enderror                        </div>

                        </div>

                <div class="card-body p-5">                <div class="card-body p-5">

                        <!-- Confirm Password -->

                        <div class="mb-3">                        <div class="mb-3">

                            <label for="password_confirmation" class="form-label">

                                <i class="bi bi-lock-fill"></i> Confirmar Senha                            <label for="email" class="form-label">                        <div class="mb-3">

                            </label>

                            <input id="password_confirmation"                                <i class="bi bi-envelope"></i> Email

                                   class="form-control @error('password_confirmation') is-invalid @enderror"

                                   type="password"                            </label>                            <label for="name" class="form-label">                    <div class="text-center mb-4">                    <div class="text-center mb-4">

                                   name="password_confirmation"

                                   required                             <input id="email" 

                                   autocomplete="new-password"

                                   placeholder="Confirme sua senha" />                                   class="form-control @error('email') is-invalid @enderror"                                 <i class="bi bi-person"></i> Nome Completo

                            @error('password_confirmation')

                                <div class="invalid-feedback">{{ $message }}</div>                                   type="email" 

                            @enderror

                        </div>                                   name="email"                             </label>                        <img src="{{ asset('images/sao-paulo-logo.png') }}" alt="São Paulo Apóstolo" class="mb-3" style="height: 60px;">                        <img src="{{ asset('images/sao-paulo-logo.png') }}" alt="São Paulo Apóstolo" class="mb-3" style="height: 60px;">



                        <div class="d-grid mb-3">                                   value="{{ old('email') }}" 

                            <button type="submit" class="btn-primary-paroquia">

                                <i class="bi bi-person-plus"></i> Cadastrar                                   required                             <input id="name" 

                            </button>

                        </div>                                   autocomplete="username"



                        <div class="text-center">                                   placeholder="seu.email@exemplo.com" />                                   class="form-control @error('name') is-invalid @enderror"                         <h2 class="h4 text-brand-vinho mb-2">Cadastrar na Paróquia</h2>                        <h2 class="h4 text-brand-vinho mb-2">Cadastrar na Paróquia</h2>

                            <p class="mb-0">Já tem uma conta?

                                <a href="{{ route('login') }}" class="text-decoration-none">                            @error('email')

                                    Faça login aqui

                                </a>                                <div class="invalid-feedback">{{ $message }}</div>                                   type="text" 

                            </p>

                        </div>                            @enderror

                    </form>

                </div>                        </div>                                   name="name"                         <p class="text-muted">Junte-se à nossa comunidade de fé São Paulo Apóstolo</p>                        <p class="text-muted">Junte-se à nossa comunidade de fé São Paulo Apóstolo</p>

            </div>

        </div>

    </div>

</div>                        <div class="mb-3">                                   value="{{ old('name') }}" 

@endsection
                            <label for="password" class="form-label">

                                <i class="bi bi-lock"></i> Senha                                   required                     </div>                    </div>

                            </label>

                            <input id="password"                                    autofocus 

                                   class="form-control @error('password') is-invalid @enderror"

                                   type="password"                                   autocomplete="name"

                                   name="password"

                                   required                                    placeholder="Digite seu nome completo" />

                                   autocomplete="new-password"

                                   placeholder="Mínimo 8 caracteres" />                            @error('name')                    <form method="POST" action="{{ route('register') }}">                    <form method="POST" action="{{ route('register') }}">

                            @error('password')

                                <div class="invalid-feedback">{{ $message }}</div>                                <div class="invalid-feedback">{{ $message }}</div>

                            @enderror

                        </div>                            @enderror                        @csrf                        @csrf



                        <div class="mb-3">                        </div>

                            <label for="password_confirmation" class="form-label">

                                <i class="bi bi-lock-fill"></i> Confirmar Senha

                            </label>

                            <input id="password_confirmation"                         <div class="mb-3">

                                   class="form-control @error('password_confirmation') is-invalid @enderror"

                                   type="password"                            <label for="email" class="form-label">                        <!-- Name -->                        <!-- Name -->

                                   name="password_confirmation"

                                   required                                 <i class="bi bi-envelope"></i> Email

                                   autocomplete="new-password"

                                   placeholder="Digite a senha novamente" />                            </label>                        <div class="mb-3">                        <div class="mb-3">

                            @error('password_confirmation')

                                <div class="invalid-feedback">{{ $message }}</div>                            <input id="email" 

                            @enderror

                        </div>                                   class="form-control @error('email') is-invalid @enderror"                             <label for="name" class="form-label">                            <label for="name" class="form-label">



                        <div class="d-grid mb-3">                                   type="email" 

                            <button type="submit" class="btn-primary-paroquia">

                                <i class="bi bi-person-plus"></i> Cadastrar                                   name="email"                                 <i class="bi bi-person"></i> Nome Completo                                <i class="bi bi-person"></i> Nome Completo

                            </button>

                        </div>                                   value="{{ old('email') }}" 



                        <div class="text-center">                                   required                             </label>                            </label>

                            <p class="mb-0">Já tem uma conta? 

                                <a href="{{ route('login') }}" class="text-decoration-none">                                   autocomplete="username"

                                    Entre aqui

                                </a>                                   placeholder="seu.email@exemplo.com" />                            <input id="name"                             <input id="name" 

                            </p>

                        </div>                            @error('email')

                    </form>

                </div>                                <div class="invalid-feedback">{{ $message }}</div>                                   class="form-control @error('name') is-invalid @enderror"                                    class="form-control @error('name') is-invalid @enderror" 

            </div>

        </div>                            @enderror

    </div>

</div>                        </div>                                   type="text"                                    type="text" 

@endsection


                        <div class="mb-3">                                   name="name"                                    name="name" 

                            <label for="password" class="form-label">

                                <i class="bi bi-lock"></i> Senha                                   value="{{ old('name') }}"                                    value="{{ old('name') }}" 

                            </label>

                            <input id="password"                                    required                                    required 

                                   class="form-control @error('password') is-invalid @enderror"

                                   type="password"                                   autofocus                                    autofocus 

                                   name="password"

                                   required                                    autocomplete="name"                                   autocomplete="name"

                                   autocomplete="new-password"

                                   placeholder="Mínimo 8 caracteres" />                                   placeholder="Digite seu nome completo" />                                   placeholder="Digite seu nome completo" />

                            @error('password')

                                <div class="invalid-feedback">{{ $message }}</div>                            @error('name')                            @error('name')

                            @enderror

                        </div>                                <div class="invalid-feedback">{{ $message }}</div>                                <div class="invalid-feedback">{{ $message }}</div>



                        <div class="mb-3">                            @enderror                            @enderror

                            <label for="password_confirmation" class="form-label">

                                <i class="bi bi-lock-fill"></i> Confirmar Senha                        </div>                        </div>

                            </label>

                            <input id="password_confirmation" 

                                   class="form-control @error('password_confirmation') is-invalid @enderror"

                                   type="password"                        <!-- Email Address -->                        <!-- Email Address -->

                                   name="password_confirmation"

                                   required                         <div class="mb-3">                        <div class="mb-3">

                                   autocomplete="new-password"

                                   placeholder="Digite a senha novamente" />                            <label for="email" class="form-label">                            <label for="email" class="form-label">

                            @error('password_confirmation')

                                <div class="invalid-feedback">{{ $message }}</div>                                <i class="bi bi-envelope"></i> Email                                <i class="bi bi-envelope"></i> Email

                            @enderror

                        </div>                            </label>                            </label>



                        <div class="d-grid mb-3">                            <input id="email"                             <input id="email" 

                            <button type="submit" class="btn-primary-paroquia">

                                <i class="bi bi-person-plus"></i> Cadastrar                                   class="form-control @error('email') is-invalid @enderror"                                    class="form-control @error('email') is-invalid @enderror" 

                            </button>

                        </div>                                   type="email"                                    type="email" 



                        <div class="text-center">                                   name="email"                                    name="email" 

                            <p class="mb-0">Já tem uma conta? 

                                <a href="{{ route('login') }}" class="text-decoration-none">                                   value="{{ old('email') }}"                                    value="{{ old('email') }}" 

                                    Entre aqui

                                </a>                                   required                                    required 

                            </p>

                        </div>                                   autocomplete="username"                                   autocomplete="username"

                    </form>

                </div>                                   placeholder="seu.email@exemplo.com" />                                   placeholder="seu.email@exemplo.com" />

            </div>

        </div>                            @error('email')                            @error('email')

    </div>

</div>                                <div class="invalid-feedback">{{ $message }}</div>                                <div class="invalid-feedback">{{ $message }}</div>

@endsection
                            @enderror                            @enderror

                        </div>                        </div>



                        <!-- Password -->                        <!-- Password -->

                        <div class="mb-3">                        <div class="mb-3">

                            <label for="password" class="form-label">                            <label for="password" class="form-label">

                                <i class="bi bi-lock"></i> Senha                                <i class="bi bi-lock"></i> Senha

                            </label>                            </label>

                            <input id="password"                             <input id="password" 

                                   class="form-control @error('password') is-invalid @enderror"                                   class="form-control @error('password') is-invalid @enderror"

                                   type="password"                                   type="password"

                                   name="password"                                   name="password"

                                   required                                    required 

                                   autocomplete="new-password"                                   autocomplete="new-password"

                                   placeholder="Mínimo 8 caracteres" />                                   placeholder="Mínimo 8 caracteres" />

                            @error('password')                            @error('password')

                                <div class="invalid-feedback">{{ $message }}</div>                                <div class="invalid-feedback">{{ $message }}</div>

                            @enderror                            @enderror

                        </div>                        </div>



                        <!-- Confirm Password -->                        <!-- Confirm Password -->

                        <div class="mb-3">                        <div class="mb-3">

                            <label for="password_confirmation" class="form-label">                            <label for="password_confirmation" class="form-label">

                                <i class="bi bi-lock-fill"></i> Confirmar Senha                                <i class="bi bi-lock-fill"></i> Confirmar Senha

                            </label>                            </label>

                            <input id="password_confirmation"                             <input id="password_confirmation" 

                                   class="form-control @error('password_confirmation') is-invalid @enderror"                                   class="form-control @error('password_confirmation') is-invalid @enderror"

                                   type="password"                                   type="password"

                                   name="password_confirmation"                                   name="password_confirmation"

                                   required                                    required 

                                   autocomplete="new-password"                                   autocomplete="new-password"

                                   placeholder="Digite a senha novamente" />                                   placeholder="Digite a senha novamente" />

                            @error('password_confirmation')                            @error('password_confirmation')

                                <div class="invalid-feedback">{{ $message }}</div>                                <div class="invalid-feedback">{{ $message }}</div>

                            @enderror                            @enderror

                        </div>                        </div>



                        <div class="d-grid mb-3">                        <div class="d-grid mb-3">

                            <button type="submit" class="btn-primary-paroquia">                            <button type="submit" class="btn-primary-paroquia">

                                <i class="bi bi-person-plus"></i> Cadastrar                                <i class="bi bi-person-plus"></i> Cadastrar

                            </button>                            </button>

                        </div>                        </div>



                        <div class="text-center">                        <div class="text-center">

                            <p class="mb-0">Já tem uma conta?                             <p class="mb-0">Já tem uma conta? 

                                <a href="{{ route('login') }}" class="text-decoration-none">                                <a href="{{ route('login') }}" class="text-decoration-none">

                                    Entre aqui                                    Entre aqui

                                </a>                                </a>

                            </p>                            </p>

                        </div>                        </div>

                    </form>                    </form>

                </div>                </div>

            </div>            </div>

        </div>        </div>

    </div>    </div>

</div></div>

@endsection@endsection
