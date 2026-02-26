# 📋 Análise Completa do Projeto - Paróquia São Paulo Apóstolo

## 📊 Visão Geral do Projeto

**Nome:** Sistema da Paróquia São Paulo Apóstolo  
**Tipo:** Aplicação Web Full Stack  
**Framework:** Laravel 11 + Vite  
**Banco de Dados:** MySQL  
**Status:** Em Desenvolvimento/Produção  
**Público-alvo:** Paróquia São Paulo Apóstolo, Diocese de Umuarama

---

## 🏗️ Arquitetura do Projeto

### Stack Tecnológico

#### Backend
- **Framework:** Laravel 12.35.1
- **PHP:** v8.2.12
- **Banco de Dados:** MySQL via XAMPP
- **ORM:** Eloquent
- **Autenticação:** Laravel Breeze (personalisada)
- **Validação:** Laravel Validator

#### Frontend
- **Build Tool:** Vite v7.1.12
- **CSS:** Tailwind CSS v3.1.0 + Custom CSS
- **JavaScript:** Alpine.js v3.4.2, Axios v1.11.0
- **UI Components:** Bootstrap 5, Bootstrap Icons
- **Templates:** Blade (Laravel)
- **Tipografia:** 
  - Playfair Display (títulos)
  - Poppins (corpo)

#### DevOps
- **Node.js:** v22.16.0
- **NPM:** v10.9.2
- **Composer:** PHP Package Manager
- **Git:** Versionamento

---

## 📁 Estrutura de Diretórios

```
paroquia-sistema/
├── app/
│   ├── Console/Commands/          # Comandos Artisan customizados
│   ├── Enums/
│   │   └── UserRole.php           # Enum com 5 papéis de usuário
│   ├── Helpers/
│   │   └── DashboardHelper.php    # Lógica de roteamento por role
│   ├── Http/
│   │   ├── Controllers/           # 25+ controladores
│   │   │   ├── Admin/             # AdminGlobalController, AdministrativeController, etc.
│   │   │   ├── Auth/              # 8+ controladores de autenticação
│   │   │   └── ...
│   │   ├── Middleware/            # Middlewares customizados
│   │   └── Requests/              # Form Requests/Validações
│   ├── Mail/
│   │   └── VerifyEmailCode.php
│   ├── Models/                    # 13 modelos Eloquent
│   │   ├── User.php              # Usuário (com roles)
│   │   ├── News.php              # Notícias
│   │   ├── Event.php             # Eventos
│   │   ├── Group.php             # Grupos/Pastorais
│   │   ├── GroupRequest.php      # Solicitações de grupos
│   │   ├── Mass.php              # Missas
│   │   ├── Schedule.php          # Escalas
│   │   ├── Notification.php      # Notificações no sistema
│   │   ├── Chapel.php            # Capelas
│   │   ├── Clergy.php            # Clero
│   │   ├── Scale.php             # Escalas de ministério
│   │   ├── AuditLog.php          # Log de auditorias
│   │   └── EmailVerification.php # Verificação de email
│   ├── Notifications/             # Notificações por email
│   │   ├── CustomVerifyEmail.php
│   │   └── CustomResetPassword.php
│   ├── Providers/
│   │   └── AppServiceProvider.php
│   └── Services/                  # Serviços/Lógica de negócio
│       ├── EmailVerificationService.php
│       └── NotificationService.php
├── bootstrap/
│   ├── app.php                    # Inicialização da aplicação
│   └── providers.php
├── config/                        # Configurações
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── mail.php
│   ├── session.php
│   └── ...
├── database/
│   ├── factories/
│   │   └── UserFactory.php
│   ├── migrations/                # 26+ migrações
│   │   ├── *_create_users_table.php
│   │   ├── *_create_news_table.php
│   │   ├── *_create_groups_table.php
│   │   ├── *_create_events_table.php
│   │   ├── *_create_masses_table.php
│   │   ├── *_create_scales_table.php
│   │   ├── *_create_schedules_table.php
│   │   ├── *_create_group_requests_table.php
│   │   ├── *_create_notifications_table.php
│   │   ├── *_create_audit_logs_table.php
│   │   └── ...
│   └── seeders/
│       └── ChapelsSeeder.php
├── public/
│   ├── index.php                  # Entrada da aplicação
│   ├── storage/                   # Arquivos públicos
│   ├── css/                       # CSS compilado
│   ├── js/                        # JS compilado
│   ├── images/                    # Imagens estáticas
│   └── build/                     # Assets do Vite
├── resources/
│   ├── css/
│   │   └── app.css               # Stylesheet principal (2296 linhas)
│   ├── js/
│   │   └── app.js
│   └── views/                     # 100+ views Blade
│       ├── layouts/
│       ├── components/
│       ├── auth/
│       ├── admin/
│       ├── home.blade.php
│       ├── groups.blade.php
│       ├── masses.blade.php
│       ├── events.blade.php
│       ├── news.blade.php
│       └── ...
├── routes/
│   ├── web.php                   # Rotas públicas e protegidas (296 linhas)
│   ├── auth.php                  # Rotas de autenticação
│   └── console.php
├── storage/
│   ├── app/                      # Armazenamento de arquivos
│   ├── framework/
│   └── logs/
├── tests/
│   ├── Feature/
│   └── Unit/
├── vendor/                        # Dependências do Composer
├── .env                          # Arquivo de configuração
├── .env.example                  # Exemplo de configuração
├── artisan                       # CLI do Laravel
├── package.json                  # Dependências npm
├── composer.json                 # Dependências PHP
├── vite.config.js               # Configuração do Vite
├── tailwind.config.js           # Configuração do Tailwind
├── phpunit.xml                  # Configuração de testes
├── phpstan.neon                 # Análise estática de código
└── README.md                    # Documentação
```

---

## 👥 Sistema de Papéis e Permissões (UserRole Enum)

### 5 Níveis de Acesso

```php
enum UserRole: string {
    ADMIN_GLOBAL           = 'admin_global'
    ADMINISTRATIVO         = 'administrativo'
    COORDENADOR_PASTORAL   = 'coordenador_de_pastoral'
    USUARIO_PADRAO         = 'usuario_padrao'
    VISITANTE              = 'visitante'
}
```

### Permissões por Papel

| Funcionalidade | Admin Global | Administrativo | Coordenador | Usuário Padrão | Visitante |
|---|---|---|---|---|---|
| **Gerenciar Usuários** | ✅ | ❌ | ❌ | ❌ | ❌ |
| **Gerenciar Missas** | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Criar Notícias** | ✅ | ✅ | ✅ | ❌ | ❌ |
| **Gerenciar Grupos** | ✅ | ❌ | ✅ (próprio) | ❌ | ❌ |
| **Gerenciar Escalas** | ✅ | ❌ | ✅ | ❌ | ❌ |
| **Aprovar Solicitações** | ✅ | ✅ | ✅ (próprio) | ❌ | ❌ |
| **Deletar Grupos** | ✅ | ❌ | ❌ | ❌ | ❌ |
| **Visualizar Notícias** | ✅ | ✅ | ✅ | ✅ | ✅ |
| **Solicitar Grupo** | ✅ | ✅ | ✅ | ✅ | ❌ |

---

## 🗄️ Banco de Dados

### Tabelas Principais

#### 1. **users**
Armazena dados dos usuários com sistema de roles

```
- id (PK)
- name, email, password
- role (enum)
- phone, phone_verified_at
- birth_date, address
- parish_group_id (FK)
- email_notifications_enabled
- profile_photo_path
- email_verified_at
- timestamps
```

#### 2. **news**
Notícias da paróquia

```
- id, title, excerpt, content
- image, featured_image
- status (published/draft)
- featured (boolean)
- user_id (FK), parish_group_id (FK)
- published_at
```

#### 3. **groups**
Pastorais e grupos

```
- id, name, description, category
- coordinator_name, coordinator_phone, coordinator_email
- meeting_info, image
- is_active, requires_scale
- max_members
- coordinator_id, created_by
```

#### 4. **events**
Eventos da paróquia

```
- id, title, description
- date, time, location
- category, status
- image, capacity
- user_id
```

#### 5. **masses**
Horários de missa

```
- id, day_of_week
- time, capacity
- chapel_id, clergy_id
```

#### 6. **group_requests**
Solicitações de entrada em grupos

```
- id, user_id, group_id
- status (pending/approved/rejected/in_formation)
- coordinator_response
- created_at, updated_at
```

#### 7. **schedules**
Escalas de ministério

```
- id, group_id, title
- description, file_path
- start_date, end_date
- is_active
```

#### 8. **scales**
Escalas detalhadas para grupos com escala

```
- id, group_id, schedule_id
- week_number, month, year
- data (JSON com nomes dos escalados)
- published_at
```

#### 9. **notifications**
Notificações internas

```
- id, user_id
- type, title, message
- data (JSON)
- read_at
```

#### 10. **audit_logs**
Log de auditorias de sistema

```
- id, user_id
- action, model_type, model_id
- changes (JSON)
- timestamp
```

#### 11. **email_verifications**
Verificação de email com código

```
- id, email
- code
- expires_at, verified_at
```

Outras tabelas: `chapels`, `clergy`, `donation_records`, `jobs`, `cache`

---

## 🛣️ Rotas Principais

### Rotas Públicas
```
GET  / → HomeController@index (página inicial)
GET  /groups → HomeController@groups (pastorais)
GET  /masses → HomeController@masses (horários)
GET  /events → HomeController@events (eventos)
GET  /events/{event} → HomeController@showEvent
GET  /news → HomeController@news
GET  /news/{news} → HomeController@showNews
GET  /sobre → HomeController@about
```

### Rotas Autenticadas
```
POST /group-requests → GroupRequestController@store (solicitar grupo)
GET  /minhas-solicitacoes → GroupRequestController@myRequests
GET  /notifications → NotificationsController@index
GET  /profile → ProfileController@edit
```

### Admin Global (admin_global)
```
/admin/dashboard
/admin/users → Gerenciar usuários
/admin/stats → Estatísticas
/admin/news/* → CRUD de notícias
/admin/events/* → CRUD de eventos
/admin/groups/* → CRUD de grupos
/admin/masses/* → CRUD de missas
/admin/scales/* → Gerenciar escalas
```

### Admin Administrativo (administrativo)
```
/admin/administrativo/dashboard
/admin/administrativo/news/* → Criar/editar notícias
/admin/administrativo/events/* → Criar/editar eventos
/admin/administrativo/group-requests → Aprovar solicitações
```

### Coordenador (coordenador_de_pastoral)
```
/admin/coordenador/dashboard
/admin/coordenador/group/{group} → Gerenciar grupo
/admin/coordenador/schedules/* → Gerenciar escalas
/admin/coordenador/members → Membros do grupo
```

### Usuário Padrão (usuario_padrao)
```
/user/dashboard
/user/scales → Visualizar escalas
/user/scales/{scale}/download
```

---

## 🎨 Design e Estilos

### Paleta de Cores
```css
--brand-vinho: #8B1E3F          (Vermelho principal)
--brand-vinho-dark: #6E1530     (Vermelho escuro)
--brand-rose: #F4E9E1           (Rosa claro)
--accent-dourado: #FFD66B       (Dourado)
--text-primary: #2C2C2C         (Texto)
--bg-light: #FBF7F6             (Fundo claro)
```

### Tipografia
- **Títulos:** Playfair Display (serif elegante)
- **Corpo:** Poppins (sans-serif moderno)
- **Icons:** Bootstrap Icons

### Responsividade
- Layout adaptável para desktop, tablet e mobile
- Menu hamburger em dispositivos móveis
- Cards responsivos com grid flexível
- Componentes Tailwind CSS nativamente responsivos

### CSS Principal
- **app.css:** 2296 linhas
- Variáveis CSS modernas
- Sistema de sombras
- Transições suaves
- Componentes reutilizáveis

---

## 🔧 Serviços e Lógica de Negócio

### NotificationService
```php
- notifyUser() → Notifica um usuário
- notifyUsers() → Notifica múltiplos usuários
- groupRequestStatusChanged() → Notifica mudança de status
- scalePublished() → Notifica escala publicada
```

### EmailVerificationService
```
- Serviço de verificação de email com código
- Suporta múltiplas tentativas
- Código com expiração
```

### DashboardHelper
```php
- getDashboardRoute($userRole) → Rota correta por papel
- getUserDashboardRoute() → Rota para usuário atual
- getUserAreaLabel() → Label customizado por papel
```

---

## 🔐 Autenticação e Segurança

### Sistema de Autenticação
- Laravel Breeze (personalizado)
- Verificação de email obrigatória
- Password reset com token seguro
- Notificações customizadas

### Middleware Customizado
- `admin.area` → Valida acesso por role
- `verified` → Exige email verificado
- Proteção CSRF padrão do Laravel

### Validações
- Form Requests customizados
- Regras de validação por modelo
- Tratamento de erros amigável

---

## 📱 Responsividade e Mobile

✅ **Suportado completamente:**
- Menu hambúrguer responsivo
- Layout flexível com Tailwind CSS
- Componentes adaptáveis para touch
- Imagens otimizadas
- Tipografia legível em dispositivos pequenos
- Viewport meta tag configurada

**Acesso via rede local:**
```
http://192.168.18.71:8000
```

---

## 🧪 Testes e Qualidade

### Arquivos de Configuração
- `phpunit.xml` → Testes unitários
- `phpstan.neon` → Análise estática PHP
- Diretório `tests/` com Feature e Unit tests

### Padrões de Código
- PSR-4 autoload
- Laravel coding standards
- Type hints completos
- DocBlocks em classes importantes

---

## 📊 Funcionalidades Principais

### 🏠 Site Público
1. **Página Inicial** - Informações e destaques
2. **Horários de Missa** - Organizado por dia
3. **Pastorais/Grupos** - Descrição e coordenadores
4. **Eventos** - Calendário e detalhes
5. **Notícias** - Sistema de modal
6. **Contato** - Informações gerais

### 👨‍💼 Dashboard Administrativo
1. **Gestão de Usuários** - CRUD com roles
2. **Gerenciamento de Conteúdo** - Notícias, eventos, missas
3. **Sistema de Escalas** - Para ministérios
4. **Solicitações de Grupos** - Com aprovação
5. **Logs de Auditoria** - Rastreabilidade
6. **Estatísticas** - Dashboard visual

### 👥 Gestão de Grupos
1. **Criar/Editar Grupos** - Admin Global
2. **Solicitar Grupos** - Usuários
3. **Aprovar Solicitações** - Coordenador
4. **Gerenciar Membros** - Coordenador
5. **Escalas de Ministério** - Coordenador
6. **Formação de Membros** - Status em formação

---

## 🚀 Ambiente de Execução

### Servidores Rodando
1. **Laravel Server**
   - Porta: 8000
   - Local: http://localhost:8000
   - Rede: http://192.168.18.71:8000

2. **Vite Dev Server**
   - Porta: 5174
   - Local: http://localhost:5174
   - Suporte HMR para reload automático

### Dependências Instaladas
- **PHP:** 8.2.12 ✅
- **Node.js:** 22.16.0 ✅
- **NPM:** 10.9.2 ✅
- **Composer:** ✅
- **vendor/:** ✅ (instalado)
- **node_modules/:** ✅ (instalado)

### Banco de Dados
- **Sistema:** MySQL via XAMPP
- **Database:** paroquia_sistema
- **Charset:** utf8mb4_unicode_ci
- **Migrações:** 26+ criadas e prontas

---

## 📦 Dependências Principais

### PHP (Composer)
```json
{
  "laravel/framework": "^12.0",
  "laravel/tinker": "^2.10.1"
}
```

### Dev PHP
```json
{
  "fakerphp/faker": "^1.23",
  "laravel/breeze": "^2.3",
  "phpunit/phpunit": "^11.5.3",
  "nunomaduro/larastan": "^3.7"
}
```

### JavaScript
```json
{
  "@tailwindcss/forms": "^0.5.2",
  "@tailwindcss/vite": "^4.0.0",
  "alpinejs": "^3.4.2",
  "axios": "^1.11.0",
  "laravel-vite-plugin": "^2.0.0",
  "tailwindcss": "^3.1.0",
  "vite": "^7.0.7"
}
```

---

## 🎯 Pontos Fortes

✅ Arquitetura bem estruturada  
✅ Sistema de roles flexível e extensível  
✅ Banco de dados normalizado  
✅ Interface responsiva  
✅ Autenticação segura  
✅ Auditoria completa  
✅ Notificações inteligentes  
✅ Código bem documentado  
✅ Suporte mobile nativo  
✅ Build process otimizado  

---

## 📋 Possíveis Melhorias

1. **API REST** - Criar endpoints para app mobile nativa
2. **Cache** - Implementar cache para dados frequentes
3. **Fila** - Usar queue para envio de emails
4. **Search** - Implementar busca avançada
5. **Reports** - Exportar relatórios (PDF/Excel)
6. **PWA** - Tornar aplicação offline-first
7. **Analytics** - Dashboard de analytics
8. **Backup** - Sistema automatizado de backup
9. **2FA** - Autenticação de dois fatores
10. **Internationalization** - Suporte multi-idioma

---

## 📞 Próximas Etapas

1. ✅ Projeto em execução
2. ⏳ Testar funcionalidades em mobile
3. ⏳ Validar banco de dados
4. ⏳ Implementar APIs se necessário
5. ⏳ Deploy em servidor de produção

---

**Última Atualização:** 5 de dezembro de 2025  
**Status:** ✅ Sistema em Execução  
**Ambiente:** Windows 11 + XAMPP + Laravel 12

