# 📚 Guia de Funcionalidades - Paróquia Sistema

## 🎯 Índice
1. [Site Público](#site-público)
2. [Sistema de Autenticação](#sistema-de-autenticação)
3. [Dashboard Administrativo](#dashboard-administrativo)
4. [Gestão de Grupos](#gestão-de-grupos)
5. [Gestão de Notícias](#gestão-de-notícias)
6. [Gestão de Eventos](#gestão-de-eventos)
7. [Gestão de Missas](#gestão-de-missas)
8. [Sistema de Escalas](#sistema-de-escalas)
9. [Notificações](#notificações)
10. [Auditoria](#auditoria)

---

## 🏠 Site Público

### Página Inicial (/)
**Acesso:** Sem login  
**Conteúdo:**
- Informações sobre a paróquia
- Destaques da semana
- Links para seções principais
- Horários próximos

**Componentes:**
- Hero section
- Featured news
- Upcoming events
- Quick links

### Horários de Missa (/masses)
**Acesso:** Sem login  
**Exibe:**
- Dias da semana
- Horários de missa
- Capelas
- Padres celebrantes

**Funcionalidades:**
- ✅ Filtro por dia
- ✅ Visualização de mapa
- ✅ Download de PDF (futuro)

### Grupos/Pastorais (/groups)
**Acesso:** Sem login  
**Exibe:**
- Lista de grupos ativos
- Descrição de cada grupo
- Coordenador e contato
- Foto do grupo
- Botão "Solicitar Entrada"

**Categorias:**
- Liturgia
- Pastoral
- Serviço
- Caridade
- Formação
- Catequese
- Juventude
- Família
- Geral

**Funcionalidades Autenticadas:**
- ✅ Clicar em grupo para ver detalhes
- ✅ Botão "Solicitar Entrada" se não membro
- ✅ Ver membros (se coordenador)

### Eventos (/events)
**Acesso:** Sem login  
**Exibe:**
- Calendário de eventos
- Data e hora
- Local
- Descrição
- Foto do evento
- Capacidade

**Filtros:**
- Por data
- Por categoria
- Por status

**Detalhe do Evento** (/events/{id})
- Descrição completa
- Localização no mapa
- Lista de participantes confirmados
- Botão "Confirmar presença"

### Notícias (/news)
**Acesso:** Sem login  
**Exibe:**
- Grid responsivo de notícias
- Imagem destacada
- Título e excerpt
- Data de publicação
- Badge de categoria

**Modal de Notícia** (ao clicar)
- Conteúdo completo
- Imagens
- Data e autor
- Compartilhamento

**Funcionalidades:**
- ✅ Paginação
- ✅ Ordenação por data
- ✅ Busca (futuro)

### Sobre (/sobre)
**Acesso:** Sem login  
**Conteúdo:**
- História da paróquia
- Missão e visão
- Equipe pastoral
- Localização
- Contato

---

## 🔐 Sistema de Autenticação

### Registro (/register)
**Campos:**
```
- Nome completo (required)
- Email (required, unique)
- Senha (required, min 8 chars)
- Confirmação de senha
- Data de nascimento (optional)
- Telefone (optional)
- Endereço (optional)
```

**Pós-Registro:**
- ✅ Email de verificação enviado
- ✅ Redirecionado para verificar email
- ✅ Link com token válido por 24h

### Login (/login)
**Campos:**
```
- Email (required)
- Senha (required)
- Lembrar-me (checkbox)
```

**Validações:**
- ✅ Email verificado
- ✅ Conta ativa
- ✅ Rate limiting (5 tentativas)

**Pós-Login:**
- ✅ Redirecionado para dashboard apropriado
- ✅ Session criada
- ✅ Cookie seguro

### Verificação de Email
**Fluxo:**
1. Link no email com token
2. Clica no link
3. Email verificado
4. Acesso ao dashboard liberado

**Opções:**
- ✅ Reenviar email
- ✅ Mudar email se não verificado

### Reset de Senha
**Fluxo:**
1. Clica "Esqueci minha senha"
2. Insere email
3. Email com link de reset enviado
4. Clica no link
5. Insere nova senha
6. Volta para login

**Segurança:**
- ✅ Token com expiração (60 min)
- ✅ Pode usar apenas uma vez
- ✅ IP logging (futuro)

### Perfil de Usuário (/profile)
**Edições Permitidas:**
- Nome
- Email
- Foto de perfil
- Data de nascimento
- Telefone
- Endereço

**Ações:**
- ✅ Editar perfil
- ✅ Mudar senha
- ✅ Deletar conta (com confirmação)

**Confirmação de Ações Sensíveis:**
- ✅ Deletar conta = requer senha
- ✅ Mudar email = verificação necessária

---

## 👨‍💼 Dashboard Administrativo

### Dashboard Admin Global (/admin)
**Visão Geral:**
- Estatísticas do sistema
- Usuários online
- Ações recentes
- Gráficos de atividade

**Acesso:**
- ✅ Apenas `admin_global`

**Widgets:**
1. **Total de Usuários**
   - Usuários ativos
   - Últimas inscrições
   - Por role

2. **Atividade Recente**
   - Últimas ações
   - Quem fez o quê
   - Quando

3. **Grupos**
   - Ativos vs inativos
   - Membros por grupo
   - Solicitações pendentes

4. **Notícias e Eventos**
   - Publicadas
   - Rascunhos
   - Próximos

### Dashboard Administrativo (/admin/administrativo)
**Acesso:**
- ✅ Apenas `administrativo`

**Funcionalidades:**
- Criar/editar notícias
- Criar/editar eventos
- Aprovar solicitações de grupos
- Ver estatísticas básicas

### Dashboard Coordenador (/admin/coordenador)
**Acesso:**
- ✅ Apenas `coordenador_de_pastoral`

**Funcionalidades:**
- Gerenciar seu grupo
- Gerenciar membros
- Criar escalas
- Aprovar/rejeitar solicitações

### Dashboard Usuário (/user/dashboard)
**Acesso:**
- ✅ Qualquer usuário autenticado

**Conteúdo:**
- Meus grupos
- Minhas solicitações pendentes
- Escalas que participo
- Notificações recentes
- Próximos eventos

---

## 👥 Gestão de Grupos

### Criar Grupo (/admin/groups/create)
**Acesso:** `admin_global`

**Campos:**
```
- Nome (required, unique)
- Descrição (required, min 10 chars)
- Categoria (select)
- Coordenador (select user)
- Nome do Coordenador (auto-filled)
- Telefone Coordenador
- Email Coordenador
- Informações de Reunião
- Foto do Grupo
- Máximo de Membros
- Requer Escala? (boolean)
- Ativo? (boolean)
```

**Validações:**
- ✅ Nome único
- ✅ Descrição mínima
- ✅ Coordenador válido
- ✅ Foto máx 2MB
- ✅ Máximo de membros > 0

### Listar Grupos (/admin/groups)
**Exibe:**
- Tabela com todos grupos
- Colunas: Nome, Categoria, Membros, Status
- Botões: Editar, Deletar, Ver Detalhes

**Filtros:**
- ✅ Por categoria
- ✅ Por status (ativo/inativo)
- ✅ Busca por nome

**Ordenação:**
- ✅ Por nome
- ✅ Por quantidade de membros
- ✅ Por data de criação

### Editar Grupo (/admin/groups/{id}/edit)
**Campos Editáveis:**
- Nome
- Descrição
- Categoria
- Coordenador
- Contatos
- Foto
- Máximo de membros
- Requer escala
- Status ativo

**Log de Mudanças:**
- ✅ Registra o quê mudou
- ✅ Quem fez a mudança
- ✅ Quando foi feito

### Deletar Grupo (/admin/groups/{id})
**Confirmação:**
- ✅ Aviso: "Tem certeza?"
- ✅ Informar: membros serão removidos
- ✅ Verificar se coordenador confirma

**O que acontece:**
- Grupo marcado como deletado
- Membros removidos
- Escalas arquivadas
- Log criado

### Solicitar Entrada em Grupo (/group-requests/create)
**Acesso:** Usuários autenticados

**Fluxo:**
1. Usuário acessa /groups
2. Clica em "Solicitar Entrada"
3. Sistema cria GroupRequest
4. Status = pending
5. Coordenador recebe notificação

**Campos:**
- Grupo (select)
- Por que deseja entrar? (texto)

### Aprovar/Rejeitar Solicitação (/admin/group-requests/{id}/approve)
**Acesso:** `admin_global`, `coordenador_de_pastoral`

**Fluxo - Aprovar:**
1. Status muda para approved
2. Usuário adicionado ao grupo
3. Notificação enviada
4. Log criado

**Fluxo - Rejeitar:**
1. Status muda para rejected
2. Mensagem de resposta (opcional)
3. Notificação enviada
4. Usuário não entra no grupo

**Fluxo - Em Formação:**
1. Status muda para in_formation
2. Usuário informado
3. Aguarda contato para formação
4. Coordenador pode chamar depois

---

## 📰 Gestão de Notícias

### Criar Notícia (/admin/news/create)
**Acesso:** `admin_global`, `administrativo`, `coordenador_de_pastoral`

**Campos:**
```
- Título (required, min 5 chars)
- Excerpt (required, auto-truncado)
- Conteúdo (required, rich text)
- Imagem Destacada (optional, jpg/png, max 2MB)
- Categoria/Grupo (select)
- Status (draft/published)
- Destacada? (boolean)
- Data de Publicação (required se published)
```

**Editor:**
- ✅ Rich text editor (CKEditor/Summernote)
- ✅ Formatação: negrito, itálico, listas, links
- ✅ Inserir imagens
- ✅ Inserir vídeos

### Listar Notícias (/admin/news)
**Exibe:**
- Tabela com todas notícias
- Colunas: Título, Autor, Status, Data, Ações

**Filtros:**
- ✅ Por status (draft/published)
- ✅ Por autor
- ✅ Por categoria
- ✅ Busca por título

**Ordenação:**
- ✅ Por data criação (recente)
- ✅ Por data publicação
- ✅ Por título

**Ações em Massa:**
- ✅ Publicar selecionadas
- ✅ Arquivar selecionadas
- ✅ Deletar selecionadas

### Editar Notícia (/admin/news/{id}/edit)
**Campos Editáveis:**
- Título
- Excerpt
- Conteúdo
- Imagem
- Categoria
- Status
- Data de publicação

**Histórico:**
- ✅ Ver versões anteriores
- ✅ Comparar mudanças
- ✅ Restaurar versão antiga (futuro)

### Publicar/Despublicar Notícia
**Publicar:**
- Data de publicação = agora
- Status = published
- Visível no site público
- Notificação enviada aos usuários

**Despublicar:**
- Status = draft
- Remove do site público
- Não notifica usuários

### Deletar Notícia
**Confirmação:**
- ✅ Aviso: notícia será removida
- ✅ Não pode ser recuperada (depois de sync)
- ✅ Confirmar ação

---

## 🎪 Gestão de Eventos

### Criar Evento (/admin/events/create)
**Campos:**
```
- Título (required)
- Descrição (required, rich text)
- Data (required)
- Hora Início (required)
- Hora Fim (optional)
- Local (required)
- Categoria (select)
- Foto (optional, max 2MB)
- Capacidade (optional, number)
- Status (draft/published)
- Ativo? (boolean)
```

**Categorias Padrão:**
- Missa especial
- Festa
- Encontro
- Palestra
- Reunião
- Formação
- Geral

### Listar Eventos (/admin/events)
**Exibe:**
- Tabela ou cards
- Colunas: Título, Data, Local, Status
- Botões: Editar, Deletar, Ver

**Filtros:**
- ✅ Por data (próximos, passados)
- ✅ Por categoria
- ✅ Por status
- ✅ Busca por título

**Ordenação:**
- ✅ Por data (próximo primeiro)
- ✅ Por data criação

### Editar Evento
**Mesmo formato de criar**

### Deletar Evento
**Confirmação necessária**

### Visualizar Evento (público)
**Mostra:**
- Título e descrição
- Data, hora e local
- Mapa com localização
- Foto
- Botão "Confirmar Presença"
- Comentários (futuro)

---

## ⛪ Gestão de Missas

### Criar Missa (/admin/masses/create)
**Campos:**
```
- Dia da Semana (select)
- Hora (time input)
- Capacidade (optional)
- Capela (select)
- Padre celebrante (select)
```

**Dias Disponíveis:**
- Segunda a Domingo
- Múltiplas missas por dia

### Listar Missas (/admin/masses)
**Exibe:**
- Organizado por dia da semana
- Horários, capacidade, padre

**Ações:**
- ✅ Editar
- ✅ Deletar
- ✅ Ativar/desativar

### Horários Públicos (/masses)
**Exibe:**
- Tabela com dias da semana
- Horários em cada dia
- Padre celebrante
- Capela

---

## 📊 Sistema de Escalas

### O que é Escala?
Distribuição de ministros em grupos (coroinhas, leitores, etc.)

### Criar Escala (/admin/scales/create)
**Acesso:** `admin_global`, `coordenador_de_pastoral`

**Campos:**
```
- Grupo (select, apenas com requires_scale=true)
- Título (ex: "Escala de Coroinhas - Dezembro")
- Descrição (optional)
- Data Início (required)
- Data Fim (required)
- Arquivo Escala (PDF/Excel)
```

### Publicar Escala
**Ação:**
- Distribui para membros do grupo
- Notificação enviada
- Download disponível
- Email enviado

**Membros Recebem:**
- Notificação no sistema
- Email com link de download
- Podem visualizar online

### Versionar Escala
**Possibilidades:**
- ✅ Semana 1, Semana 2, etc.
- ✅ Mes inteiro
- ✅ Período customizado

### Arquivo de Escala
**Formatos Suportados:**
- PDF (recomendado)
- Excel
- Word

**Tamanho Máximo:** 5MB

### Gerenciar Escalas (/admin/scales)
**Exibe:**
- Todas escalas
- Por grupo
- Status (ativa, finalizada)
- Datas

**Ações:**
- ✅ Editar
- ✅ Reenviar
- ✅ Arquivar
- ✅ Deletar

---

## 🔔 Notificações

### Tipos de Notificações

#### 1. Notificação de Solicitação
**Quando:** Usuário solicita entrar em grupo
**Quem recebe:** Coordenador do grupo
**Mensagem:** "Nova solicitação de João para o grupo Coroinhas"

#### 2. Notificação de Status
**Quando:** Solicitação aprovada/rejeitada/em formação
**Quem recebe:** Usuário solicitante
**Mensagem:** "Sua solicitação para Coroinhas foi aprovada!"

#### 3. Notificação de Escala
**Quando:** Nova escala publicada
**Quem recebe:** Membros do grupo
**Mensagem:** "Nova escala de Coroinhas publicada - Dezembro"

#### 4. Notificação de Notícia
**Quando:** Notícia publicada em grupo do usuário
**Quem recebe:** Membros do grupo
**Mensagem:** "Nova notícia publicada em Coroinhas"

### Notificações (/notifications)
**Acesso:** Usuários autenticados

**Exibe:**
- Lista de todas notificações
- Não lidas em destaque
- Ordenação por data (recente)

**Ações:**
- ✅ Marcar como lida
- ✅ Marcar como não lida
- ✅ Deletar notificação
- ✅ Limpar todas

**Badge:**
- ✅ Ícone com número de não lidas
- ✅ Atualiza em tempo real

### Email de Notificação
**Configurável por Usuário:**
- ✅ Receber todas
- ✅ Apenas importantes
- ✅ Desabilitar emails

**Frequência:**
- ✅ Imediato
- ✅ Diário
- ✅ Semanal
- ✅ Nunca

---

## 📋 Auditoria

### O que é Auditado?
- ✅ Criação de usuário
- ✅ Mudança de role
- ✅ Criação/edição/exclusão de grupo
- ✅ Criação/edição/exclusão de notícia
- ✅ Criação/edição/exclusão de evento
- ✅ Aprovação/rejeição de solicitação
- ✅ Publicação de escala

### Log de Auditoria (/admin/system)
**Acesso:** `admin_global` apenas

**Exibe:**
- Data e hora
- Usuário responsável
- Ação realizada
- O que foi alterado
- Valores antigos e novos

**Filtros:**
- ✅ Por usuário
- ✅ Por tipo de ação
- ✅ Por data
- ✅ Por modelo afetado

**Exportar:**
- ✅ PDF
- ✅ CSV
- ✅ Excel

### Rastreabilidade
**Exemplos:**
```
2024-12-05 14:23:45
Admin Global "João Silva" alterou grupo "Coroinhas"
Campo: max_members
De: 20
Para: 25

2024-12-05 10:15:30
Administrativo "Maria" criou notícia "Festa de São Paulo"
Status: published
Autor: Maria

2024-12-05 09:00:00
Coordenador "Pedro" aprovou solicitação
Usuário: Carlos
Grupo: Coroinhas
```

---

## 📱 Funcionalidades Mobile

### Responsive Design
- ✅ Menu hamburger em mobile
- ✅ Botões touch-friendly (48px min)
- ✅ Texto legível sem zoom
- ✅ Imagens responsivas

### Acesso Mobile
```
http://192.168.18.71:8000
```

### Funcionalidades Disponíveis
- ✅ Visualizar notícias
- ✅ Visualizar eventos
- ✅ Visualizar horários
- ✅ Solicitar grupo
- ✅ Ver status de solicitação
- ✅ Download de escala

---

## 🎯 Fluxos Principais

### Fluxo: Novo Usuário
```
1. Visita site (/)
2. Clica "Registrar"
3. Preenche formulário
4. Recebe email de verificação
5. Clica no link
6. Email verificado
7. Faz login
8. Acessa dashboard
9. Solicita entrada em grupo
10. Coordenador aprova
11. Entra no grupo
```

### Fluxo: Publicar Notícia
```
1. Admin acessa /admin/news/create
2. Preenche formulário
3. Clica "Publicar"
4. Notícia aparece no site
5. Usuários recebem notificação
6. Podem visualizar e compartilhar
```

### Fluxo: Publicar Escala
```
1. Coordenador acessa /admin/scales/create
2. Carrega arquivo PDF
3. Clica "Publicar"
4. Membros do grupo recebem notificação
5. Download fica disponível
6. Coordenador pode reenviar
```

---

**Guia atualizado em: 5 de dezembro de 2025**

