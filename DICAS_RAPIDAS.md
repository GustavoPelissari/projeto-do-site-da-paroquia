# ⚡ Dicas Rápidas e Referência Rápida

**Última atualização:** 5 de dezembro de 2025

---

## 🚀 Acesso Rápido

### Acessar o Sistema

**Local (seu computador):**
```
http://localhost:8000
```

**Rede (celular/outro PC):**
```
http://192.168.18.71:8000
```

### Dev Server (Vite)
```
http://192.168.18.71:5174
```

---

## 📚 Documentação Rápida

### Quero entender o projeto rapidamente
👉 **5 minutos:** `RESUMO_EXECUTIVO.md`

### Quero aprender a usar o sistema
👉 **1 hora:** `GUIA_FUNCIONALIDADES.md`

### Quero ver a arquitetura
👉 **45 minutos:** `ANALISE_COMPLETA.md`

### Quero desenvolver/expandir
👉 **55 minutos:** `DESENVOLVIMENTO.md`

### Quero detalhes técnicos
👉 **50 minutos:** `ANALISE_TECNICA.md`

### Não sei onde procurar
👉 **10 minutos:** `INDICE_DOCUMENTACAO.md`

---

## 💻 Comandos Essenciais

### Laravel

```bash
# Ver help
php artisan

# Criar recurso completo
php artisan make:model Resource -msfc

# Executar migrações
php artisan migrate
php artisan migrate:rollback
php artisan migrate:refresh

# Seeder
php artisan db:seed

# Tinker (shell interativa)
php artisan tinker

# Testes
php artisan test

# Cache
php artisan cache:clear
php artisan config:cache

# Logs
tail -f storage/logs/laravel.log
```

### NPM

```bash
# Instalar
npm install

# Dev
npm run dev

# Build
npm run build

# Atualizar
npm update
```

### Composer

```bash
# Instalar
composer install

# Update
composer update

# Require novo pacote
composer require vendor/package
```

---

## 🔐 Usuários Teste

### Admin Global
```
Email: admin@example.com
Senha: password
Role: admin_global
Acesso: /admin
```

### Administrativo
```
Email: admin-administrativo@example.com
Senha: password
Role: administrativo
Acesso: /admin/administrativo
```

### Coordenador
```
Email: coordenador@example.com
Senha: password
Role: coordenador_de_pastoral
Acesso: /admin/coordenador
```

### Usuário Padrão
```
Email: usuario@example.com
Senha: password
Role: usuario_padrao
Acesso: /user/dashboard
```

**Nota:** Verificar `USUARIOS_TESTE.md` para credenciais atualizadas.

---

## 📁 Estrutura de Pastas Rápida

```
paroquia-sistema/
├─ app/              ← Código backend
│  ├─ Models/        ← Dados
│  ├─ Http/          ← Requisições/Respostas
│  └─ Services/      ← Lógica de negócio
├─ database/         ← Banco de dados
│  ├─ migrations/    ← Estrutura das tabelas
│  └─ seeders/       ← Dados iniciais
├─ resources/        ← Frontend
│  ├─ views/         ← Templates HTML
│  ├─ css/           ← Estilos
│  └─ js/            ← JavaScript
├─ routes/           ← URLs/Rotas
├─ storage/          ← Logs e arquivos
├─ public/           ← Arquivos públicos
├─ bootstrap/        ← Inicialização
├─ config/           ← Configurações
└─ tests/            ← Testes
```

---

## 🔄 Fluxos Principais

### 1. Novo Usuário
```
1. Registra em /register
2. Recebe email de verificação
3. Clica no link
4. Email verificado
5. Faz login
6. Redirecionado para dashboard
```

### 2. Solicitar Grupo
```
1. Usuário autenticado em /groups
2. Clica em "Solicitar"
3. Coordenador recebe notificação
4. Coordenador aprova/rejeita
5. Usuário recebe notificação
6. Se aprovado, entra no grupo
```

### 3. Publicar Notícia
```
1. Admin em /admin/news/create
2. Preenche formulário
3. Clica em "Publicar"
4. Notícia aparece no site
5. Usuários recebem notificação
6. Aparece em /news
```

---

## 🎨 Cores do Projeto

```
Principal:      #8B1E3F (Vermelho São Paulo)
Escuro:         #6E1530
Dourado:        #FFD66B
Rosa Claro:     #F4E9E1
Texto:          #2C2C2C
Fundo Claro:    #FBF7F6
```

---

## 👥 Papéis de Usuário

```
┌────────────────────┬──────────────────────────┐
│ Papel              │ Permissões               │
├────────────────────┼──────────────────────────┤
│ admin_global       │ Tudo                     │
│ administrativo     │ Notícias, Eventos       │
│ coordenador_*      │ Seu grupo               │
│ usuario_padrao     │ Solicitar, Ver escalas  │
│ visitante          │ Apenas visualizar       │
└────────────────────┴──────────────────────────┘
```

---

## 🗄️ Modelos Principais

```
User             → Usuários do sistema
Group            → Pastorais/Grupos
News             → Notícias
Event            → Eventos
Mass             → Horários de missa
GroupRequest     → Solicitações de grupos
Schedule         → Escalas publicadas
Notification     → Notificações do sistema
AuditLog         → Log de auditoria
```

---

## 🔗 Rotas Principais

```
GET  /                          # Página inicial
GET  /groups                    # Lista grupos
GET  /masses                    # Horários
GET  /events                    # Eventos
GET  /news                      # Notícias

POST /register                  # Registrar
POST /login                     # Login
POST /group-requests            # Solicitar grupo

GET  /admin                     # Dashboard admin global
GET  /admin/administrativo      # Dashboard admin
GET  /admin/coordenador         # Dashboard coordenador
GET  /user/dashboard            # Dashboard usuário
```

---

## 🔍 Debugging

### Ver Logs
```bash
tail -f storage/logs/laravel.log
```

### Usar Tinker
```bash
php artisan tinker
>>> User::count()
>>> User::first()->email
```

### Dump & Die
```php
dd($variable);
dump($variable);
```

### Debug no Blade
```blade
{{ dump($variable) }}
```

---

## 📊 Estatísticas Rápidas

| Métrica | Valor |
|---------|-------|
| Controllers | 25+ |
| Models | 13 |
| Migrations | 26+ |
| Views | 100+ |
| Routes | 296 linhas |
| CSS | 2.296 linhas |
| Users Roles | 5 |
| DB Tables | 26 |
| Documentação | 7 arquivos |

---

## ⚙️ Configuração

### .env Principal
```env
APP_NAME="Paróquia"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://192.168.18.71:8000

DB_DATABASE=paroquia_sistema
DB_USERNAME=root
DB_PASSWORD=
```

### Timezone
```
America/Sao_Paulo
```

### Locale
```
pt_BR
```

---

## 🧪 Testes Rápidos

```bash
# Rodar todos
php artisan test

# Rodar específico
php artisan test tests/Feature/AuthTest.php

# Com filter
php artisan test --filter=login
```

---

## 📈 Performance

### Cache
```php
// Listar cache
php artisan cache:clear

// Config cache
php artisan config:cache

// View cache
php artisan view:cache
```

### Índices BD
```
Úteis em: user_id, group_id, status, created_at
```

---

## 🚀 Deploy Rápido

```bash
# 1. Pull código
git pull origin main

# 2. Instalar deps
composer install --no-dev
npm ci
npm run build

# 3. Banco de dados
php artisan migrate

# 4. Cache
php artisan cache:clear
php artisan config:cache

# 5. Servir
php artisan serve
```

---

## 🆘 Problemas Comuns

### "Porta 8000 em uso"
```bash
php artisan serve --port 8001
```

### "Banco de dados não conecta"
```bash
# Verificar XAMPP está rodando
# Verificar credenciais em .env
# Criar database: paroquia_sistema
```

### "Dependências faltando"
```bash
composer install
npm install
```

### "Cache corrompido"
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

### "Permissões incorretas"
```bash
chmod -R 755 storage bootstrap/cache
chmod -R 644 public
```

---

## 📞 Contatos Úteis

### Documentação
- Laravel: https://laravel.com/docs
- Vite: https://vitejs.dev
- Tailwind: https://tailwindcss.com
- Alpine.js: https://alpinejs.dev

### Help Local
- `RESUMO_EXECUTIVO.md` - Status geral
- `GUIA_FUNCIONALIDADES.md` - Como usar
- `DESENVOLVIMENTO.md` - Como desenvolver

---

## ✨ Dicas Profissionais

### 1. Sempre use migrations
```bash
php artisan make:migration add_field_to_table
```

### 2. Use factory para testes
```php
$users = User::factory(10)->create();
```

### 3. Aproveite scopes
```php
User::active()->recent()->paginate()
```

### 4. Use eager loading
```php
User::with('group', 'notifications')->get()
```

### 5. Valide sempre
```php
$validated = $request->validate([...]);
```

### 6. Documente seu código
```php
/**
 * Descrição do que faz
 */
public function method() {}
```

### 7. Use type hints
```php
public function store(Request $request): Response {}
```

### 8. Teste tudo
```bash
php artisan test
```

---

## 🎯 Checklist Diário

```
Antes de começar a trabalhar:

□ Verificar servidor Laravel rodando
□ Verificar servidor Vite rodando
□ Verificar banco de dados conectado
□ Ler arquivo relevante de documentação
□ Executar testes relacionados

Ao terminar trabalho:

□ Testar funcionalidade implementada
□ Rodar testes: php artisan test
□ Verificar linting: php artisan lint
□ Fazer commit no git
□ Atualizar documentação se necessário
```

---

## 📚 Leitura Recomendada

**Hoje (10 min):**
- `RESUMO_EXECUTIVO.md`

**Esta semana:**
- `GUIA_FUNCIONALIDADES.md`
- `ANALISE_COMPLETA.md`

**Este mês:**
- `ANALISE_TECNICA.md`
- `DESENVOLVIMENTO.md`

---

## 🎉 Último Lembrinha

Você tem **7 documentos completos** explicando cada aspecto do projeto. 

✅ Use-os como referência!  
✅ Compartilhe com a equipe  
✅ Atualize conforme mudanças  
✅ Não hesite em procurar  

**Boa sorte! 🚀**

