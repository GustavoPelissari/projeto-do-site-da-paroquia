<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="sp-mb-4" :status="session('status')" />

    <div class="sp-auth-title">
        <h2>Entrar na Paróquia</h2>
        <p>Acesse sua conta para participar da nossa comunidade</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="sp-auth-form-content">
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
                   autocomplete="current-password"
                   placeholder="Digite sua senha" />
            <x-input-error :messages="$errors->get('password')" class="sp-form-error" />
        </div>

        <!-- Remember Me -->
        <div class="sp-form-group">
            <label for="remember_me" class="sp-flex sp-items-center">
                <input id="remember_me" 
                       type="checkbox" 
                       class="sp-checkbox" 
                       name="remember"
                       style="margin-right: var(--space-2);">
                <span class="sp-text-sm sp-text-muted">Lembrar de mim</span>
            </label>
        </div>

        <div class="sp-auth-actions">
            <button type="submit" class="sp-btn sp-btn-gold sp-btn-full sp-btn-lg">
                🔑 Entrar na Paróquia
            </button>
            
            @if (Route::has('password.request'))
                <a class="sp-link sp-text-center sp-text-sm" href="{{ route('password.request') }}">
                    Esqueceu sua senha?
                </a>
            @endif
            
            @if (Route::has('register'))
                <div class="sp-text-center" style="margin-top: var(--space-4); padding-top: var(--space-4); border-top: 1px solid var(--sp-gray-200);">
                    <p class="sp-text-sm sp-text-muted">Ainda não é membro da nossa paróquia?</p>
                    <a href="{{ route('register') }}" class="sp-btn sp-btn-outline sp-btn-full" style="margin-top: var(--space-2);">
                        ✨ Cadastrar-se Agora
                    </a>
                </div>
            @endif
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
        
        .sp-checkbox {
            width: 16px;
            height: 16px;
            border: 2px solid var(--sp-gray-300);
            border-radius: var(--radius-sm);
            accent-color: var(--sp-red);
        }
        
        .sp-checkbox:checked {
            background-color: var(--sp-red);
            border-color: var(--sp-red);
        }
    </style>
</x-guest-layout>
