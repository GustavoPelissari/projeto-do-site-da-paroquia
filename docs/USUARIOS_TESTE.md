# USUÁRIOS DE TESTE - SISTEMA PAROQUIAL

## Credenciais para Login

### 🔴 **ADMINISTRADOR GLOBAL** (Padre Admin)
- **Email:** `admin@paroquia.test`
- **Senha:** `Admin123!`
- **Permissões:** Todas as funcionalidades do sistema

### 🟡 **COORDENADOR DE PASTORAL**
- **Email:** `coord.coroinhas@paroquia.test`
- **Senha:** `Coord123!`
- **Permissões:** 
  - Gerenciar notícias e eventos do próprio grupo
  - Editar informações do próprio grupo
  - Gerenciar escalas do grupo
  - Gerenciar agendamentos
  - Aprovar/rejeitar solicitações de participação

### 🟠 **ADMINISTRATIVO**
- **Email:** `administrativo@paroquia.test`
- **Senha:** `Adm123!`
- **Permissões:**
  - Criar/editar/deletar missas
  - Criar notícias e eventos (não globais)
  - Criar e gerenciar grupos
  - Editar e deletar grupos

### 🟢 **USUÁRIO PADRÃO**
- **Email:** `maria@paroquia.test`
- **Senha:** `User123!`
- **Permissões:**
  - Visualizar conteúdos
  - Solicitar ingresso em grupos

### 💚 **USUÁRIO COROINHA**
- **Email:** `pedro.coroinha@paroquia.test`
- **Senha:** `User123!`
- **Grupo:** Coroinhas (usuario_padrao)
- **Permissões:**
  - Visualizar conteúdos
  - Visualizar escalas do grupo (apenas leitura)
  - Baixar PDFs das escalas

---

## Estrutura de Permissões

### Admin Global
- ✅ Gerenciar usuários e funções
- ✅ Criar/editar/deletar missas
- ✅ Criar/editar notícias (incluindo globais)
- ✅ Criar/editar eventos
- ✅ Criar novos grupos
- ✅ Editar todos os grupos
- ✅ Deletar grupos
- ✅ Gerenciar escalas
- ✅ Aprovar solicitações
- ✅ Configurações do sistema
- ✅ Logs de auditoria
- ✅ Estatísticas da paróquia

### Coordenador de Pastoral
- ❌ Gerenciar usuários
- ❌ Gerenciar missas (apenas visualização)
- ✅ Criar/editar notícias (do próprio grupo)
- ✅ Criar/editar eventos (do próprio grupo)
- ✅ Editar informações do próprio grupo
- ✅ Gerenciar escalas (do próprio grupo)
- ✅ Gerenciar agendamentos (do próprio grupo)
- ✅ Aprovar/rejeitar solicitações (do próprio grupo)
- ❌ Criar novos grupos
- ❌ Deletar grupos
- ❌ Configurações do sistema
- ❌ Logs de auditoria

### Administrativo
- ❌ Gerenciar usuários
- ✅ Criar/editar/deletar missas
- ✅ Criar/editar notícias (não pode criar notícias globais)
- ✅ Criar/editar eventos
- ✅ Criar novos grupos
- ✅ Editar todos os grupos
- ✅ Deletar grupos
- ❌ Gerenciar escalas
- ❌ Aprovar solicitações
- ❌ Configurações do sistema
- ❌ Logs de auditoria

### Usuário Padrão
- ❌ Gerenciar usuários
- ❌ Gerenciar missas
- ❌ Criar/editar notícias
- ❌ Gerenciar grupos
- ❌ Gerenciar escalas
- ❌ Aprovar solicitações
- ❌ Deletar grupos
- ❌ Configurações do sistema
- ❌ Logs de auditoria

---

## Como Usar

1. **Acesse o sistema de login** em `/login`
2. **Escolha um usuário** da lista acima
3. **Digite as credenciais** correspondentes
4. **Teste as funcionalidades** conforme as permissões

## Dados Adicionais Criados

O DevSeeder também criou:
- **3 Grupos/Pastorais:** Coroinhas, Vicentinos, Ministros Extraordinários
- **3 Horários de Missa:** Domingo manhã (8h), Domingo noite (19h), Sábado (19h)
- **1 Notícia de teste:** Bem-vindos à Paróquia São Paulo Apóstolo
- **1 Escala PDF:** Escala Coroinhas - Dezembro 2025
- **1 Solicitação de ingresso:** Maria Usuario para Coroinhas
- **1 Notificação de teste**

---

## Comandos Úteis

```bash
# Ver todos os usuários
php list_users_simple.php

# Executar migrações
php artisan migrate

# Executar seeders de desenvolvimento
php artisan db:seed --class=DevSeeder

# Resetar banco e recriar dados (⚠️ APAGA TUDO!)
php artisan migrate:fresh --seed
```

## 🗄️ Gerenciar Banco de Dados via phpMyAdmin

Acesse: **http://localhost/phpmyadmin**

- Usuário: `root`
- Senha: *(vazio)*
- Banco: `paroquia_sistema`

**Dica:** Use o phpMyAdmin para visualizar dados, fazer backups ou executar consultas SQL manuais.