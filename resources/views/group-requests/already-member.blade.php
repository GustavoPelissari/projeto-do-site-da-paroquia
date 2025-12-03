@extends('layout')

@section('title', 'Você já participa de um Grupo - Paróquia São Paulo Apóstolo')

@section('content')
<x-hero title="Você já faz parte da nossa Comunidade!" subtitle="Obrigado por ser membro ativo da nossa paróquia">
    <p class="mb-0" style="opacity: 0.9;">
        Você já está participando de um grupo paroquial. Continue servindo com amor e dedicação!
    </p>
</x-hero>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Grupo Atual -->
            <div class="card-paroquia mb-4" style="border: 2px solid var(--dourado-suave); box-shadow: 0 8px 20px rgba(139, 30, 63, 0.15);">
                <div class="card-header-paroquia" style="background: linear-gradient(135deg, var(--brand-vinho) 0%, #6B0F2A 100%); color: white;">
                    <h2 class="card-title-paroquia mb-0">
                        <i data-lucide="check-circle" class="me-2"></i>
                        Seu Grupo Atual
                    </h2>
                </div>
                
                <div class="card-body-paroquia">
                    <div class="d-flex align-items-start mb-4">
                        @if($currentGroup->image)
                            <img src="{{ asset('storage/' . $currentGroup->image) }}" 
                                 alt="{{ $currentGroup->name }}"
                                 class="rounded-3 me-4"
                                 style="width: 120px; height: 120px; object-fit: cover; border: 3px solid var(--dourado-suave);">
                        @else
                            <div class="rounded-3 me-4 d-flex align-items-center justify-content-center text-white" 
                                 style="width: 120px; height: 120px; background: linear-gradient(135deg, var(--brand-vinho) 0%, #6B0F2A 100%); border: 3px solid var(--dourado-suave);">
                                <i data-lucide="users" style="width: 48px; height: 48px;"></i>
                            </div>
                        @endif
                        
                        <div class="flex-grow-1">
                            <h3 class="fw-bold mb-2" style="color: var(--brand-vinho); font-size: 1.8rem;">
                                {{ $currentGroup->name }}
                            </h3>
                            
                            @if($currentGroup->description)
                                <p class="mb-3 text-muted">
                                    {{ $currentGroup->description }}
                                </p>
                            @endif

                            <div class="row g-3 mt-3">
                                @if($currentGroup->coordinator_name)
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-2" 
                                             style="width: 40px; height: 40px; background-color: var(--bg-rose);">
                                            <i data-lucide="user" style="width: 20px; height: 20px; color: var(--brand-vinho);"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">Coordenador(a)</small>
                                            <strong style="color: var(--brand-vinho);">{{ $currentGroup->coordinator_name }}</strong>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($currentGroup->meeting_info)
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-2" 
                                             style="width: 40px; height: 40px; background-color: var(--bg-rose);">
                                            <i data-lucide="calendar" style="width: 20px; height: 20px; color: var(--brand-vinho);"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">Encontros</small>
                                            <strong style="color: var(--brand-vinho);">{{ $currentGroup->meeting_info }}</strong>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-2" 
                                             style="width: 40px; height: 40px; background-color: var(--bg-rose);">
                                            <i data-lucide="tag" style="width: 20px; height: 20px; color: var(--brand-vinho);"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">Categoria</small>
                                            <strong style="color: var(--brand-vinho);">{{ $currentGroup->category_name }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-2" 
                                             style="width: 40px; height: 40px; background-color: var(--bg-rose);">
                                            <i data-lucide="users-2" style="width: 20px; height: 20px; color: var(--brand-vinho);"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">Membros</small>
                                            <strong style="color: var(--brand-vinho);">{{ $currentGroup->members_count ?? 0 }} {{ $currentGroup->max_members ? '/ ' . $currentGroup->max_members : '' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($currentGroup->requires_scale)
                            <div class="alert mt-4 mb-0" style="background-color: var(--bg-rose); border-left: 4px solid var(--dourado-suave); border-radius: 8px;">
                                <div class="d-flex align-items-center">
                                    <i data-lucide="calendar-check" class="me-2" style="color: var(--brand-vinho); width: 24px; height: 24px;"></i>
                                    <div>
                                        <strong style="color: var(--brand-vinho);">Escalas Disponíveis</strong>
                                        <p class="mb-0 small text-muted">
                                            Consulte suas escalas na área "Minhas Escalas" do menu.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informações -->
            <div class="card-paroquia">
                <div class="card-header-paroquia">
                    <h3 class="card-title-paroquia mb-0">
                        <i data-lucide="info" class="me-2"></i>
                        Por que não posso solicitar outro grupo?
                    </h3>
                </div>
                <div class="card-body-paroquia">
                    <div class="d-flex align-items-start mb-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" 
                             style="width: 50px; height: 50px; background-color: var(--bg-rose);">
                            <i data-lucide="shield-check" style="width: 24px; height: 24px; color: var(--brand-vinho);"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-2" style="color: var(--brand-vinho);">Dedicação e Compromisso</h5>
                            <p class="text-muted mb-0">
                                Por regra paroquial, cada fiel pode participar de <strong>apenas um grupo ou pastoral</strong> por vez. 
                                Isso garante dedicação adequada e permite que você se envolva profundamente nas atividades do seu grupo atual.
                            </p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" 
                             style="width: 50px; height: 50px; background-color: var(--bg-rose);">
                            <i data-lucide="heart-handshake" style="width: 24px; height: 24px; color: var(--brand-vinho);"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-2" style="color: var(--brand-vinho);">Como mudar de grupo?</h5>
                            <p class="text-muted mb-0">
                                Se você deseja mudar de grupo, entre em contato com o coordenador do seu grupo atual 
                                ou com a secretaria paroquial. Após sair do grupo atual, você poderá solicitar entrada em outro.
                            </p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" 
                             style="width: 50px; height: 50px; background-color: var(--bg-rose);">
                            <i data-lucide="phone" style="width: 24px; height: 24px; color: var(--brand-vinho);"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-2" style="color: var(--brand-vinho);">Precisa de ajuda?</h5>
                            <p class="text-muted mb-2">
                                Nossa secretaria está à disposição para orientá-lo sobre mudanças de grupo ou dúvidas sobre participação.
                            </p>
                            <div class="d-flex gap-3 flex-wrap">
                                <a href="tel:+5518999999999" class="text-decoration-none" style="color: var(--brand-vinho);">
                                    <i data-lucide="phone" class="icon-paroquia"></i>
                                    (18) 99999-9999
                                </a>
                                <a href="mailto:contato@paroquia.com" class="text-decoration-none" style="color: var(--brand-vinho);">
                                    <i data-lucide="mail" class="icon-paroquia"></i>
                                    contato@paroquia.com
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="d-flex gap-3 mt-4 flex-wrap">
                <a href="{{ route('dashboard') }}" class="btn-paroquia btn-primary-paroquia">
                    <i data-lucide="home" class="icon-paroquia"></i>
                    Voltar ao Início
                </a>
                
                @if($currentGroup->requires_scale)
                <a href="{{ route('user.scales.index') }}" class="btn-paroquia btn-outline-paroquia">
                    <i data-lucide="calendar-days" class="icon-paroquia"></i>
                    Ver Minhas Escalas
                </a>
                @endif

                <a href="{{ route('groups') }}" class="btn-paroquia btn-outline-paroquia">
                    <i data-lucide="users" class="icon-paroquia"></i>
                    Conhecer Outros Grupos
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>
@endpush
