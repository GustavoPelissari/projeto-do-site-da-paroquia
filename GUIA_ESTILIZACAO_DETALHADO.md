# 🎨 Guia de Estilização - Paróquia São Paulo Apóstolo

## 📋 Índice
- [Visão Geral](#visão-geral)
- [Paleta de Cores](#paleta-de-cores)
- [Tipografia](#tipografia)
- [Componentes](#componentes)
- [Utilitários](#utilitários)
- [Estrutura CSS](#estrutura-css)
- [Responsividade](#responsividade)
- [Acessibilidade](#acessibilidade)

## 🎯 Visão Geral

A estilização da Paróquia São Paulo Apóstolo foi desenvolvida com foco em:
- **Elegância e reverência** católica
- **Modernidade** sem perder a tradição
- **Acessibilidade** para todos os usuários
- **Responsividade** mobile-first
- **Performance** otimizada

## 🎨 Paleta de Cores

### Cores Principais
```css
--cor-dourado: #D4AF37        /* Divindade, nobreza */
--cor-dourado-escuro: #B8941F /* Variação escura */
--cor-vinho: #8B1538          /* Sangue de Cristo, paixão */
--cor-vinho-escuro: #6B1028   /* Variação escura */
--cor-marrom: #8B7355         /* Terra, humildade */
--cor-marrom-claro: #A68B5B   /* Variação clara */
```

### Cores Neutras
```css
--cor-bege: #F5F3F0           /* Pureza, paz */
--cor-bege-escuro: #E8E4DF    /* Variação escura */
--cor-branco: #FFFFFF         /* Pureza absoluta */
--cor-cinza-claro: #F8F9FA    /* Sutileza */
--cor-cinza-medio: #6C757D    /* Texto secundário */
--cor-cinza-escuro: #343A40   /* Texto principal */
--cor-preto-suave: #2C2C2C    /* Títulos importantes */
```

### Gradientes
```css
--gradiente-dourado: linear-gradient(135deg, #D4AF37 0%, #B8941F 100%)
--gradiente-vinho: linear-gradient(135deg, #8B1538 0%, #6B1028 100%)
--gradiente-celestial: linear-gradient(135deg, #F5F3F0 0%, #FFFFFF 100%)
```

## ✍️ Tipografia

### Fontes
- **Títulos**: Playfair Display (elegante, clássica)
- **Corpo**: Poppins (moderna, legível)

### Hierarquia
```css
h1: 2.5rem (40px)
h2: 2rem (32px)
h3: 1.75rem (28px)
h4: 1.5rem (24px)
h5: 1.25rem (20px)
h6: 1.1rem (17.6px)
```

### Classes Utilitárias
```css
.font-titulo     /* Playfair Display */
.font-corpo      /* Poppins */
.fw-light        /* 300 */
.fw-normal       /* 400 */
.fw-medium       /* 500 */
.fw-semibold     /* 600 */
.fw-bold         /* 700 */
```

## 🧱 Componentes

### Navegação
- **Navbar fixo** com efeito de scroll
- **Transições suaves** nos links
- **Responsivo** com menu hamburger

### Botões
```css
.btn-paroquia              /* Base */
.btn-secondary-paroquia    /* Dourado */
.btn-outline-paroquia      /* Contorno */
```

### Cards
```css
.card-paroquia             /* Card básico */
.card-pastoral             /* Para pastorais */
.card-noticia              /* Para notícias */
.horario-missa             /* Para horários */
```

### Seções
```css
.section-paroquia          /* Seção padrão */
.hero-paroquia             /* Hero principal */
.sobre-nos                 /* Seção sobre */
.secao-doacoes             /* Seção de doações */
```

## 🛠️ Utilitários

### Cores
```css
.text-dourado, .text-vinho, .text-marrom
.bg-dourado, .bg-vinho, .bg-bege
.border-dourado, .border-vinho
```

### Espaçamentos
```css
.p-section        /* padding: 5rem 0 */
.m-section        /* margin: 5rem 0 */
.p-card          /* padding: 2rem */
```

### Sombras
```css
.shadow-suave    /* Sombra leve */
.shadow-media    /* Sombra média */
.shadow-forte    /* Sombra intensa */
```

### Animações
```css
.fade-in         /* Aparece suavemente */
.fade-in-up      /* Aparece de baixo */
.hover-elevate   /* Eleva no hover */
.pulse-slow      /* Pulsa lentamente */
```

## 📱 Responsividade

### Breakpoints
- **xs**: < 576px (mobile)
- **sm**: ≥ 576px (mobile landscape)
- **md**: ≥ 768px (tablet)
- **lg**: ≥ 992px (desktop)
- **xl**: ≥ 1200px (desktop large)

### Classes Responsivas
```css
.text-xs-center    /* Centraliza em mobile */
.flex-sm-col       /* Coluna em tablet */
.grid-md-2         /* 2 colunas em desktop */
```

## ♿ Acessibilidade

### Features Implementadas
- **Focus visível** com outline dourado
- **Contrast ratios** adequados (WCAG AA)
- **Texto alternativo** em imagens
- **Navegação por teclado**
- **Skip links** para conteúdo principal
- **Reduced motion** respeitado

### Classes de Acessibilidade
```css
.sr-only           /* Screen reader only */
.visually-hidden   /* Oculto visualmente */
.skip-link         /* Link para pular conteúdo */
```

## 📁 Estrutura CSS

```
resources/css/
├── app.css           # Estilos principais
├── components.css    # Componentes específicos
└── utilities.css     # Classes utilitárias
```

### app.css
- Variáveis CSS
- Reset e base styles
- Navegação
- Hero section
- Footer
- Animações principais

### components.css
- Cards de pastoral
- Horários de missa
- Notícias e eventos
- Formulários
- Seção de doações

### utilities.css
- Classes de cor
- Tipografia
- Espaçamentos
- Layout helpers
- Estados e interações

## 🎭 Modo Escuro

Preparado para implementação futura:
```css
@media (prefers-color-scheme: dark) {
    /* Variáveis adaptadas */
}
```

## 🖨️ Impressão

Estilos otimizados para impressão:
- Remove navegação e footer
- Ajusta cores para impressão
- Remove sombras e efeitos

## 📝 Convenções de Nomenclatura

### Padrão BEM Adaptado
```css
.card-paroquia           /* Bloco */
.card-paroquia__header   /* Elemento */
.card-paroquia--destaque /* Modificador */
```

### Prefixos Específicos
- `.paroquia-*` - Componentes únicos da paróquia
- `.section-*` - Seções principais
- `.icon-*` - Tamanhos de ícones
- `.text-*` - Cores de texto
- `.bg-*` - Cores de fundo

## 🔧 Desenvolvimento

### Comandos Úteis
```bash
# Desenvolvimento
npm run dev

# Build para produção
npm run build

# Watch mode
npm run watch
```

### Variáveis CSS
Todas as cores, espaçamentos e transições estão centralizadas em variáveis CSS para fácil manutenção.

### Performance
- CSS minificado em produção
- Fontes carregadas de forma otimizada
- Animações com `transform` e `opacity`
- Critical CSS inline quando necessário

## 📚 Referências

### Inspiração Litúrgica
- Cores baseadas na tradição católica
- Tipografia que evoca reverência
- Espaçamentos generosos para respiração
- Simbolismo visual sutil

### Acessibilidade
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [Color Contrast Analyzer](https://www.tpgi.com/color-contrast-checker/)

### Performance
- [Web Vitals](https://web.dev/vitals/)
- [Lighthouse Guidelines](https://developers.google.com/web/tools/lighthouse)

---

## 🙏 Oração pela Paróquia

*"Senhor, abençoe este trabalho digital que visa aproximar os fiéis da casa de Deus. Que cada pixel seja um instrumento de evangelização e cada cor reflita a beleza da criação divina. Amém."*

---

**Desenvolvido com 💛 para a Paróquia São Paulo Apóstolo - Umuarama/PR**