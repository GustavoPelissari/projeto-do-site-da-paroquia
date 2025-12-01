# 🔍 SISTEMA DE IDENTIFICAÇÃO DE ERROS

## 📋 Índice
1. [Configuração do Sistema](#configuração-do-sistema)
2. [Erros Visíveis na Tela](#erros-visíveis-na-tela)
3. [Logs do Sistema](#logs-do-sistema)
4. [Validação de Formulários](#validação-de-formulários)
5. [Mensagens Flash](#mensagens-flash)
6. [Debugging em Desenvolvimento](#debugging-em-desenvolvimento)
7. [Checklist de Verificação](#checklist-de-verificação)

---

## ⚙️ Configuração do Sistema

### 📁 `.env` - Variáveis de Ambiente

```env
# DESENVOLVIMENTO (mostra erros detalhados)
APP_ENV=local
APP_DEBUG=true
LOG_LEVEL=debug

# PRODUÇÃO (esconde detalhes técnicos)
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error
```

### 🎯 Quando usar cada configuração:

**DESENVOLVIMENTO (`APP_DEBUG=true`):**
- ✅ Mostra stack trace completo na tela
- ✅ Exibe queries SQL executadas
- ✅ Mostra variáveis e estados
- ⚠️ **NUNCA use em produção!**

**PRODUÇÃO (`APP_DEBUG=false`):**
- ✅ Mostra página genérica de erro
- ✅ Protege informações sensíveis
- ✅ Erros vão apenas para logs
- ✅ Melhor experiência para usuários

---

## 👁️ Erros Visíveis na Tela

### 1️⃣ **Componente de Alerta** (`<x-alert>`)

**Localização:** `resources/views/components/alert.blade.php`

**Como aparece na tela:**

```blade
{{-- Sucesso (verde) --}}
<x-alert type="success">
    Operação realizada com sucesso!
</x-alert>

{{-- Erro (vermelho) --}}
<x-alert type="error">
    Ocorreu um erro ao processar sua solicitação.
</x-alert>

{{-- Aviso (amarelo) --}}
<x-alert type="warning">
    Atenção: Esta ação não pode ser desfeita.
</x-alert>

{{-- Informação (azul) --}}
<x-alert type="info">
    Seu perfil está completo!
</x-alert>
```

**Características:**
- ⏱️ Auto-desaparece em 4 segundos
- 📍 Posicionado no topo da página
- 🎨 Cores Bootstrap para cada tipo
- 🔔 Ícones visuais para identificação rápida

**Onde está implementado:**
- ✅ `resources/views/layouts/app.blade.php` (layout usuário)
- ✅ `resources/views/admin/layout.blade.php` (layout admin)

### 2️⃣ **Erros de Validação de Campos**

**Exemplo visual:**

```blade
<div class="mb-3">
    <label for="email" class="form-label">E-mail</label>
    <input type="email" 
           name="email" 
           class="form-control @error('email') is-invalid @enderror" 
           value="{{ old('email') }}">
    
    @error('email')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
```

**Como aparece:**
- 🔴 Borda vermelha no campo com erro
- 📝 Mensagem de erro abaixo do campo
- 🔄 Mantém valores preenchidos após erro (`old()`)

**Exemplos de mensagens:**
- "O campo e-mail é obrigatório."
- "O campo e-mail deve ser um endereço de e-mail válido."
- "A senha deve ter no mínimo 8 caracteres."
- "A imagem não pode ser maior que 2MB."

### 3️⃣ **Página de Erro 500 (Erro Interno)**

**Quando aparece:**
- Exception não tratada no código
- Erro de sintaxe PHP
- Problema de conexão com banco de dados

**Em desenvolvimento (`APP_DEBUG=true`):**
```
Whoops, looks like something went wrong.

Stack trace:
1. ErrorException: Undefined variable $user
   at app/Http/Controllers/ProfileController.php:45
   
2. ...resto do stack trace...
```

**Em produção (`APP_DEBUG=false`):**
```
500 | Erro no Servidor

Desculpe, algo deu errado.
```

### 4️⃣ **Página de Erro 404 (Não Encontrado)**

**Quando aparece:**
- URL inexistente
- Recurso deletado
- ID inválido

**Mensagem padrão:**
```
404 | Página Não Encontrada
```

### 5️⃣ **Página de Erro 403 (Acesso Negado)**

**Quando aparece:**
- Usuário sem permissão
- Tentativa de acessar área restrita

**Mensagem:**
```
403 | Acesso Negado

Você não tem permissão para acessar esta página.
```

---

## 📝 Logs do Sistema

### 📁 **Localização dos Arquivos de Log**

```
storage/logs/laravel.log
```

### 🔍 **Como Ler os Logs**

**Estrutura de uma entrada:**
```
[2025-12-01 14:30:45] local.ERROR: Erro ao processar upload 
{"user_id":5,"file":"test.pdf","exception":"InvalidArgumentException: Tipo de arquivo inválido"}
[stacktrace]
#0 app/Http/Controllers/ProfileController.php(78): Storage::put()
#1 ...
```

**Componentes:**
- 🕐 **Data/Hora:** `[2025-12-01 14:30:45]`
- 🏷️ **Ambiente:** `local` ou `production`
- ⚠️ **Nível:** `ERROR`, `WARNING`, `INFO`, `DEBUG`
- 📄 **Mensagem:** Descrição do erro
- 🔢 **Contexto:** Dados adicionais (JSON)
- 📚 **Stack Trace:** Caminho do erro

### 📊 **Níveis de Log**

| Nível | Quando Usar | Exemplo |
|-------|-------------|---------|
| **DEBUG** | Informações técnicas detalhadas | "SQL Query executada: SELECT * FROM users" |
| **INFO** | Eventos normais do sistema | "Usuário 'João' fez login" |
| **WARNING** | Situações anormais mas não críticas | "Tentativa de login com e-mail inexistente" |
| **ERROR** | Erros que impedem operação | "Falha ao enviar e-mail de verificação" |
| **CRITICAL** | Erros graves do sistema | "Banco de dados offline" |

### 🔎 **Procurar Erros Específicos**

**PowerShell:**
```powershell
# Ver últimas 50 linhas
Get-Content storage/logs/laravel.log -Tail 50

# Buscar por palavra-chave
Select-String -Path storage/logs/laravel.log -Pattern "ERROR"

# Buscar erros de hoje
Get-Content storage/logs/laravel.log | Select-String "2025-12-01.*ERROR"

# Limpar log antigo
Clear-Content storage/logs/laravel.log
```

**Exemplos do que você encontrará:**

```log
[2025-12-01 10:15:30] local.ERROR: SQLSTATE[23000]: Integrity constraint violation 
{"user_id":3,"group_id":99}

[2025-12-01 11:20:45] local.WARNING: Tentativa de upload de arquivo muito grande 
{"file_size":"5MB","max_allowed":"2MB"}

[2025-12-01 12:30:00] local.INFO: Notícia publicada com sucesso 
{"news_id":42,"author_id":1}
```

---

## ✅ Validação de Formulários

### 📋 **Form Requests - Validação Centralizada**

**Arquivos criados:**
- `app/Http/Requests/StoreNewsRequest.php`
- `app/Http/Requests/UpdateNewsRequest.php`
- `app/Http/Requests/StoreEventRequest.php`
- `app/Http/Requests/UpdateEventRequest.php`
- `app/Http/Requests/ProfileUpdateRequest.php`

**Exemplo de validação:**

```php
public function rules(): array
{
    return [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        'email' => 'required|email|unique:users,email',
        'date' => 'required|date|after:today',
    ];
}
```

**Mensagens de erro customizadas:**

```php
public function messages(): array
{
    return [
        'title.required' => 'O título é obrigatório.',
        'image.max' => 'A imagem não pode ser maior que 2MB.',
        'email.unique' => 'Este e-mail já está cadastrado.',
    ];
}
```

### 🎯 **Regras de Validação Mais Usadas**

| Regra | Descrição | Exemplo |
|-------|-----------|---------|
| `required` | Campo obrigatório | `'name' => 'required'` |
| `email` | Deve ser e-mail válido | `'email' => 'email'` |
| `min:X` | Mínimo X caracteres | `'password' => 'min:8'` |
| `max:X` | Máximo X caracteres/KB | `'title' => 'max:255'` |
| `image` | Deve ser imagem | `'photo' => 'image'` |
| `mimes:jpg,png` | Tipos permitidos | `'image' => 'mimes:jpeg,png'` |
| `unique:table,column` | Valor único no banco | `'email' => 'unique:users'` |
| `date` | Deve ser data válida | `'birth_date' => 'date'` |
| `after:date` | Data posterior a | `'event_date' => 'after:today'` |
| `exists:table,column` | Valor deve existir | `'group_id' => 'exists:groups,id'` |

### 📱 **Exibindo Erros de Validação**

**Erro geral (todos os erros juntos):**
```blade
@if($errors->any())
    <x-alert type="error">
        <strong>Verifique os erros abaixo:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-alert>
@endif
```

**Erro específico por campo:**
```blade
<input type="text" 
       name="name" 
       class="form-control @error('name') is-invalid @enderror">

@error('name')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
```

---

## 💬 Mensagens Flash

### 🔄 **Como Funcionam**

**No Controller (enviando mensagem):**
```php
// Sucesso
return redirect()->route('dashboard')
    ->with('success', 'Perfil atualizado com sucesso!');

// Erro
return redirect()->back()
    ->with('error', 'Você não tem permissão para esta ação.');

// Aviso
return redirect()->route('groups.index')
    ->with('warning', 'Esta operação não pode ser desfeita!');

// Info
return redirect()->route('profile.edit')
    ->with('info', 'Complete seu perfil para continuar.');
```

**Na View (exibindo mensagem):**
```blade
@if(session('success'))
    <x-alert type="success">
        {{ session('success') }}
    </x-alert>
@endif

@if(session('error'))
    <x-alert type="error">
        {{ session('error') }}
    </x-alert>
@endif
```

### 📍 **Onde Estão Implementadas**

**Layout Principal (`resources/views/layouts/app.blade.php`):**
```blade
@if(session('success'))
    <x-alert type="success">{{ session('success') }}</x-alert>
@endif

@if(session('error'))
    <x-alert type="error">{{ session('error') }}</x-alert>
@endif

@if(session('warning'))
    <x-alert type="warning">{{ session('warning') }}</x-alert>
@endif

@if(session('info'))
    <x-alert type="info">{{ session('info') }}</x-alert>
@endif
```

**Layout Admin (`resources/views/admin/layout.blade.php`):**
```blade
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
```

### 📊 **Exemplos de Mensagens Implementadas**

**AdminGlobalController:**
```php
// Sucesso ao criar
->with('success', 'Notícia criada com sucesso!')

// Sucesso ao atualizar
->with('success', 'Grupo atualizado com sucesso!')

// Sucesso ao excluir
->with('success', "Usuário '{$userName}' excluído com sucesso!")

// Erro de permissão
->with('error', 'Você não pode excluir sua própria conta.')
```

**GroupRequestController:**
```php
// Erro - já faz parte de grupo
->with('error', 'Você já faz parte de um grupo: '.$user->parishGroup->name)

// Erro - solicitação duplicada
->with('error', 'Você já possui uma solicitação pendente para este grupo.')

// Sucesso - solicitação enviada
->with('success', "Solicitação enviada para {$group->name}! Aguarde a aprovação.")
```

---

## 🛠️ Debugging em Desenvolvimento

### 1️⃣ **Laravel Debugbar** (Opcional - Recomendado)

**Instalação:**
```bash
composer require barryvdh/laravel-debugbar --dev
```

**O que mostra:**
- 📊 Queries SQL executadas
- ⏱️ Tempo de carregamento
- 💾 Uso de memória
- 🔍 Variáveis de sessão
- 📧 E-mails enviados
- 🚦 Rotas e middlewares

### 2️⃣ **dd() e dump() - Debug Helpers**

```php
// Para e mostra a variável (Die and Dump)
dd($user);

// Mostra mas continua execução
dump($user);

// Dump múltiplas variáveis
dd($user, $group, $request->all());
```

### 3️⃣ **Log Manual para Debug**

```php
use Illuminate\Support\Facades\Log;

// Debug detalhado
Log::debug('Valor da variável', ['user_id' => $user->id]);

// Info
Log::info('Usuário fez login', ['email' => $user->email]);

// Warning
Log::warning('Tentativa de acesso não autorizado', [
    'user_id' => auth()->id(),
    'attempted_route' => request()->path()
]);

// Error
Log::error('Falha ao processar pagamento', [
    'exception' => $e->getMessage(),
    'user_id' => $user->id
]);
```

### 4️⃣ **Tinker - Console Interativo**

```bash
php artisan tinker
```

```php
// Testar queries
>>> User::find(1)
>>> User::where('role', 'admin_global')->get()

// Testar relacionamentos
>>> $user = User::find(1)
>>> $user->parishGroup

// Testar serviços
>>> Mail::to('test@test.com')->send(new WelcomeEmail())
```

---

## ✅ Checklist de Verificação de Erros

### 🔍 **Quando algo não funciona:**

#### 1. **Verificar Logs**
```powershell
# Ver últimas linhas do log
Get-Content storage/logs/laravel.log -Tail 100

# Buscar erros recentes
Select-String -Path storage/logs/laravel.log -Pattern "ERROR" | Select-Object -Last 20
```

#### 2. **Verificar Configuração**
```bash
# Ver configuração atual
php artisan config:show app
php artisan config:show database

# Limpar cache de configuração
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

#### 3. **Verificar Permissões de Arquivos**
```powershell
# Windows - dar permissões para storage e bootstrap/cache
icacls storage /grant Users:F /T
icacls bootstrap/cache /grant Users:F /T
```

#### 4. **Verificar Banco de Dados**
```bash
# Testar conexão
php artisan db:show

# Ver migrações pendentes
php artisan migrate:status
```

#### 5. **Verificar Rotas**
```bash
# Listar todas as rotas
php artisan route:list

# Buscar rota específica
php artisan route:list --name=profile
```

#### 6. **Verificar Variáveis de Ambiente**
```powershell
# Ver .env carregado
Get-Content .env

# Verificar se APP_KEY existe
php artisan key:generate
```

---

## 🎯 Cenários Comuns de Erros

### ❌ **Erro: "Class not found"**

**Causa:** Autoload não atualizado

**Solução:**
```bash
composer dump-autoload
php artisan clear-compiled
```

---

### ❌ **Erro: "No application encryption key has been specified"**

**Causa:** APP_KEY não definida no .env

**Solução:**
```bash
php artisan key:generate
```

---

### ❌ **Erro: "419 | Page Expired"**

**Causa:** Token CSRF expirado

**Solução:**
```blade
<!-- Garantir que formulários têm @csrf -->
<form method="POST">
    @csrf
    ...
</form>
```

---

### ❌ **Erro: "500 | Server Error" sem detalhes**

**Causa:** APP_DEBUG=false esconde erro

**Solução (APENAS EM DEV):**
```env
# .env
APP_DEBUG=true
```

Depois olhar o stack trace completo na tela.

---

### ❌ **Erro: Arquivo de upload muito grande**

**Causa:** Limites do PHP/Laravel

**Solução:**
```ini
; php.ini
upload_max_filesize = 10M
post_max_size = 10M
```

```env
# .env - se usar validação
MAX_UPLOAD_SIZE=2048
```

---

### ❌ **Erro: "SQLSTATE[HY000] [1045] Access denied"**

**Causa:** Credenciais de banco incorretas

**Solução:**
```env
# .env
DB_CONNECTION=sqlite
# OU para MySQL
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seu_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

---

## 📚 Recursos Adicionais

### 📖 **Documentação Oficial**
- [Laravel Errors & Logging](https://laravel.com/docs/errors)
- [Laravel Validation](https://laravel.com/docs/validation)
- [Laravel Debugging](https://laravel.com/docs/debugging)

### 🔧 **Ferramentas Úteis**
- [Laravel Telescope](https://laravel.com/docs/telescope) - Debugging avançado
- [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar) - Toolbar de debug
- [Ray](https://myray.app/) - Debug profissional

### 📊 **Monitoramento em Produção**
- [Sentry](https://sentry.io/) - Rastreamento de erros
- [Bugsnag](https://www.bugsnag.com/) - Monitoramento de aplicações
- [Rollbar](https://rollbar.com/) - Error tracking

---

## 🎓 Resumo Rápido

### ✅ **Para Ver Erros na Tela:**
1. `.env`: `APP_DEBUG=true` (apenas desenvolvimento)
2. Componente `<x-alert>` exibe mensagens flash
3. `@error('campo')` exibe erros de validação
4. Páginas de erro 404, 403, 500

### ✅ **Para Ver Erros em Logs:**
1. Arquivo: `storage/logs/laravel.log`
2. Comando: `Get-Content storage/logs/laravel.log -Tail 50`
3. Níveis: DEBUG, INFO, WARNING, ERROR, CRITICAL

### ✅ **Para Validar Dados:**
1. Form Requests em `app/Http/Requests/`
2. Regras: `required`, `email`, `image`, `max`, etc
3. Mensagens customizadas por campo

### ✅ **Para Mensagens ao Usuário:**
1. Controller: `->with('success', 'Mensagem')`
2. View: `session('success')`
3. Componente: `<x-alert type="success">`

---

**Última atualização:** 01/12/2025
