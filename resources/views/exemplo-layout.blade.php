{{-- Exemplo de view usando layout modularizado --}}
@extends('layouts.app')

@section('title', 'Exemplo - Paróquia São Paulo Apóstolo')
@section('description', 'Exemplo de página utilizando o layout modularizado da Paróquia São Paulo Apóstolo.')

{{-- Estilos específicos para esta página --}}
@push('styles')
<style>
    .exemplo-card {
        background: var(--sp-white);
        border: 2px solid var(--sp-gold);
        border-radius: var(--radius-lg);
        padding: var(--space-xl);
        margin-bottom: var(--space-lg);
        box-shadow: var(--shadow-gold);
    }
    
    .exemplo-destaque {
        background: var(--gradient-sacred);
        color: var(--sp-white);
        padding: var(--space-lg);
        border-radius: var(--radius-md);
        text-align: center;
        margin-bottom: var(--space-xl);
    }
</style>
@endpush

@section('content')
<div class="sp-container" style="padding: var(--space-2xl) 0;">
    <div class="exemplo-destaque">
        <h1>Exemplo de Layout Modularizado</h1>
        <p>Esta página demonstra como usar o sistema modularizado da Paróquia São Paulo Apóstolo</p>
    </div>

    <div class="sp-grid sp-grid-2">
        <div class="exemplo-card">
            <h2>CSS Global</h2>
            <p>Todas as variáveis CSS estão disponíveis globalmente:</p>
            <ul style="list-style: disc; padding-left: var(--space-lg); margin-top: var(--space-md);">
                <li>--sp-red (#8b1e24)</li>
                <li>--sp-gold (#d4af37)</li>
                <li>--sp-teal (#3e8c84)</li>
                <li>--sp-ivory (#f8f5e7)</li>
            </ul>
        </div>
        
        <div class="exemplo-card">
            <h2>Componentes</h2>
            <p>Use os componentes pré-definidos:</p>
            <div style="margin-top: var(--space-md);">
                <a href="#" class="sp-btn sp-btn-primary sp-btn-sm">Botão Primário</a>
                <a href="#" class="sp-btn sp-btn-gold sp-btn-sm">Botão Dourado</a>
                <a href="#" class="sp-btn sp-btn-outline sp-btn-sm">Botão Outline</a>
            </div>
        </div>
    </div>

    <div class="sp-card">
        <h3>Como Usar</h3>
        <ol style="list-style: decimal; padding-left: var(--space-lg);">
            <li>Estenda o layout: <code>@extends('layouts.app')</code></li>
            <li>Defina o título: <code>@section('title', 'Seu Título')</code></li>
            <li>Adicione estilos específicos: <code>@push('styles')</code></li>
            <li>Crie seu conteúdo: <code>@section('content')</code></li>
        </ol>
    </div>
</div>
@endsection