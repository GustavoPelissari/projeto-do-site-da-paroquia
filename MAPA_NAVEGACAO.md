# 🗺️ MAPA DE NAVEGAÇÃO - SISTEMA PARÓQUIA SÃO PAULO APÓSTOLO

## 📋 RESUMO EXECUTIVO
Este documento apresenta o fluxograma completo de navegação do sistema da Paróquia São Paulo Apóstolo, detalhando todos os caminhos que um usuário público pode percorrer até chegar à tela de login.

---

## 🏁 PONTO DE ENTRADA PRINCIPAL

### 1. PÁGINA INICIAL (/)
**URL:** `http://127.0.0.1:8000/`
**Descrição:** Landing page principal da paróquia

#### 🎯 Elementos de Navegação:
- **Header/Navbar** (fixo no topo)
- **Hero Section** (banner principal)
- **Seções de conteúdo**
- **Footer**

#### 🔗 Links Disponíveis no Header:
1. **Logo da Paróquia** → Retorna à página inicial
2. **Início** → `/` (página atual)
3. **Horários** → `/masses`
4. **Pastorais** → `/groups`
5. **Eventos** → `#eventos` (âncora na página)
6. **Contato** → `#contato` (âncora na página)
7. **Apoiar a Paróquia** → `#doacoes` (âncora na página)
8. **🔑 Painel** → `/login` ⭐ **CAMINHO PARA LOGIN**

#### 🎯 Links no Hero Section:
1. **Ver Horários de Missa** → `/masses`
2. **Próxima Celebração** → `#proxima-missa` (âncora)

---

## 🛤️ CAMINHOS DE NAVEGAÇÃO PÚBLICA

### 2. PÁGINA DE HORÁRIOS (/masses)
**Descrição:** Exibe horários de missas e celebrações

#### 🔗 Navegação Disponível:
- **Header completo** (mesmos links da página inicial)
- **🔑 Painel** → `/login` ⭐ **CAMINHO PARA LOGIN**

#### 🎯 Ações Específicas:
- Visualizar horários de missas
- Links para voltar ao início
- Footer com informações de contato

---

### 3. PÁGINA DE PASTORAIS (/groups)
**Descrição:** Lista grupos e pastorais da paróquia

#### 🔗 Navegação Disponível:
- **Header completo** (mesmos links da página inicial)
- **🔑 Painel** → `/login` ⭐ **CAMINHO PARA LOGIN**

#### 🎯 Ações Específicas:
- Visualizar grupos disponíveis
- Botões para "Participar" (requer login)
- Links informativos sobre cada pastoral

---

## 🎯 TODOS OS CAMINHOS PARA A TELA DE LOGIN

### 📍 PONTOS DE ACESSO AO LOGIN:

1. **Header de qualquer página pública:**
   - Botão **"🔑 Painel"** (canto superior direito)
   - Sempre visível para usuários não autenticados

2. **Tentativa de acesso a área restrita:**
   - Qualquer URL `/admin/*` → Redirect para `/login`
   - URLs que requerem autenticação → Redirect para `/login`

3. **Ações que requerem login:**
   - Botões "Participar" em grupos
   - Tentativa de acessar `/group-requests/*`
   - Tentativa de acessar `/dashboard`

4. **URLs diretas:**
   - `/login` (acesso direto)
   - `/register` → Link para login na parte inferior

---

## 🔐 DETALHAMENTO DA TELA DE LOGIN

### 📄 ESTRUTURA DA PÁGINA DE LOGIN (/login)

#### 🎨 **LAYOUT VISUAL:**
```
┌─────────────────────────────────────┐
│           HEADER PARÓQUIA           │ ← Logo + Título da Paróquia
├─────────────────────────────────────┤
│                                     │
│         🏛️ CONTAINER CENTRAL         │
│                                     │
│  ┌─────────────────────────────┐    │
│  │      FORMULÁRIO LOGIN       │    │
│  │                             │    │
│  │  📧 Campo Email             │    │
│  │  🔒 Campo Senha             │    │
│  │  ☑️  Lembrar de mim          │    │
│  │                             │    │
│  │  🔑 [BOTÃO ENTRAR]          │    │
│  │                             │    │
│  │  🔗 Esqueceu sua senha?     │    │
│  │                             │    │
│  │  ──────────────────────     │    │
│  │                             │    │
│  │  ✨ [BOTÃO CADASTRAR]       │    │
│  └─────────────────────────────┘    │
│                                     │
└─────────────────────────────────────┘
```

---

## 🧩 ELEMENTOS FUNCIONAIS DA TELA DE LOGIN

### 🎯 **1. TÍTULO E DESCRIÇÃO**
- **Título:** "Entrar na Paróquia"
- **Subtítulo:** "Acesse sua conta para participar da nossa comunidade"
- **Função:** Contextualizar o login para ambiente religioso

### 📧 **2. CAMPO EMAIL**
- **Label:** "📧 Email"
- **Tipo:** `email`
- **Placeholder:** "seu.email@exemplo.com"
- **Validação:** Obrigatório, formato de email válido
- **Autocomplete:** `username`
- **Autofocus:** Sim (primeiro campo focado)

### 🔒 **3. CAMPO SENHA**
- **Label:** "🔒 Senha"
- **Tipo:** `password`
- **Placeholder:** "Digite sua senha"
- **Validação:** Obrigatório
- **Autocomplete:** `current-password`

### ☑️ **4. CHECKBOX "LEMBRAR DE MIM"**
- **Função:** Manter sessão ativa por mais tempo
- **Nome:** `remember`
- **Label:** "Lembrar de mim"
- **Valor padrão:** Desmarcado

### 🔑 **5. BOTÃO PRINCIPAL DE LOGIN**
- **Texto:** "🔑 Entrar na Paróquia"
- **Classe:** `sp-btn sp-btn-gold sp-btn-full sp-btn-lg`
- **Tipo:** `submit`
- **Ação:** Processa formulário de login
- **Estilo:** Botão dourado em largura total

### 🔗 **6. LINK "ESQUECEU SUA SENHA?"**
- **Texto:** "Esqueceu sua senha?"
- **Destino:** `/forgot-password`
- **Função:** Recuperação de senha por email
- **Condicional:** Só aparece se rota estiver habilitada

### ✨ **7. SEÇÃO DE CADASTRO**
- **Separador visual:** Linha horizontal
- **Texto informativo:** "Ainda não é membro da nossa paróquia?"
- **Botão:** "✨ Cadastrar-se Agora"
- **Destino:** `/register`
- **Estilo:** Botão outline em largura total

---

## 🚨 SISTEMA DE MENSAGENS E VALIDAÇÃO

### ✅ **MENSAGENS DE SUCESSO:**
- Exibidas no topo via `session('status')`
- Estilo: Alert verde com ícone de sucesso

### ❌ **MENSAGENS DE ERRO:**
- **Erro de email:** "O campo email é obrigatório" / "Email inválido"
- **Erro de senha:** "O campo senha é obrigatório"
- **Erro de autenticação:** "Credenciais inválidas"
- **Posição:** Abaixo de cada campo respectivo

### ⚠️ **VALIDAÇÕES EM TEMPO REAL:**
- Email: Formato válido obrigatório
- Senha: Campo obrigatório
- CSRF Token: Proteção automática

---

## 🔄 FLUXOS PÓS-LOGIN

### 🎯 **REDIRECIONAMENTO BASEADO EM PERFIL:**

```
LOGIN BEM-SUCEDIDO
        ↓
   VERIFICAR ROLE
        ↓
    ┌─────────┐
    │ ADMIN   │ → /admin/global/* (Dashboard Admin Global)
    │ GLOBAL  │
    └─────────┘
        ↓
    ┌─────────┐
    │COORDENA-│ → /admin/coordenador/* (Dashboard Coordenador)
    │DOR      │
    └─────────┘
        ↓
    ┌─────────┐
    │ADMINIS- │ → /admin/administrativo/* (Dashboard Admin)
    │TRATIVO  │
    └─────────┘
        ↓
    ┌─────────┐
    │ USUÁRIO │ → Retorna ao ponto de origem ou /
    │ COMUM   │
    └─────────┘
```

---

## 🌐 CONTEXTO ADICIONAL

### 🎨 **CARACTERÍSTICAS DE DESIGN:**
- **Paleta:** Vermelho apostólico (#8B1538) como cor principal
- **Tipografia:** Playfair Display (títulos) + Poppins (corpo)
- **Layout:** Responsivo com utilitários Tailwind
- **Ícones:** Lucide Icons
- **Tema:** Reverente e elegante para ambiente religioso

### 🔒 **SEGURANÇA IMPLEMENTADA:**
- CSRF Protection em todos os formulários
- Rate limiting para tentativas de login
- Sanitização de inputs
- Validação server-side
- Hash seguro de senhas (bcrypt)

### 📱 **RESPONSIVIDADE:**
- Layout adaptável para mobile, tablet e desktop
- Formulário otimizado para telas pequenas
- Navegação touch-friendly
- Botões com tamanho adequado para toque

---

## 📊 RESUMO DE NAVEGAÇÃO

```
PÁGINA INICIAL (/)
    ├── Horários (/masses)
    ├── Pastorais (/groups)
    ├── Eventos (#eventos)
    ├── Contato (#contato)
    ├── Doações (#doacoes)
    └── 🔑 PAINEL → LOGIN (/login)
            ├── 📧 Campo Email
            ├── 🔒 Campo Senha
            ├── ☑️ Lembrar-me
            ├── 🔑 [Entrar]
            ├── 🔗 Esqueceu senha? → /forgot-password
            └── ✨ [Cadastrar] → /register
                    └── Link para Login
```

Este mapa garante que qualquer usuário público possa facilmente encontrar e acessar a tela de login através de múltiplos caminhos intuitivos! 🙏