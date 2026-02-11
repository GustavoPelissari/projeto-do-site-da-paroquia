<x-guest-layout>
    <div class="sp-auth-title">
        <h2>Confirmar Senha</h2>
        <p>Esta é uma área segura. Por favor, confirme sua senha.</p>
    </div>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('Esta é uma área segura da aplicação. Por favor, confirme sua senha antes de continuar.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="sp-auth-form-content">
        @csrf

        <!-- Password -->
        <div class="sp-form-group">
            <label for="password" class="sp-label">🔒 Senha</label>
            <input id="password" 
                   class="sp-input"
                   type="password"
                   name="password"
                   required 
                   autocomplete="current-password"
                   placeholder="Digite sua senha" />
            <x-input-error :messages="$errors->get('password')" class="sp-form-error" />
        </div>

        <div class="d-flex justify-end mt-4">
            <button type="submit" class="sp-btn sp-btn-gold">
                {{ __('Confirmar') }}
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
