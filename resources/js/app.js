import './bootstrap';

// Import Bootstrap JavaScript
import * as bootstrap from 'bootstrap';

// Make Bootstrap available globally for blade templates
window.bootstrap = bootstrap;

// ==========================================
// FUNCIONALIDADES INTERATIVAS DA PARÓQUIA
// ==========================================

document.addEventListener('DOMContentLoaded', function() {
    
    // Navbar scroll effect
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }
    
    // Animate on scroll - DESABILITAR NO MOBILE
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
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const offset = navbar ? navbar.offsetHeight : 0;
                const targetPosition = target.offsetTop - offset - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    // Auto-close mobile menu on link click
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                    toggle: true
                });
            }
        });
    });

    // Bootstrap Icons fallback check
    const testIcon = document.createElement('i');
    testIcon.className = 'bi bi-house-door';
    document.body.appendChild(testIcon);
    const computedStyle = window.getComputedStyle(testIcon, '::before');
    const content = computedStyle.getPropertyValue('content');
    if (!content || content === 'none' || content === '""') {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css';
        document.head.appendChild(link);
    }
    document.body.removeChild(testIcon);

    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Schedule PDF modal behavior
    const pdfModal = document.getElementById('pdfModal');
    if (pdfModal) {
        const pdfFrame = pdfModal.querySelector('#pdfFrame');
        pdfModal.addEventListener('show.bs.modal', function(event) {
            const trigger = event.relatedTarget;
            const url = trigger?.getAttribute('data-pdf-url') || '';
            if (pdfFrame) {
                pdfFrame.src = url;
            }
        });
        pdfModal.addEventListener('hidden.bs.modal', function() {
            if (pdfFrame) {
                pdfFrame.src = '';
            }
        });
    }

    // Schedule create: update file name
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

    // Schedule create: auto-fill end date
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
