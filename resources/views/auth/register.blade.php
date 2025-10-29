<x-guest-layout>
    <div class="sp-auth-title">
        <h2>Cadastrar na Paróquia</h2>
        <p>Junte-se à nossa comunidade de fé São Paulo Apóstolo</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="sp-auth-form-content">
        @csrf

        <!-- Name -->
        <div class="sp-form-group">
            <label for="name" class="sp-label">👤 Nome Completo</label>
            <input id="name" 
                   class="sp-input" 
                   type="text" 
                   name="name" 
                   value="{{ old('name') }}" 
                   required 
                   autofocus 
                   autocomplete="name"
                   placeholder="Digite seu nome completo" />
            <x-input-error :messages="$errors->get('name')" class="sp-form-error" />
        </div>

        <!-- Email Address -->
        <div class="sp-form-group">
            <label for="email" class="sp-label">📧 Email</label>
            <input id="email" 
                   class="sp-input" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autocomplete="username"
                   placeholder="seu.email@exemplo.com" />
            <x-input-error :messages="$errors->get('email')" class="sp-form-error" />
        </div>

        <!-- Password -->
        <div class="sp-form-group">
            <label for="password" class="sp-label">🔒 Senha</label>
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

        <div class="sp-auth-actions">
            <button type="submit" class="sp-btn sp-btn-gold sp-btn-full sp-btn-lg">
                ✨ Cadastrar na Paróquia
            </button>
            
            <div class="sp-text-center" style="margin-top: var(--space-4); padding-top: var(--space-4); border-top: 1px solid var(--sp-gray-200);">
                <p class="sp-text-sm sp-text-muted">Já é membro da nossa paróquia?</p>
                <a href="{{ route('login') }}" class="sp-btn sp-btn-outline sp-btn-full" style="margin-top: var(--space-2);">
                    🔑 Fazer Login
                </a>
            </div>
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
        
        .sp-auth-actions {
            margin-top: var(--space-6);
        }
    </style>
</x-guest-layout>
