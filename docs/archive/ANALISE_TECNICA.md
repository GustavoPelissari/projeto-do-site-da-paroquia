# 🔍 Análise Técnica Detalhada - Paróquia Sistema

## 📊 Estatísticas do Projeto

### Quantidade de Arquivos
- **Controladores:** 25+
- **Modelos:** 13
- **Migrations:** 26+
- **Views:** 100+
- **Testes:** Feature e Unit tests
- **Linhas de CSS:** 2296
- **Linhas de Rotas:** 296

### Tamanho do Projeto
- **Backend (app/):** ~3000+ linhas de PHP
- **Frontend (resources/):** ~2300+ linhas de CSS
- **Banco de Dados:** 26 tabelas

---

## 🔐 Sistema de Segurança

### 1. Autenticação
```php
// Usa Laravel Breeze com customizações
- Email verification obrigatória
- Password reset seguro
- Notificações customizadas
- Session timeout
```

### 2. Autorização
```php
// Middleware de roles
Route::middleware(['auth', 'admin.area:admin_global'])->group(...)
Route::middleware(['auth', 'verified'])->group(...)

// Enums para roles tipados
enum UserRole: string {
    case ADMIN_GLOBAL
    case ADMINISTRATIVO
    case COORDENADOR_PASTORAL
    case USUARIO_PADRAO
    case VISITANTE
}
```

### 3. Validação
```php
// Form Requests para validação automática
- Validação de input em todos os endpoints
- Mensagens de erro amigáveis
- Rate limiting (disponível)
```

### 4. Criptografia
```php
// Senhas hasheadas com bcrypt
- Database criptografado
- Tokens seguros para reset
- Dados sensíveis protegidos
```

### 5. Auditoria
```
// Tabela audit_logs
- Rastreia todas ações de admin
- Registra mudanças de dados
- Timestamp de todas operações
- User ID para identificar responsável
```

---

## 📊 Modelos Eloquent (ORM)

### 1. User
```php
relationships:
  - hasMany(Group) → Grupos que coordena
  - belongsTo(Group, 'parish_group_id') → Grupo da paróquia
  - hasMany(News) → Notícias criadas
  - hasMany(GroupRequest) → Solicitações feitas
  - hasMany(Notification) → Notificações
  - hasMany(AuditLog) → Logs de auditoria

methods:
  - isAdminGlobal(), isAdministrativo(), isCoordenador(), isUsuarioPadrao()
  - canManageUsers(), canCreateNews(), canManageGroups(), etc.
  - sendEmailVerificationNotification()
  - sendPasswordResetNotification()
```

### 2. Group (Pastorais)
```php
relationships:
  - hasMany(GroupRequest) → Solicitações
  - hasMany(User, 'parish_group_id') → Membros
  - hasMany(Schedule) → Escalas
  - hasMany(Scale) → Escalas publicadas
  - belongsTo(User, 'coordinator_id') → Coordenador

methods:
  - scopeActive() → Apenas grupos ativos
  - scopeWithSchedules() → Apenas com escalas
  - hasCoordinator(), isCoordinatedBy()
  - getMembersCount(), getPendingRequestsCount()
  - getCurrentSchedule()
```

### 3. News
```php
relationships:
  - belongsTo(User) → Criador
  - belongsTo(Group, 'parish_group_id') → Grupo relacionado

methods:
  - scopePublished() → Apenas publicadas
  - scopeFeatured() → Apenas destaque
  - isPublished()
  - getExcerptAttribute() → Auto-trunca conteúdo
```

### 4. Event
```php
relationships:
  - belongsTo(User) → Criador
  - belongsTo(Group) → Grupo responsável

properties:
  - title, description
  - date, time, location
  - category, status
  - image, capacity
```

### 5. GroupRequest
```php
relationships:
  - belongsTo(User) → Solicitante
  - belongsTo(Group) → Grupo solicitado

status:
  - pending → Aguardando análise
  - approved → Aprovado
  - rejected → Rejeitado
  - in_formation → Em formação
```

### 6. Schedule
```php
relationships:
  - belongsTo(Group)
  - hasMany(Scale) → Escalas publicadas

properties:
  - title, description
  - file_path → PDF/documento da escala
  - start_date, end_date
  - is_active
```

### 7. Scale
```php
relationships:
  - belongsTo(Group)
  - belongsTo(Schedule)

properties:
  - week_number, month, year
  - data (JSON) → Nomes dos escalados
  - published_at
```

### 8. Notification
```php
relationships:
  - belongsTo(User)

properties:
  - type → Tipo de notificação
  - title, message
  - data (JSON) → Dados adicionais
  - read_at → NULL se não lida
```

### 9. AuditLog
```php
properties:
  - user_id → Quem fez a ação
  - action → Create, update, delete
  - model_type, model_id → O que foi alterado
  - changes (JSON) → Valores antigos/novos
  - created_at
```

### 10. Mass
```php
properties:
  - day_of_week → Segunda a Domingo
  - time → Horário
  - capacity → Capacidade
  - chapel_id, clergy_id
```

---

## 🛣️ Roteamento Avançado

### Arquivo: routes/web.php (296 linhas)

#### Estrutura de Rotas
```php
// 1. ROTAS PÚBLICAS
GET /
GET /groups
GET /masses
GET /events
GET /events/{event}
GET /news
GET /news/{news}
GET /sobre

// 2. ROTAS AUTENTICADAS
POST /group-requests
GET /minhas-solicitacoes
GET /notifications

// 3. ADMIN GLOBAL
prefix: /admin
  GET / (dashboard)
  GET /users
  POST /users/{user}/role
  DELETE /users/{user}
  GET /stats
  GET /system
  
  prefix: /news → CRUD completo
  prefix: /events → CRUD completo
  prefix: /groups → CRUD completo
  prefix: /masses → CRUD completo
  prefix: /chapels → CRUD completo
  prefix: /clergy → CRUD completo
  prefix: /scales → CRUD completo

// 4. ADMIN ADMINISTRATIVO
prefix: /admin/administrativo
  GET / (dashboard)
  GET /news
  GET /group-requests

// 5. COORDENADOR
prefix: /admin/coordenador
  GET / (dashboard)
  GET /group/{group}
  GET /members
  GET /schedules

// 6. USUÁRIO PADRÃO
prefix: /user
  GET /dashboard
  GET /scales
  GET /scales/{scale}/download
```

### Middleware Chain
```
┌─────────────────────────────────┐
│   Request Vem do Cliente        │
└────────────┬────────────────────┘
             │
        ┌────▼────────┐
        │ Route Match  │
        └────┬────────┘
             │
      ┌──────▼──────────┐
      │ Middleware      │
      │ - web session   │
      │ - auth:sanctum  │
      │ - verified      │
      │ - admin.area    │
      └──────┬──────────┘
             │
      ┌──────▼──────────┐
      │ Controller      │
      │ Method          │
      └──────┬──────────┘
             │
      ┌──────▼──────────┐
      │ Response View   │
      │ ou Redirect     │
      └────────────────┘
```

---

## 🎨 Sistema de Views

### Estrutura de Blade Templates

```
resources/views/
├── layouts/
│   ├── app.blade.php           # Layout principal
│   ├── guest.blade.php         # Layout para guests
│   └── admin.blade.php         # Layout admin
│
├── components/
│   ├── navbar.blade.php        # Barra de navegação
│   ├── footer.blade.php        # Rodapé
│   ├── dropdown.blade.php      # Componente dropdown
│   ├── card.blade.php          # Card reutilizável
│   ├── alert.blade.php         # Alertas
│   └── ...
│
├── auth/
│   ├── login.blade.php
│   ├── register.blade.php
│   ├── forgot-password.blade.php
│   ├── reset-password.blade.php
│   ├── verify-email.blade.php
│   └── confirm-password.blade.php
│
├── admin/
│   ├── global/
│   │   ├── dashboard.blade.php
│   │   ├── users/
│   │   ├── news/
│   │   ├── events/
│   │   ├── groups/
│   │   └── ...
│   ├── administrativo/
│   │   ├── dashboard.blade.php
│   │   └── ...
│   ├── coordenador/
│   │   ├── dashboard.blade.php
│   │   ├── group.blade.php
│   │   └── ...
│   └── user/
│       ├── dashboard.blade.php
│       └── scales/
│
├── emails/
│   ├── verify-email.blade.php
│   ├── reset-password.blade.php
│   └── verify_code.blade.php
│
├── home.blade.php              # Página inicial
├── groups.blade.php            # Listagem de grupos
├── masses.blade.php            # Horários de missa
├── events.blade.php            # Listagem de eventos
├── event-show.blade.php        # Detalhe de evento
├── news.blade.php              # Listagem de notícias
├── news-show.blade.php         # Detalhe de notícia
└── dashboard.blade.php         # Dashboard genérico
```

---

## 🎨 Componentização CSS/JS

### Tailwind CSS
```
- Utility-first approach
- Responsive breakpoints: sm, md, lg, xl, 2xl
- Custom variables CSS
- Integração com Bootstrap Icons
```

### Alpine.js
```
- Reatividade light-weight
- Manipulação DOM
- Form handling
- Dropdowns, modals, etc.
```

### JavaScript
```
- Axios para requisições AJAX
- Bootstrap JS para componentes
- Suporte a Alpine para interatividade
```

---

## 🔄 Fluxo de Solicitação de Grupo

```
1. USUÁRIO ACESSA /group-requests/create
   │
   ├─ GroupRequestController@create
   │  └─ Retorna view com formulário
   │
2. USUÁRIO PREENCHE E SUBMETE
   │
   ├─ POST /group-requests
   │  └─ GroupRequestController@store
   │     ├─ Valida dados (Form Request)
   │     ├─ Cria GroupRequest::create()
   │     ├─ Status = 'pending'
   │     └─ Notifica coordenador
   │
3. COORDENADOR RECEBE NOTIFICAÇÃO
   │
   ├─ Acessa /admin/coordenador/group/{group}
   │  └─ Vê solicitações pendentes
   │
4. COORDENADOR APROVA/REJEITA
   │
   ├─ POST /admin/coordenador/requests/{request}/approve
   │  ├─ Atualiza status
   │  ├─ Envia notificação ao usuário
   │  ├─ Se aprovado: adiciona user ao grupo
   │  └─ Log de auditoria
   │
5. USUÁRIO RECEBE NOTIFICAÇÃO
   │
   └─ Pode acessar /user/scales se membro de grupo com escala
```

---

## 📧 Sistema de Email

### Tipos de Email

1. **Verificação de Email**
   - Enviado no registro
   - Link com token seguro
   - Template: `emails/verify-email.blade.php`

2. **Reset de Senha**
   - Enviado quando solicita reset
   - Link temporário
   - Template: `emails/reset-password.blade.php`

3. **Verificação por Código**
   - Código de 6 dígitos
   - Suporte para APIs
   - Template: `emails/verify_code.blade.php`

### Notifications Customizadas
```php
- CustomVerifyEmail extends Notification
- CustomResetPassword extends Notification
- Formatação HTML customizada
```

---

## 🗄️ Relações de Banco de Dados

### Diagrama de Relacionamentos

```
┌────────┐
│ users  │
└────┬───┘
     │ 1:N
     ├──> news (user_id)
     ├──> group_requests (user_id)
     ├──> notifications (user_id)
     ├──> audit_logs (user_id)
     └──> groups (coordinator_id)
     
┌────────┐
│ groups │
└────┬───┘
     │ 1:N
     ├──> users (parish_group_id)
     ├──> group_requests (group_id)
     ├──> news (parish_group_id)
     ├──> schedules (group_id)
     ├──> scales (group_id)
     └──> events (group_id)
     
┌──────────────────┐
│ group_requests   │
└────┬─────────────┘
     │ N:1
     ├──> users
     └──> groups
     
┌─────────────────┐
│ schedules       │
└────┬────────────┘
     │ 1:N
     ├──> groups
     └──> scales (schedule_id)
```

---

## 🚀 Performance

### Otimizações Implementadas

1. **Database**
   - Índices nas foreign keys
   - Indexes em campos frequentes
   - Query eager loading com select específico

2. **Frontend**
   - Vite com code splitting
   - CSS minificado
   - Lazy loading de imagens (possível)
   - Compress com gzip

3. **Caching** (possível implementar)
   - Cache de queries
   - Cache de views
   - Cache de configs

4. **Middleware**
   - Session compression
   - Throttling disponível
   - CORS customizável

---

## 🧪 Testes

### Estrutura de Testes
```
tests/
├── TestCase.php                # Base test class
├── Feature/                    # Testes de integração
│   ├── AuthTest.php
│   ├── GroupRequestTest.php
│   └── ...
└── Unit/                       # Testes unitários
    ├── UserRoleTest.php
    └── ...
```

### Configuração PHPUnit
```xml
<!-- phpunit.xml -->
<testsuites>
    <testsuite name="Feature">
        <directory suffix="Test.php">./tests/Feature</directory>
    </testsuite>
    <testsuite name="Unit">
        <directory suffix="Test.php">./tests/Unit</directory>
    </testsuite>
</testsuites>
```

### Comandos
```bash
php artisan test               # Rodar todos os testes
php artisan test --filter=Auth # Testes específicos
```

---

## 📝 Logging

### Tipos de Logs

1. **Application Logs** (storage/logs/laravel.log)
   ```php
   Log::info('User logged in', ['user_id' => $userId]);
   Log::error('Database error', ['error' => $exception]);
   Log::warning('Suspicious activity', ['ip' => $ip]);
   ```

2. **Audit Logs** (tabela audit_logs)
   ```
   - Todas operações de admin
   - CRUD de grupos, notícias, etc.
   - Mudanças de roles de usuário
   - Aprovações/rejeições
   ```

3. **Email Logs**
   ```
   - Registra envio de emails
   - Falhas de entrega
   - Status de verificação
   ```

---

## 🔧 Configurações Importantes

### .env
```env
APP_NAME="Paróquia São Paulo Apóstolo"
APP_ENV=development
APP_DEBUG=true
APP_URL=http://192.168.18.71:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=paroquia_sistema
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS="sistema@paroquia.com.br"
MAIL_FROM_NAME="Paróquia São Paulo Apóstolo"

SESSION_LIFETIME=120
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

### Timezone
```php
'timezone' => 'America/Sao_Paulo'
```

### Locale
```php
'locale' => 'pt_BR'
```

---

## 🎯 Pontos de Extensão

### 1. Adicionar Novo Modelo
```bash
php artisan make:model NomeModelo -m
# -m cria migration
```

### 2. Adicionar Novo Controlador
```bash
php artisan make:controller Admin/NovoController
```

### 3. Adicionar Nova Rota
```php
Route::resource('resource', ResourceController);
```

### 4. Adicionar Novo Email
```bash
php artisan make:mail NovoEmail
```

### 5. Adicionar Novo Comando Artisan
```bash
php artisan make:command NomeComando
```

---

## 📦 Deployment

### Checklist Pre-Deployment
- [ ] Definir `APP_DEBUG=false`
- [ ] Definir `APP_ENV=production`
- [ ] Gerar chaves HTTPS
- [ ] Configurar CORS
- [ ] Backup do banco de dados
- [ ] Testar todas as rotas
- [ ] Configurar email SMTP
- [ ] Setup de logs
- [ ] Implementar rate limiting
- [ ] Cache de assets

### Servidor Recomendado
- PHP 8.2+
- MySQL 8.0+
- Node.js 18+
- 2GB RAM mínimo
- 20GB disco

---

**Análise concluída em: 5 de dezembro de 2025**

