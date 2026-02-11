<x-guest-layout>
    <div class="sp-auth-title">
        <h2>Verificar Email</h2>
        <p>Confirme seu endereço de email</p>
    </div>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('Obrigado por se cadastrar! Antes de começar, você pode verificar seu endereço de email clicando no link que enviamos para você? Se você não recebeu o email, teremos prazer em enviar outro.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Um novo link de verificação foi enviado para o endereço de email fornecido durante o registro.') }}
        </div>
    @endif

    <div class="mt-4 d-flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <button type="submit" class="sp-btn sp-btn-gold">
                    {{ __('Reenviar Email de Verificação') }}
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-indigo-500 hover-text-gray-900 rounded-md focus-outline-none focus-ring-2 focus-ring-offset-2">
                {{ __('Sair') }}
            </button>
        </form>
    </div>
    
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
    </style>
</x-guest-layout>
