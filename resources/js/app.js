import './bootstrap';

// Import Bootstrap JavaScript
import * as bootstrap from 'bootstrap';

// Make Bootstrap available globally for blade templates
window.bootstrap = bootstrap;

// ==========================================
// FUNCIONALIDADES INTERATIVAS DA PARÓQUIA
// ==========================================

// Debounce utility function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Throttle utility function
function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

document.addEventListener('DOMContentLoaded', function() {
    
    // ==========================================
    // NAVBAR SCROLL EFFECT (com throttle)
    // ==========================================
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        const handleScroll = throttle(function() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }, 100);
        
        window.addEventListener('scroll', handleScroll, { passive: true });
    }
    
    // ==========================================
    // ANIMATE ON SCROLL - APENAS DESKTOP
    // ==========================================
    const isMobile = window.innerWidth <= 768;
    
    if (!isMobile) {
        // Apenas aplicar animação em desktop
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    // Unobserve após animação para performance
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        // Observe all animate-on-scroll elements
        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });
    } else {
        // Mobile: remover animação de scroll, deixar tudo estático
        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            el.classList.remove('animate-on-scroll');
            el.style.opacity = '1';
            el.style.transform = 'none';
        });
        
        // Remover animação dos cards
        document.querySelectorAll('.card-paroquia').forEach(el => {
            el.style.animation = 'none';
            el.style.opacity = '1';
        });
    }
    
    // ==========================================
    // SMOOTH SCROLL (com delegação)
    // ==========================================
    document.addEventListener('click', function(e) {
        // Verificar se clicou em link com href começando com #
        const anchor = e.target.closest('a[href^="#"]');
        if (!anchor) return;
        
        e.preventDefault();
        const targetId = anchor.getAttribute('href');
        const target = document.querySelector(targetId);
        
        if (target) {
            const offset = navbar ? navbar.offsetHeight : 0;
            const targetPosition = target.offsetTop - offset - 20;
            
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        }
    });
    
    // ==========================================
    // AUTO-CLOSE MOBILE MENU (com delegação)
    // ==========================================
    const navbarCollapse = document.querySelector('.navbar-collapse');
    if (navbarCollapse) {
        navbarCollapse.addEventListener('click', function(e) {
            const navLink = e.target.closest('.nav-link');
            if (!navLink) return;
            
            if (navbarCollapse.classList.contains('show')) {
                const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse) || 
                                 new bootstrap.Collapse(navbarCollapse, { toggle: false });
                bsCollapse.hide();
            }
        });
    }

    // ==========================================
    // BOOTSTRAP ICONS VERIFICATION
    // ==========================================
    const testIcon = document.createElement('i');
    testIcon.className = 'bi bi-house-door';
    testIcon.style.position = 'absolute';
    testIcon.style.left = '-9999px';
    document.body.appendChild(testIcon);
    
    const computedStyle = window.getComputedStyle(testIcon, '::before');
    const content = computedStyle.getPropertyValue('content');
    
    if (content && content !== 'none' && content !== '""') {
        console.log('✅ Bootstrap Icons carregado corretamente');
    } else {
        console.warn('⚠️ Bootstrap Icons pode não estar carregado');
    }
    
    document.body.removeChild(testIcon);

    // ==========================================
    // AUTO-DISMISS ALERTS
    // ==========================================
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = bootstrap.Alert.getInstance(alert) || new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // ==========================================
    // SCHEDULE PDF MODAL
    // ==========================================
    const pdfModal = document.getElementById('pdfModal');
    if (pdfModal) {
        const pdfFrame = pdfModal.querySelector('#pdfFrame');
        
        pdfModal.addEventListener('show.bs.modal', function(event) {
            const trigger = event.relatedTarget;
            const url = trigger?.getAttribute('data-pdf-url') || '';
            if (pdfFrame && url) {
                pdfFrame.src = url;
            }
        });
        
        pdfModal.addEventListener('hidden.bs.modal', function() {
            if (pdfFrame) {
                pdfFrame.src = '';
            }
        });
    }

    // ==========================================
    // SCHEDULE FILE INPUT
    // ==========================================
    const fileInput = document.querySelector('[data-file-input]');
    const fileNameLabel = document.getElementById('file-name');
    if (fileInput && fileNameLabel) {
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                fileNameLabel.textContent = `Arquivo selecionado: ${fileInput.files[0].name}`;
                fileNameLabel.classList.remove('d-none');
            } else {
                fileNameLabel.classList.add('d-none');
            }
        });
    }

    // ==========================================
    // SCHEDULE AUTO-FILL END DATE
    // ==========================================
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    if (startDateInput && endDateInput) {
        startDateInput.addEventListener('change', function() {
            if (!endDateInput.value) {
                const startDate = new Date(startDateInput.value);
                const endOfMonth = new Date(startDate.getFullYear(), startDate.getMonth() + 1, 0);
                endDateInput.value = endOfMonth.toISOString().split('T')[0];
            }
        });
    }
});

// Função para calcular próxima missa
function calcularProximaMissa() {
    const agora = new Date();
    const diaSemana = agora.getDay(); // 0 = domingo, 1 = segunda, etc.
    const hora = agora.getHours();
    const minuto = agora.getMinutes();
    const horaAtual = hora + (minuto / 60);
    
    // Horários das missas
    const horarios = {
        0: ['09:30', '18:00'], // Domingo
        3: ['20:00'],          // Quarta
        6: ['19:30']           // Sábado
    };
    
    let proximaMissa = null;
    
    // Verificar se há missa hoje
    if (horarios[diaSemana]) {
        for (let horario of horarios[diaSemana]) {
            const [h, m] = horario.split(':').map(Number);
            const horaMissa = h + (m / 60);
            
            if (horaMissa > horaAtual) {
                proximaMissa = {
                    dia: 'hoje',
                    horario: horario,
                    data: new Date(agora.getFullYear(), agora.getMonth(), agora.getDate(), h, m)
                };
                break;
            }
        }
    }
    
    // Se não encontrou hoje, procurar nos próximos dias
    if (!proximaMissa) {
        for (let i = 1; i <= 7; i++) {
            const dataFutura = new Date(agora);
            dataFutura.setDate(agora.getDate() + i);
            const diaFuturo = dataFutura.getDay();
            
            if (horarios[diaFuturo]) {
                const horario = horarios[diaFuturo][0]; // Primeira missa do dia
                const [h, m] = horario.split(':').map(Number);
                
                proximaMissa = {
                    dia: ['domingo', 'segunda', 'terça', 'quarta', 'quinta', 'sexta', 'sábado'][diaFuturo],
                    horario: horario,
                    data: new Date(dataFutura.getFullYear(), dataFutura.getMonth(), dataFutura.getDate(), h, m)
                };
                break;
            }
        }
    }
    
    return proximaMissa;
}

// Atualizar informações da próxima missa
function atualizarProximaMissa() {
    const proximaMissa = calcularProximaMissa();
    const elemento = document.querySelector('#proxima-missa-info');
    
    if (elemento && proximaMissa) {
        const diasSemana = {
            'hoje': 'Hoje',
            'domingo': 'Domingo',
            'segunda': 'Segunda-feira', 
            'terça': 'Terça-feira',
            'quarta': 'Quarta-feira',
            'quinta': 'Quinta-feira',
            'sexta': 'Sexta-feira',
            'sábado': 'Sábado'
        };
        
        const dataFormatada = proximaMissa.data.toLocaleDateString('pt-BR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
        
        elemento.innerHTML = `
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="proxima-missa-item">
                        <i class="bi bi-calendar3"></i>
                        <div>
                            <strong>${diasSemana[proximaMissa.dia]}</strong>
                            <br>
                            <small>${dataFormatada}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="proxima-missa-item">
                        <i class="bi bi-clock"></i>
                        <div>
                            <strong>${proximaMissa.horario}</strong>
                            <br>
                            <small>Horário</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="proxima-missa-item">
                        <i class="bi bi-geo-alt"></i>
                        <div>
                            <strong>Igreja Matriz</strong>
                            <br>
                            <small>Local</small>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
}

// Inicializar quando o DOM carregar
document.addEventListener('DOMContentLoaded', atualizarProximaMissa);

// Atualizar a cada minuto
setInterval(atualizarProximaMissa, 60000);

// ==========================================
// GERENCIAMENTO DE FOCO EM MODAIS
// ==========================================
let elementoQueAbriuModal = null;

// Delegação de eventos para todos os modais
document.addEventListener('show.bs.modal', function(e) {
    elementoQueAbriuModal = document.activeElement;
    
    // Focar no primeiro elemento interativo do modal após ser mostrado
    setTimeout(() => {
        const primeiroElemento = e.target.querySelector('button:not([data-bs-dismiss]), [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
        if (primeiroElemento) {
            primeiroElemento.focus();
        }
    }, 150);
});

document.addEventListener('hidden.bs.modal', function() {
    if (elementoQueAbriuModal && document.body.contains(elementoQueAbriuModal)) {
        elementoQueAbriuModal.focus();
        elementoQueAbriuModal = null;
    }
});
