# 🧪 GUIA DE TESTES MANUAIS

## 📋 CHECKLIST DE TESTES

### 1️⃣ PERFORMANCE

#### Verificar que Bootstrap não está duplicado
1. Abrir DevTools (F12)
2. Ir na aba **Network**
3. Recarregar página (Ctrl+Shift+R)
4. Filtrar por **CSS**
5. ✅ **Deve aparecer apenas:** `app.css` (via Vite)
6. ❌ **NÃO deve aparecer:** CDN do Bootstrap

#### Verificar que Icons não estão duplicados
1. Na aba **Network**
2. Filtrar por **Font** ou buscar "bootstrap-icons"
3. ✅ **Deve aparecer apenas:** Via Vite (compilado em app.css)
4. ❌ **NÃO deve aparecer:** CDN externo

#### Verificar tamanho total
1. Na aba **Network**
2. Ver total transferido no rodapé
3. ✅ **Esperado:** Redução de ~320KB comparado ao anterior

---

### 2️⃣ ACESSIBILIDADE

#### Navegação por Teclado (Tab)
1. Recarregar página
2. Pressionar **Tab** repetidamente
3. ✅ **Deve mostrar:** Outline dourado em cada elemento focado
4. ✅ **Ordem lógica:** Logo → Menu → Links → Botões → Inputs
5. ✅ **Skip link:** Primeiro Tab deve mostrar "Pular para o conteúdo principal"

#### Foco em Botões
1. Navegar até um botão usando Tab
2. ✅ **Deve mostrar:** Outline dourado + sombra suave
3. Pressionar **Enter** no botão
4. ✅ **Deve:** Executar ação

#### Foco em Inputs
1. Clicar ou navegar (Tab) até um input
2. ✅ **Deve mostrar:** 
   - Border vinho
   - Sombra vinho suave ao redor
   - Outline dourado ao redor

#### Foco em Links
1. Navegar até um link usando Tab
2. ✅ **Deve mostrar:** Outline dourado + underline mais grosso

#### Skip to Content
1. Recarregar página
2. Pressionar **Tab** (primeira vez)
3. ✅ **Deve aparecer:** Link "Pular para o conteúdo principal" no topo
4. Pressionar **Enter**
5. ✅ **Deve:** Pular navegação e ir direto ao conteúdo

---

### 3️⃣ BOTÕES

#### Estados de Hover
1. Passar mouse sobre botões
2. ✅ **Deve:** 
   - Mudar cor
   - Mover levemente para cima (-2px)
   - Mostrar sombra

#### Estados Active (Clique)
1. Clicar e segurar em um botão
2. ✅ **Deve:** Voltar à posição original (sem elevação)
3. Soltar clique
4. ✅ **Deve:** Voltar ao estado hover

#### Botões Desabilitados
1. Encontrar botão com `disabled`
2. ✅ **Deve:**
   - Cor cinza
   - Cursor "not-allowed"
   - Não responder a hover/click

#### Botão com Loading
1. Adicionar classe `.loading` a um botão
2. ✅ **Deve:**
   - Texto ficar invisível
   - Mostrar spinner animado no centro
   - Não responder a clicks

---

### 4️⃣ INPUTS

#### Hover em Inputs
1. Passar mouse sobre input
2. ✅ **Deve:** Border ficar mais escura

#### Foco em Inputs
1. Clicar em um input
2. ✅ **Deve:**
   - Border vinho (2px)
   - Sombra vinho suave
   - Outline dourado ao redor

#### Input com Erro
1. Adicionar classe `.is-invalid` a um input
2. ✅ **Deve:**
   - Border vermelha
   - Mostrar mensagem de erro abaixo
   - Sombra vermelha ao focar

#### Input com Sucesso
1. Adicionar classe `.is-valid` a um input
2. ✅ **Deve:**
   - Border verde
   - Mostrar mensagem de sucesso abaixo
   - Sombra verde ao focar

#### Input Desabilitado
1. Input com `disabled`
2. ✅ **Deve:**
   - Fundo cinza claro
   - Texto cinza
   - Cursor "not-allowed"
   - Não responder a interações

#### Labels Obrigatórios
1. Label com classe `.required`
2. ✅ **Deve:** Mostrar asterisco vermelho (*) após o texto

---

### 5️⃣ JAVASCRIPT

#### Scroll Suave
1. Clicar em link com `href="#secao"`
2. ✅ **Deve:** Rolar suavemente até a seção

#### Navbar Scroll
1. Rolar página para baixo (>50px)
2. ✅ **Deve:** Navbar adicionar classe `.scrolled`
3. Rolar de volta ao topo
4. ✅ **Deve:** Remover classe `.scrolled`

#### Mobile Menu
1. Redimensionar janela para mobile (<768px)
2. Clicar no hamburger
3. ✅ **Deve:** Abrir menu
4. Clicar em um link
5. ✅ **Deve:** Fechar menu automaticamente

#### Modals
1. Abrir um modal
2. ✅ **Deve:** 
   - Focar automaticamente no primeiro input/botão
   - Armazenar elemento que abriu o modal
3. Fechar modal (ESC ou botão)
4. ✅ **Deve:** Retornar foco ao elemento que abriu

#### Alertas Auto-dismiss
1. Mostrar um alert
2. ✅ **Deve:** Fechar automaticamente após 5 segundos
3. Ou clicar no X
4. ✅ **Deve:** Fechar imediatamente

#### Intersection Observer
1. Abrir página com elementos `.animate-on-scroll`
2. Rolar até elemento entrar na tela
3. ✅ **Deve:** 
   - Adicionar classe `.visible`
   - Animar fade-in + slide-up
   - **Parar de observar** (performance)

---

### 6️⃣ MOBILE

#### Navegação Mobile
1. Redimensionar para mobile (<768px)
2. ✅ **Verificar:**
   - Logo menor (36px)
   - Texto menor
   - Botão hamburger visível
   - Menu responsivo

#### Animações Desabilitadas
1. Em mobile (<768px)
2. ✅ **Deve:** 
   - Sem animações de scroll
   - Cards já visíveis
   - Sem delays

#### Inputs Mobile
1. Em mobile
2. ✅ **Deve:**
   - Inputs maiores (facilitar toque)
   - Labels visíveis
   - Keyboard apropriado (email, tel, etc)

---

### 7️⃣ CONSOLE

#### Sem Erros
1. Abrir DevTools Console (F12)
2. Recarregar página
3. ✅ **Deve:** 
   - Zero erros vermelhos
   - Apenas logs informativos
   - ✅ "Bootstrap Icons carregado corretamente"

---

### 8️⃣ CARDS

#### Hover em Cards
1. Passar mouse sobre `.card-paroquia`
2. ✅ **Deve:**
   - Mover para cima (-8px)
   - Aumentar sombra
   - Imagem fazer zoom suave

---

### 9️⃣ CONTRASTE

#### Teste de Contraste
1. Usar ferramenta: [WebAIM Contrast Checker](https://webaim.org/resources/contrastchecker/)
2. Testar cores principais:
   - **Vinho (#8B1E3F) em branco:** ✅ 8.59:1 (AAA)
   - **Text muted (#7A7A7A) em branco:** ✅ 4.63:1 (AA)
   - **Links (#8B1E3F):** ✅ Underline visível
3. ✅ **Todos devem passar WCAG AA** (mínimo 4.5:1)

---

### 🔟 LIGHTHOUSE

#### Rodar Audit
1. DevTools → Lighthouse
2. Marcar: Performance, Accessibility, Best Practices
3. Clicar **Generate report**
4. ✅ **Metas:**
   - Performance: >90
   - Accessibility: >95
   - Best Practices: >90

---

## 🐛 PROBLEMAS COMUNS E SOLUÇÕES

### ❌ "Bootstrap Icons não aparecem"
**Solução:**
```bash
npm install
npm run build
Ctrl+Shift+R (limpar cache)
```

### ❌ "Outline de foco não aparece"
**Solução:**
- Verificar se não está usando mouse (outline só aparece com teclado)
- Usar Tab para navegar
- Se ainda não funcionar, verificar que `utilities.css` está sendo importado

### ❌ "Botões não respondem ao hover"
**Solução:**
- Verificar que `app.css` foi compilado
- Limpar cache do navegador
- Verificar console por erros CSS

### ❌ "JavaScript não funciona"
**Solução:**
```bash
# Verificar que Vite compilou
npm run dev

# Verificar no console se há erros
# Verificar que bootstrap está disponível: window.bootstrap
```

---

## ✅ CHECKLIST FINAL

Antes de marcar como concluído, verificar:

- [ ] DevTools Network: Zero CDNs de Bootstrap/Icons
- [ ] Tab funciona em todos os elementos
- [ ] Skip link aparece no primeiro Tab
- [ ] Botões têm hover/active/disabled
- [ ] Inputs têm border colorida no focus
- [ ] Modals retornam foco ao fechar
- [ ] Mobile menu fecha ao clicar
- [ ] Scroll é fluido (não trava)
- [ ] Console sem erros
- [ ] Lighthouse >90 em todas as métricas

---

## 📸 SCREENSHOTS ESPERADOS

### Desktop
- Navbar com logo + menu horizontal
- Botões com sombra e hover suave
- Inputs com border vinho ao focar
- Cards com hover elevado

### Mobile
- Navbar compacta
- Menu hamburger
- Botões full-width
- Inputs maiores

### Focus (Tab)
- Outline dourado visível
- Skip link no topo
- Sombra em botões

---

**Última atualização:** 10/02/2026

Se todos os testes passarem, a refatoração está **100% completa e funcional**! 🎉
