<x-guest-layout>
    <div class="sp-auth-title">
        <h2>Recuperar Senha</h2>
        <p>Digite seu email para receber o link de redefinição</p>
    </div>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('Esqueceu sua senha? Sem problemas. Informe seu email e enviaremos um link para redefinir sua senha.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="sp-auth-form-content">
        @csrf

        <!-- Email Address -->
        <div class="sp-form-group">
            <label for="email" class="sp-label">📧 Email</label>
            <input id="email" 
                   class="sp-input" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   placeholder="seu.email@exemplo.com" />
            <x-input-error :messages="$errors->get('email')" class="sp-form-error" />
        </div>

        <div class="d-flex items-center justify-end mt-4">
            <button type="submit" class="sp-btn sp-btn-gold sp-btn-full">
                {{ __('Enviar Link de Recuperação') }}
            </button>
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="sp-link text-sm">
                Voltar para o login
            </a>
        </div>
    </form>
    
    <style>
        .sp-auth-title {
            text-align: center;
            margin-bottom: var(--space-6);
        }
        
        .sp-auth-title h2 {
            color: var(--sp-red);
            font-size: var(--text-2xl);
            font-weight: var(--font-bold);
            margin-bottom: var(--space-2);
        }
        
        .sp-auth-title p {
            color: var(--sp-gray-600);
            font-size: var(--text-sm);
            margin: 0;
        }
        
        .sp-auth-form-content {
            display: flex;
            flex-direction: column;
            gap: var(--space-4);
        }
    </style>
</x-guest-layout>
