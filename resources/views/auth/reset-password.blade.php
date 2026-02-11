<x-guest-layout>
    <div class="sp-auth-title">
        <h2>Redefinir Senha</h2>
        <p>Escolha uma nova senha para sua conta</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="sp-auth-form-content">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="sp-form-group">
            <label for="email" class="sp-label">📧 Email</label>
            <input id="email" 
                   class="sp-input" 
                   type="email" 
                   name="email" 
                   value="{{ old('email', $request->email) }}" 
                   required 
                   autofocus 
                   autocomplete="username"
                   placeholder="seu.email@exemplo.com" />
            <x-input-error :messages="$errors->get('email')" class="sp-form-error" />
        </div>

        <!-- Password -->
        <div class="sp-form-group">
            <label for="password" class="sp-label">🔒 Nova Senha</label>
            <input id="password" 
                   class="sp-input"
                   type="password"
                   name="password"
                   required 
                   autocomplete="new-password"
                   placeholder="Mínimo 8 caracteres" />
            <x-input-error :messages="$errors->get('password')" class="sp-form-error" />
        </div>

        <!-- Confirm Password -->
        <div class="sp-form-group">
            <label for="password_confirmation" class="sp-label">🔒 Confirmar Senha</label>
            <input id="password_confirmation" 
                   class="sp-input"
                   type="password"
                   name="password_confirmation" 
                   required 
                   autocomplete="new-password"
                   placeholder="Digite a senha novamente" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="sp-form-error" />
        </div>

        <div class="d-flex items-center justify-end mt-4">
            <button type="submit" class="sp-btn sp-btn-gold sp-btn-full sp-btn-lg">
                {{ __('Redefinir Senha') }}
            </button>
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
