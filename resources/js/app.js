import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

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
    
    // Animate on scroll
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
