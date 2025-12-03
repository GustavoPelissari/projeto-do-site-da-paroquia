# 🚀 Guia Completo de Instalação - Paróquia São Paulo Apóstolo

## 📦 Pré-requisitos

Antes de começar, certifique-se de ter instalado:

- **XAMPP** ([Download](https://www.apachefriends.org/)) - Inclui PHP, MySQL e Apache
- **Composer** ([Download](https://getcomposer.org/download/))
- **Node.js 18+ e NPM** ([Download](https://nodejs.org/))
- **Git** ([Download](https://git-scm.com/downloads))

### ⚙️ Configurar XAMPP

1. **Instale o XAMPP** e inicie os serviços:
   - Abra o **XAMPP Control Panel**
   - Inicie o **Apache**
   - Inicie o **MySQL**

2. **Verifique se o PHP está no PATH:**
   ```bash
   php -v
   # Se não funcionar, adicione ao PATH: C:\xampp\php
   ```

---

## 🚀 Instalação Rápida (Passo a Passo)

### 1️⃣ Clone o Repositório

```bash
git clone https://github.com/GustavoPelissari/projeto-do-site-da-paroquia.git
cd projeto-do-site-da-paroquia
```

---

### 2️⃣ Instale as Dependências

```bash
# Dependências PHP (Laravel)
composer install

# Dependências JavaScript (Vite, Bootstrap, etc)
npm install
```

---

### 3️⃣ Configure o Arquivo de Ambiente

```bash
# Windows PowerShell
Copy-Item .env.example .env

# Linux/Mac
cp .env.example .env

# Gere a chave de criptografia da aplicação
php artisan key:generate
```

---

### 4️⃣ Configure o Banco de Dados (MySQL via XAMPP)

#### **1. Crie o banco de dados no phpMyAdmin:**

1. Acesse: http://localhost/phpmyadmin
2. Clique em "**Novo**" no menu lateral
3. Nome do banco: `paroquia_sistema`
4. Collation: `utf8mb4_unicode_ci`
5. Clique em "**Criar**"

#### **2. Configure o arquivo `.env`:**

Edite o arquivo `.env` com as seguintes configurações:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=paroquia_sistema
DB_USERNAME=root
DB_PASSWORD=
```

> **Nota:** Por padrão, o XAMPP usa o usuário `root` sem senha.

---

### 5️⃣ Execute as Migrações (Criar Tabelas)

```bash
# Criar todas as tabelas no banco de dados
php artisan migrate
```

**Nota:** Se aparecer "Nothing to migrate", significa que as tabelas já existem.

---

### 6️⃣ Popule o Banco com Dados Iniciais

```bash
# Criar usuários de teste, grupos, missas, etc.
php artisan db:seed

# OU se preferir recriar TUDO do zero (CUIDADO: apaga dados existentes!)
php artisan migrate:fresh --seed
```

---

### 7️⃣ Configure o Storage (Upload de Arquivos)

```bash
# Criar link simbólico para a pasta public
php artisan storage:link
```

---

### 8️⃣ Compile os Assets (CSS/JavaScript)

**Para Desenvolvimento (com auto-reload):**
```bash
npm run dev
```
Deixe este terminal aberto durante o desenvolvimento.

**Para Produção:**
```bash
npm run build
```

---

### 9️⃣ Inicie o Servidor

Abra um **novo terminal** e execute:

```bash
php artisan serve
```

O sistema estará disponível em: **http://127.0.0.1:8000**

---

## 📱 Como Acessar pelo Celular (Mesma Rede Wi-Fi)

### 1. Descubra o IP do seu computador

**Windows:**
```bash
ipconfig
# Procure por "Endereço IPv4" (ex: 192.168.1.100)
```

**Linux/Mac:**
```bash
ifconfig
# Procure por "inet" (ex: 192.168.1.100)
```

### 2. Inicie o servidor com o IP público

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

### 3. Acesse pelo celular

No navegador do celular (conectado na **mesma rede Wi-Fi**), digite:
```
http://SEU_IP:8000
```
Exemplo: `http://192.168.1.100:8000`

### 4. Libere o Firewall (se necessário)

**Windows:**
1. Abra "Firewall do Windows com Segurança Avançada"
2. Clique em "Regras de Entrada" > "Nova Regra"
3. Escolha "Porta" > Próximo
4. TCP, porta específica: `8000` > Próximo
5. Permitir a conexão > Próximo
6. Marque todas as opções > Próximo
7. Nome: "Laravel Server" > Concluir

---

## 🔧 Comandos Úteis do Dia a Dia

### Limpar Caches
```bash
php artisan optimize:clear
# OU individualmente:
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Recompilar Assets
```bash
npm run build
```

### Ver todas as Rotas
```bash
php artisan route:list
```

### Recriar Banco de Dados (⚠️ APAGA TUDO!)
```bash
php artisan migrate:fresh --seed
```

### Ver Logs em Tempo Real
```bash
# Windows PowerShell
Get-Content storage\logs\laravel.log -Tail 50 -Wait

# Linux/Mac
tail -f storage/logs/laravel.log
```

### Listar Usuários do Sistema
```bash
php artisan tinker
>>> User::all(['name', 'email', 'role']);
>>> exit
```

---

## 🔑 Usuários de Teste

Após rodar `php artisan db:seed`, você terá acesso aos seguintes usuários:

| Perfil | Email | Senha | Permissões |
|--------|-------|-------|------------|
| **🔴 Admin Global** | `admin@paroquia.test` | `Admin123!` | Acesso total ao sistema |
| **🟡 Coordenador** | `coord.coroinhas@paroquia.test` | `Coord123!` | Gerenciar grupo Coroinhas |
| **🟠 Administrativo** | `administrativo@paroquia.test` | `Adm123!` | Gerenciar missas e grupos |
| **🟢 Usuário Padrão** | `maria@paroquia.test` | `User123!` | Solicitar participação |
| **💚 Coroinha** | `pedro.coroinha@paroquia.test` | `User123!` | Visualizar escalas |

**URL de Login:** http://127.0.0.1:8000/login

---

## 🌐 URLs do Sistema

Após iniciar o servidor (`php artisan serve`):

- **🏠 Home:** http://127.0.0.1:8000
- **🔐 Login:** http://127.0.0.1:8000/login
- **📝 Registro:** http://127.0.0.1:8000/register
- **🔔 Notificações:** http://127.0.0.1:8000/notifications
- **👥 Grupos:** http://127.0.0.1:8000/groups
- **📰 Notícias:** http://127.0.0.1:8000/news
- **📅 Eventos:** http://127.0.0.1:8000/events
- **⛪ Missas:** http://127.0.0.1:8000/masses

---

## 📁 Estrutura de Pastas do Projeto

```
paroquia-sistema/
├── app/
│   ├── Http/Controllers/      # Lógica de controle (Admin, User, etc)
│   ├── Models/                # Modelos do banco (User, Group, News, etc)
│   ├── Services/              # NotificationService, EmailService, etc
│   └── Enums/                 # UserRole, Status, etc
├── database/
│   ├── migrations/            # Estrutura do banco (tabelas e colunas)
│   ├── seeders/               # Dados iniciais (usuários, grupos, etc)
│   └── database.sqlite        # Banco SQLite (se usar SQLite)
├── public/
│   ├── images/                # Imagens públicas (logo, etc)
│   └── storage/               # Link simbólico para arquivos
├── resources/
│   ├── css/app.css            # Estilos customizados
│   ├── js/app.js              # JavaScript principal
│   └── views/                 # Templates Blade (HTML)
│       ├── admin/             # Área administrativa
│       ├── user/              # Área do usuário
│       ├── auth/              # Login e registro
│       └── layout.blade.php   # Layout principal
├── routes/
│   ├── web.php                # Rotas principais
│   └── auth.php               # Rotas de autenticação
├── storage/
│   ├── app/public/            # Uploads (escalas, imagens, etc)
│   └── logs/                  # Logs do sistema
├── .env                       # Configurações (NÃO COMMITAR!)
├── composer.json              # Dependências PHP
└── package.json               # Dependências JavaScript
```

---

## ❗ Solução de Problemas Comuns

### 🔴 Erro: "SQLSTATE[HY000] [2002] Connection refused"
**Solução:** O MySQL do XAMPP não está rodando.

1. Abra o **XAMPP Control Panel**
2. Verifique se o **MySQL** está com status verde (rodando)
3. Se não estiver, clique em "**Start**" ao lado do MySQL
4. Se ainda não funcionar, verifique se o arquivo `.env` está com as configurações corretas:
   ```env
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_USERNAME=root
   DB_PASSWORD=
   ```

### 🔴 Erro: "The stream or file could not be opened"
**Solução:** Permissões incorretas na pasta `storage`.
```bash
# Windows (PowerShell como Administrador)
icacls storage /grant Users:F /T
icacls bootstrap\cache /grant Users:F /T

# Linux/Mac
chmod -R 775 storage bootstrap/cache
sudo chown -R $USER:www-data storage bootstrap/cache
```

### 🔴 Assets (CSS/JS) não carregam
**Solução:**
```bash
npm run build
php artisan view:clear
php artisan config:clear
```

### 🔴 Imagens não aparecem
**Solução:**
```bash
php artisan storage:link
```

### 🔴 Erro: "Class 'App\Models\User' not found"
**Solução:**
```bash
composer dump-autoload
php artisan optimize:clear
```

### 🔴 Página em branco após login
**Solução:**
```bash
php artisan view:clear
php artisan route:clear
# Verifique os logs em storage/logs/laravel.log
```

### 🔴 Celular não acessa o servidor
**Soluções:**
1. Certifique-se de que o celular está na mesma rede Wi-Fi
2. Use `--host=0.0.0.0` ao iniciar o servidor
3. Desative temporariamente o Firewall do Windows
4. Verifique o IP com `ipconfig` (Windows) ou `ifconfig` (Linux/Mac)

---

## 🔄 Atualizando o Projeto

Quando baixar atualizações do repositório:

```bash
# 1. Baixar atualizações
git pull origin main

# 2. Atualizar dependências
composer install
npm install

# 3. Executar novas migrações
php artisan migrate

# 4. Recompilar assets
npm run build

# 5. Limpar caches
php artisan optimize:clear
```

---

## 📞 Suporte

Para dúvidas ou problemas, consulte:
- Documentação Laravel: https://laravel.com/docs
- Repositório: https://github.com/GustavoPelissari/projeto-do-site-da-paroquia

---

**Desenvolvido com ❤️ para a Paróquia São Paulo Apóstolo - Diocese de Umuarama**
