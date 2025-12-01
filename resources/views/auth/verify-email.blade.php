@php($status = session('status'))
@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 p-6 bg-white shadow rounded">
    <h1 class="text-2xl font-semibold mb-4">Verificação de e-mail</h1>
    <p class="mb-4">Enviamos um código de 6 dígitos para o seu e-mail. Insira-o abaixo para confirmar sua conta.</p>

    @if ($status)
        <x-alert type="success">
            {{ $status }}
        </x-alert>
    @endif

    @if ($errors->any())
        <x-alert type="error">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    <form method="POST" action="{{ route('verification.verify') }}" class="space-y-4" id="verifyForm">
        @csrf
        <label class="block">
            <span class="text-sm font-medium">Código</span>
            <input name="code" type="text" inputmode="numeric" autocomplete="one-time-code" 
                   maxlength="6" pattern="[0-9]{6}"
                   required class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" 
                   placeholder="000000" value="{{ old('code') }}" id="codeInput">
        </label>
        <button type="submit" id="verifyBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded transition-colors flex items-center justify-center">
            <span class="btn-text">Verificar</span>
            <span class="btn-spinner hidden">
                <svg class="animate-spin h-5 w-5 text-white inline-block ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Verificando...
            </span>
        </button>
    </form>

    <form method="POST" action="{{ route('verification.send') }}" class="mt-4" id="resendForm">
        @csrf
        <button type="submit" id="resendBtn" class="text-sm text-gray-700 hover:text-gray-900 underline transition-colors flex items-center">
            <span class="btn-text">Reenviar código</span>
            <span class="btn-spinner hidden">
                <svg class="animate-spin h-4 w-4 text-gray-700 inline-block ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="mt-6 pt-4 border-t">
        @csrf
        <button class="text-xs text-gray-500 underline hover:text-gray-700 transition-colors">Cancelar e sair</button>
    </form>

    <p class="text-xs text-gray-500 mt-4">Por segurança, o código expira em 15 minutos e há limite de 5 tentativas.</p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const verifyForm = document.getElementById('verifyForm');
    const verifyBtn = document.getElementById('verifyBtn');
    const resendForm = document.getElementById('resendForm');
    const resendBtn = document.getElementById('resendBtn');

    // Prevent double submission on verify
    verifyForm.addEventListener('submit', function() {
        verifyBtn.disabled = true;
        verifyBtn.querySelector('.btn-text').classList.add('hidden');
        verifyBtn.querySelector('.btn-spinner').classList.remove('hidden');
    });

    // Prevent double submission on resend
    resendForm.addEventListener('submit', function() {
        resendBtn.disabled = true;
        resendBtn.querySelector('.btn-text').classList.add('hidden');
        resendBtn.querySelector('.btn-spinner').classList.remove('hidden');
    });

    // Auto-focus on code input
    document.getElementById('codeInput').focus();
});
</script>
@endsection