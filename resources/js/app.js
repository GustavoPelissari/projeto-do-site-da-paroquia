import './bootstrap';

// ==========================================
// JS leve e Bootstrap-first (sem Alpine)
// ==========================================

document.addEventListener('DOMContentLoaded', function () {
    // Navbar scroll effect (opcional)
    const navbar = document.querySelector('.js-navbar-scroll');
    if (navbar) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) navbar.classList.add('is-scrolled');
            else navbar.classList.remove('is-scrolled');
        });
    }

    // Smooth scroll para âncoras internas (se existir)
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (!href || href === '#') return;

            const target = document.querySelector(href);
            if (!target) return;

            e.preventDefault();
            const offset = document.querySelector('.navbar.fixed-top')?.offsetHeight ?? 0;
            const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset - 16;

            window.scrollTo({ top: targetPosition, behavior: 'smooth' });
        });
    });

    // Lucide icons (só se carregado no layout)
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Auto-fechar menu mobile ao clicar num link (se navbar collapse estiver aberto)
    const navbarCollapse = document.querySelector('.navbar-collapse');
    document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
        link.addEventListener('click', () => {
            if (!navbarCollapse) return;
            if (!navbarCollapse.classList.contains('show')) return;

            if (typeof bootstrap !== 'undefined' && bootstrap.Collapse) {
                bootstrap.Collapse.getOrCreateInstance(navbarCollapse).hide();
            } else {
                navbarCollapse.classList.remove('show');
            }
        });
    });

    // Próxima missa (só roda se existir o container)
    const proximaMissaEl = document.querySelector('#proxima-missa-info');
    if (proximaMissaEl) {
        atualizarProximaMissa();
        setInterval(atualizarProximaMissa, 60000);
    }
});

// Função para calcular próxima missa
function calcularProximaMissa() {
    const agora = new Date();
    const diaSemana = agora.getDay(); // 0 = domingo
    const horaAtual = agora.getHours() + (agora.getMinutes() / 60);

    const horarios = {
        0: ['09:30', '18:00'], // Domingo
        3: ['20:00'],          // Quarta
        6: ['19:30']           // Sábado
    };

    let proximaMissa = null;

    if (horarios[diaSemana]) {
        for (let horario of horarios[diaSemana]) {
            const [h, m] = horario.split(':').map(Number);
            const horaMissa = h + (m / 60);
            if (horaMissa > horaAtual) {
                proximaMissa = {
                    dia: 'hoje',
                    horario,
                    data: new Date(agora.getFullYear(), agora.getMonth(), agora.getDate(), h, m)
                };
                break;
            }
        }
    }

    if (!proximaMissa) {
        for (let i = 1; i <= 7; i++) {
            const dataFutura = new Date(agora);
            dataFutura.setDate(agora.getDate() + i);
            const diaFuturo = dataFutura.getDay();

            if (horarios[diaFuturo]) {
                const horario = horarios[diaFuturo][0];
                const [h, m] = horario.split(':').map(Number);

                proximaMissa = {
                    dia: ['domingo', 'segunda', 'terça', 'quarta', 'quinta', 'sexta', 'sábado'][diaFuturo],
                    horario,
                    data: new Date(dataFutura.getFullYear(), dataFutura.getMonth(), dataFutura.getDate(), h, m)
                };
                break;
            }
        }
    }

    return proximaMissa;
}

function atualizarProximaMissa() {
    const elemento = document.querySelector('#proxima-missa-info');
    if (!elemento) return;

    const proximaMissa = calcularProximaMissa();
    if (!proximaMissa) return;

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
        <div class="row text-center g-3">
            <div class="col-md-4">
                <div class="border rounded-3 p-3 h-100">
                    <div class="text-muted small">Dia</div>
                    <div class="fw-semibold">${diasSemana[proximaMissa.dia]}</div>
                    <div class="small">${dataFormatada}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded-3 p-3 h-100">
                    <div class="text-muted small">Horário</div>
                    <div class="fw-semibold">${proximaMissa.horario}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded-3 p-3 h-100">
                    <div class="text-muted small">Local</div>
                    <div class="fw-semibold">Igreja Matriz</div>
                </div>
            </div>
        </div>
    `;
}

// Export para testes
export { calcularProximaMissa, atualizarProximaMissa };
