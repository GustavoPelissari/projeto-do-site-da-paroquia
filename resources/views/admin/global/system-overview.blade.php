@extends('admin.layout')

@section('title', 'Visão do Sistema - Admin Global')

@push('styles')
<style>
    .system-overview {
        padding: var(--space-6);
    }
    
    .system-header {
        background: linear-gradient(135deg, var(--sp-gold-dark) 0%, var(--sp-gold) 100%);
        color: var(--sp-white);
        padding: var(--space-xl);
        border-radius: var(--radius-xl);
        margin-bottom: var(--space-6);
        text-align: center;
    }
    
    .system-sections {
        display: grid;
        gap: var(--space-6);
    }
    
    .system-section {
        background: var(--sp-white);
        border-radius: var(--radius-xl);
        padding: var(--space-6);
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--sp-gray-200);
    }
    
    .section-title {
        font-size: var(--text-xl);
        font-weight: var(--font-bold);
        color: var(--sp-red-dark);
        margin-bottom: var(--space-4);
        display: flex;
        align-items: center;
        gap: var(--space-3);
    }
    
    .section-icon {
        font-size: var(--text-2xl);
    }
    
    .system-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: var(--space-4);
    }
    
    .info-item {
        background: var(--sp-gray-50);
        padding: var(--space-4);
        border-radius: var(--radius-lg);
        border-left: 4px solid var(--sp-teal);
    }
    
    .info-label {
        font-weight: var(--font-semibold);
        color: var(--sp-gray-700);
        margin-bottom: var(--space-1);
    }
    
    .info-value {
        color: var(--sp-red);
        font-size: var(--text-lg);
        font-weight: var(--font-medium);
    }
    
    .status-indicator {
        display: inline-block;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: var(--space-2);
    }
    
    .status-online { background: #10b981; }
    .status-warning { background: #f59e0b; }
    .status-offline { background: #ef4444; }
    
    .action-buttons {
        display: flex;
        gap: var(--space-3);
        margin-top: var(--space-4);
        flex-wrap: wrap;
    }
    
    .btn {
        padding: var(--space-3) var(--space-4);
        border-radius: var(--radius-md);
        text-decoration: none;
        font-size: var(--text-sm);
        font-weight: var(--font-medium);
        border: none;
        cursor: pointer;
        transition: all var(--duration-200) ease;
    }
    
    .btn-primary {
        background: var(--sp-red);
        color: var(--sp-white);
    }
    
    .btn-primary:hover {
        background: var(--sp-red-dark);
        text-decoration: none;
        color: var(--sp-white);
    }
    
    .btn-secondary {
        background: var(--sp-gray-100);
        color: var(--sp-gray-700);
    }
    
    .btn-secondary:hover {
        background: var(--sp-gray-200);
        text-decoration: none;
        color: var(--sp-gray-700);
    }
    
    .recent-activity {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .activity-item {
        padding: var(--space-3);
        border-bottom: 1px solid var(--sp-gray-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-description {
        color: var(--sp-gray-700);
    }
    
    .activity-time {
        color: var(--sp-gray-500);
        font-size: var(--text-sm);
    }
</style>
@endpush

@section('content')
<div class="system-overview">
    <div class="system-header">
        <h1>⚙️ Visão Geral do Sistema</h1>
        <p>Monitoramento e controle completo do sistema paroquial</p>
    </div>
    
    <div class="system-sections">
        <!-- Status do Sistema -->
        <div class="system-section">
            <h2 class="section-title">
                <span class="section-icon">🟢</span>
                Status do Sistema
            </h2>
            <div class="system-info">
                <div class="info-item">
                    <div class="info-label">
                        <span class="status-indicator status-online"></span>
                        Sistema Principal
                    </div>
                    <div class="info-value">Online</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">
                        <span class="status-indicator status-online"></span>
                        Banco de Dados
                    </div>
                    <div class="info-value">Conectado</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">
                        <span class="status-indicator status-online"></span>
                        Cache
                    </div>
                    <div class="info-value">Funcionando</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">
                        <span class="status-indicator status-warning"></span>
                        Backup
                    </div>
                    <div class="info-value">Configurar</div>
                </div>
            </div>
        </div>
        
        <!-- Informações do Sistema -->
        <div class="system-section">
            <h2 class="section-title">
                <span class="section-icon">💻</span>
                Informações Técnicas
            </h2>
            <div class="system-info">
                <div class="info-item">
                    <div class="info-label">Versão do Sistema</div>
                    <div class="info-value">v1.0.0</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Laravel</div>
                    <div class="info-value">{{ app()->version() }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">PHP</div>
                    <div class="info-value">{{ PHP_VERSION }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Timezone</div>
                    <div class="info-value">{{ config('app.timezone') }}</div>
                </div>
            </div>
        </div>
        
        <!-- Ações do Sistema -->
        <div class="system-section">
            <h2 class="section-title">
                <span class="section-icon">🔧</span>
                Ações de Manutenção
            </h2>
            <div class="action-buttons d-flex flex-wrap gap-2">
                <button class="btn btn-primary"><i class="bi bi-arrow-repeat me-2"></i>Limpar Cache</button>
                <button class="btn btn-primary"><i class="bi bi-gear me-2"></i>Recarregar Configurações</button>
                <button class="btn btn-secondary"><i class="bi bi-graph-up me-2"></i>Relatório de Uso</button>
                <button class="btn btn-secondary"><i class="bi bi-tools me-2"></i>Modo de Manutenção</button>
                <button class="btn btn-secondary"><i class="bi bi-hdd me-2"></i>Backup Manual</button>
            </div>
        </div>
        
        <!-- Atividade Recente do Sistema -->
        <div class="system-section">
            <h2 class="section-title">
                <span class="section-icon">📋</span>
                Atividade Recente do Sistema
            </h2>
            <ul class="recent-activity">
                <li class="activity-item">
                    <span class="activity-description">✅ Sistema iniciado com sucesso</span>
                    <span class="activity-time">Agora</span>
                </li>
                <li class="activity-item">
                    <span class="activity-description">🔄 Cache limpo automaticamente</span>
                    <span class="activity-time">2 horas atrás</span>
                </li>
                <li class="activity-item">
                    <span class="activity-description">👤 Novo usuário registrado</span>
                    <span class="activity-time">1 dia atrás</span>
                </li>
                <li class="activity-item">
                    <span class="activity-description">📰 Notícia publicada</span>
                    <span class="activity-time">2 dias atrás</span>
                </li>
                <li class="activity-item">
                    <span class="activity-description">🏛️ Grupo criado</span>
                    <span class="activity-time">3 dias atrás</span>
                </li>
            </ul>
        </div>
        
        <!-- Monitoramento de Recursos -->
        <div class="system-section">
            <h2 class="section-title">
                <span class="section-icon">📈</span>
                Uso de Recursos
            </h2>
            <div class="system-info">
                <div class="info-item">
                    <div class="info-label">Memória PHP</div>
                    <div class="info-value">{{ number_format(memory_get_usage(true) / 1024 / 1024, 2) }} MB</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Limite de Memória</div>
                    <div class="info-value">{{ ini_get('memory_limit') }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Tempo de Execução</div>
                    <div class="info-value">{{ ini_get('max_execution_time') }}s</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Upload Máximo</div>
                    <div class="info-value">{{ ini_get('upload_max_filesize') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
