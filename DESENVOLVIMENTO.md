# 🚀 Guia de Desenvolvimento e Expansão

## 📚 Índice
1. [Setup de Desenvolvimento](#setup-de-desenvolvimento)
2. [Arquitetura de Pastas](#arquitetura-de-pastas)
3. [Criando Novos Recursos](#criando-novos-recursos)
4. [Padrões de Código](#padrões-de-código)
5. [Banco de Dados](#banco-de-dados)
6. [Debugging](#debugging)
7. [Deploy](#deploy)

---

## 🔧 Setup de Desenvolvimento

### Ambiente Local (XAMPP)
```bash
# 1. Iniciar XAMPP Control Panel
# 2. Ativar Apache
# 3. Ativar MySQL

# 4. Criar banco de dados
# Abrir: http://localhost/phpmyadmin
# Criar database: paroquia_sistema

# 5. Configurar .env
cp .env.example .env
php artisan key:generate

# 6. Instalar dependências
composer install
npm install

# 7. Executar migrações
php artisan migrate

# 8. Executar seeders (opcional)
php artisan db:seed

# 9. Iniciar servidores
php artisan serve --host 0.0.0.0 --port 8000
npm run dev

# Acesso
# Local: http://localhost:8000
# Rede: http://192.168.18.71:8000
```

### Estrutura do .env
```env
APP_NAME="Paróquia São Paulo Apóstolo"
APP_ENV=local
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
MAIL_USERNAME=xxx
MAIL_PASSWORD=xxx
MAIL_FROM_ADDRESS="noreply@paroquia.com.br"

SESSION_LIFETIME=120
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

---

## 📁 Arquitetura de Pastas

### Convenção de Nomes
```
- Controllers: CamelCase (UserController)
- Models: CamelCase singular (User)
- Migrations: snake_case com timestamp (2024_12_05_000000_create_users_table.php)
- Views: snake-case (user-profile.blade.php)
- Routes: prefixo + resource (users.index, users.store)
- Methods: camelCase (getUserData)
```

### Padrão de Nomear Rotas
```php
// Resource completo
Route::resource('posts', PostController::class);
// Gera:
// posts.index, posts.create, posts.store
// posts.show, posts.edit, posts.update, posts.destroy

// Custom routes
Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    // Acessa com: route('admin.dashboard')
});
```

---

## ✨ Criando Novos Recursos

### Exemplo 1: Adicionar Novo Modelo (Doações)

#### 1. Gerar Estrutura
```bash
# Cria Model, Migration, Factory, Seeder, Controller
php artisan make:model Donation -msfc

# -m = migration
# -s = seeder
# -f = factory
# -c = controller (resource)
```

#### 2. Definir Migração (database/migrations/xxx_create_donations_table.php)
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->decimal('amount', 10, 2);
            $table->string('type'); // cash, check, transfer
            $table->text('note')->nullable();
            $table->timestamp('donated_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
```

#### 3. Definir Modelo (app/Models/Donation.php)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'note',
        'donated_at',
    ];

    protected function casts(): array
    {
        return [
            'donated_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('donated_at', 'desc');
    }

    // Helpers
    public function getFormattedAmount()
    {
        return 'R$ ' . number_format($this->amount, 2, ',', '.');
    }
}
```

#### 4. Definir Controlador (app/Http/Controllers/Admin/DonationController.php)
```php
<?php

namespace App\Http\Controllers\Admin;

use App\Models\Donation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::recent()->paginate(15);
        return view('admin.donations.index', compact('donations'));
    }

    public function create()
    {
        return view('admin.donations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:cash,check,transfer',
            'note' => 'nullable|string|max:500',
            'donated_at' => 'required|date',
        ]);

        Donation::create($validated);

        return redirect()->route('admin.donations.index')
                       ->with('success', 'Doação registrada com sucesso!');
    }

    public function show(Donation $donation)
    {
        return view('admin.donations.show', compact('donation'));
    }

    public function edit(Donation $donation)
    {
        return view('admin.donations.edit', compact('donation'));
    }

    public function update(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:cash,check,transfer',
            'note' => 'nullable|string|max:500',
            'donated_at' => 'required|date',
        ]);

        $donation->update($validated);

        return redirect()->route('admin.donations.show', $donation)
                       ->with('success', 'Doação atualizada com sucesso!');
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();

        return redirect()->route('admin.donations.index')
                       ->with('success', 'Doação removida com sucesso!');
    }
}
```

#### 5. Adicionar Rotas (routes/web.php)
```php
// Dentro de Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin.area:admin_global'])->group(...)
Route::resource('donations', DonationController::class);
```

#### 6. Criar Views
```
resources/views/admin/donations/
├── index.blade.php      # Listagem
├── create.blade.php     # Criar
├── edit.blade.php       # Editar
└── show.blade.php       # Detalhes
```

#### 7. Executar Migrações
```bash
php artisan migrate
```

---

### Exemplo 2: Adicionar Nova Notificação

#### 1. Gerar Notificação
```bash
php artisan make:notification DonationReceived
```

#### 2. Definir Notificação (app/Notifications/DonationReceived.php)
```php
<?php

namespace App\Notifications;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DonationReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private Donation $donation)
    {
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Doação Recebida')
            ->markdown('emails.donation-received', [
                'donation' => $this->donation,
                'user' => $notifiable,
            ]);
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'donation_received',
            'title' => 'Nova Doação Recebida',
            'message' => "Doação de {$this->donation->getFormattedAmount()} registrada",
            'donation_id' => $this->donation->id,
        ];
    }
}
```

#### 3. Disparar Notificação
```php
// Em DonationController@store
use App\Notifications\DonationReceived;

Donation::create($validated);
$admin = User::where('role', 'admin_global')->first();
$admin->notify(new DonationReceived($donation));
```

---

## 🎯 Padrões de Código

### 1. Controllers
```php
<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    // Listar
    public function index()
    {
        $resources = Resource::paginate(15);
        return view('resources.index', compact('resources'));
    }

    // Formulário criar
    public function create()
    {
        return view('resources.create');
    }

    // Guardar
    public function store(Request $request)
    {
        $validated = $request->validate([
            'field' => 'required|string|max:255',
        ]);

        Resource::create($validated);

        return redirect()->route('resources.index')
                       ->with('success', 'Criado com sucesso!');
    }

    // Mostrar
    public function show(Resource $resource)
    {
        return view('resources.show', compact('resource'));
    }

    // Formulário editar
    public function edit(Resource $resource)
    {
        return view('resources.edit', compact('resource'));
    }

    // Atualizar
    public function update(Request $request, Resource $resource)
    {
        $validated = $request->validate([
            'field' => 'required|string|max:255',
        ]);

        $resource->update($validated);

        return redirect()->route('resources.show', $resource)
                       ->with('success', 'Atualizado com sucesso!');
    }

    // Deletar
    public function destroy(Resource $resource)
    {
        $resource->delete();

        return redirect()->route('resources.index')
                       ->with('success', 'Deletado com sucesso!');
    }
}
```

### 2. Models
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    // Relationships
    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Helpers
    public function isOwner(User $user): bool
    {
        return $this->owner_id === $user->id;
    }
}
```

### 3. Views (Blade)
```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $title ?? 'Title' }}</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Conteúdo -->
        </div>
    </div>
</div>
@endsection
```

---

## 🗄️ Banco de Dados

### Criar Migração
```bash
# Criar tabela
php artisan make:migration create_resources_table

# Adicionar coluna
php artisan make:migration add_field_to_resources_table

# Remover coluna
php artisan make:migration drop_field_from_resources_table
```

### Estrutura de Migração
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
            $table->softDeletes(); // Para delete lógico
            
            // Índices
            $table->index('user_id');
            $table->index('active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
```

### Rollback
```bash
# Último batch
php artisan migrate:rollback

# Todos
php artisan migrate:reset

# Refrescar (reset + migrate)
php artisan migrate:refresh

# Refrescar + seed
php artisan migrate:refresh --seed
```

---

## 🐛 Debugging

### Logging
```php
use Illuminate\Support\Facades\Log;

Log::info('Informação', ['user' => $user->id]);
Log::error('Erro', ['exception' => $e->getMessage()]);
Log::debug('Debug', ['data' => $data]);

// Ver logs
tail -f storage/logs/laravel.log
```

### Dump & Die
```php
dd($variable);        // Dump and die
dump($variable);      // Apenas dump
var_dump($variable);  // PHP var_dump
```

### PHP Artisan Tinker
```bash
php artisan tinker

# Dentro do tinker:
>>> $user = User::find(1);
>>> $user->email;
>>> exit
```

### Laravel Debugbar (se instalado)
```bash
composer require barryvdh/laravel-debugbar --dev

# Aparece no rodapé da página em desenvolvimento
```

---

## 📦 Dependências

### Instalar Novo Pacote
```bash
# PHP
composer require vendor/package
composer require vendor/package --dev

# Node.js
npm install package-name
npm install package-name --save-dev
```

### Atualizar Dependências
```bash
# PHP
composer update

# Node.js
npm update
```

### Lock Files
```
composer.lock    # Versões exatas de dependências PHP
package-lock.json # Versões exatas de dependências Node.js
```

---

## 🧪 Testes

### Criar Teste
```bash
php artisan make:test UserTest
php artisan make:test Feature/AuthTest
php artisan make:test Unit/DonationTest
```

### Executar Testes
```bash
# Todos
php artisan test

# Específico
php artisan test tests/Feature/AuthTest.php

# Com filtering
php artisan test --filter=login
```

### Exemplo de Teste
```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_credentials()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong',
        ]);

        $response->assertSessionHasErrors();
    }
}
```

---

## 🚀 Deploy

### Checklist Pre-Deploy

```
[ ] APP_DEBUG=false
[ ] APP_ENV=production
[ ] Database backup
[ ] SSL certificate
[ ] Email SMTP configurado
[ ] Storage link criado
[ ] Permissions corretos (755 para pastas, 644 para arquivos)
[ ] .env production
[ ] Cache limpo
[ ] Composer install --no-dev
[ ] npm run build
[ ] php artisan migrate
[ ] php artisan cache:clear
[ ] php artisan config:cache
```

### Comandos de Deploy
```bash
# 1. Atualizar código (git pull)
git pull origin main

# 2. Instalar dependências
composer install --no-dev --optimize-autoloader
npm ci
npm run build

# 3. Configurar ambiente
cp .env.example .env
# Editar .env
php artisan key:generate

# 4. Banco de dados
php artisan migrate --force

# 5. Cache
php artisan cache:clear
php artisan config:cache
php artisan view:cache
php artisan route:cache

# 6. Storage
php artisan storage:link

# 7. Permissões
chmod -R 755 storage bootstrap/cache
chmod -R 644 public
```

### Servidor Recomendado
- Linux (Ubuntu 20.04+)
- PHP 8.2+
- MySQL 8.0+
- Node.js 18+
- Nginx/Apache
- SSL (Let's Encrypt)

### Hosts Recomendados
- DigitalOcean (VPS)
- Linode
- Vultr
- AWS Lightsail
- Heroku (com buildpack)

---

## 📊 Estrutura de Direitos

### Admin Global
```php
if (auth()->user()->role->value === 'admin_global') {
    // Acesso total
}
```

### Middleware de Autorização
```php
// Criar middleware
php artisan make:middleware CheckAdminRole

// routes/web.php
Route::middleware(['auth', 'check.admin'])->group(function () {
    // Rotas protegidas
});
```

---

**Guia atualizado em: 5 de dezembro de 2025**

