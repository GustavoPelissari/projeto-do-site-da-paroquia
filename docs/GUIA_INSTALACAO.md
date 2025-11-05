# 🚀 Comandos para Configuração do Projeto - Paróquia São Paulo Apóstolo

## Pré-requisitos
- PHP 8.2 ou superior
- Composer
- Node.js e NPM
- XAMPP (Apache e MySQL/SQLite)

---

## 📋 Passos para Configuração

### 1. Clone o repositório
```bash
git clone https://github.com/GustavoPelissari/projeto-do-site-da-paroquia.git
cd projeto-do-site-da-paroquia
```

### 2. Instale as dependências do PHP
```bash
composer install
```

### 3. Instale as dependências do Node.js
```bash
npm install
```

### 4. Configure o arquivo .env
```bash
# Copie o arquivo de exemplo
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate
```

### 5. Configure o banco de dados
Edite o arquivo `.env` e configure:
```
DB_CONNECTION=sqlite
# Se usar SQLite, não precisa de DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
```

### 6. Crie o banco de dados SQLite
```bash
# No PowerShell (Windows)
New-Item -Path database/database.sqlite -ItemType File

# No Bash/Linux/Mac
touch database/database.sqlite
```

### 7. Execute as migrations
```bash
php artisan migrate
```

### 8. Execute os seeders (dados iniciais)
```bash
# Seeder principal
php artisan db:seed

# Seeders específicos (se necessário)
php artisan db:seed --class=UpdatedMassesSeeder
php artisan db:seed --class=ChapelsSeeder
php artisan db:seed --class=ClergySeeder
```

### 9. Crie o link simbólico para storage
```bash
php artisan storage:link
```

### 10. Compile os assets (CSS/JS)
```bash
# Para desenvolvimento (com watch)
npm run dev

# Para produção
npm run build
```

### 11. Inicie o servidor
```bash
# Em um terminal
php artisan serve

# Em outro terminal (se usar npm run dev)
npm run dev
```

---

## 🔑 Usuários de Teste

Após rodar os seeders, você terá acesso aos seguintes usuários:

### Admin Global (Padre)
- **Email:** `admin@paroquia.test`
- **Senha:** `Admin123!`

### Coordenador de Pastoral
- **Email:** `coord.coroinhas@paroquia.test`
- **Senha:** `Coord123!`

### Administrativo
- **Email:** `administrativo@paroquia.test`
- **Senha:** `Adm123!`

### Usuário Padrão
- **Email:** `maria@paroquia.test`
- **Senha:** `User123!`

### Usuário Coroinha
- **Email:** `pedro.coroinha@paroquia.test`
- **Senha:** `User123!`

---

## 🌐 Acessar o Sistema

Após iniciar o servidor, acesse:
- **URL:** http://127.0.0.1:8000
- **Admin:** http://127.0.0.1:8000/login

---

## 🛠️ Comandos Úteis

### Limpar cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Recriar banco de dados (CUIDADO: apaga tudo!)
```bash
php artisan migrate:fresh --seed
```

### Ver rotas disponíveis
```bash
php artisan route:list
```

### Verificar erros
```bash
# Ver logs
tail -f storage/logs/laravel.log

# No Windows (PowerShell)
Get-Content storage/logs/laravel.log -Tail 50 -Wait
```

---

## 📁 Estrutura de Pastas Importantes

```
paroquia-sistema/
├── app/                    # Código PHP (Models, Controllers, etc)
├── database/
│   ├── migrations/        # Estrutura do banco de dados
│   ├── seeders/          # Dados iniciais
│   └── database.sqlite   # Banco SQLite (criar manualmente)
├── public/
│   └── images/           # Imagens públicas
├── resources/
│   ├── css/              # Estilos CSS
│   ├── js/               # JavaScript
│   └── views/            # Templates Blade
├── routes/
│   └── web.php           # Rotas do sistema
└── storage/
    └── app/public/       # Upload de arquivos
```

---

## ❗ Solução de Problemas Comuns

### Erro de permissão em storage/logs
```bash
# Windows (PowerShell como Admin)
icacls storage /grant Users:F /T
icacls bootstrap/cache /grant Users:F /T

# Linux/Mac
chmod -R 775 storage bootstrap/cache
```

### Assets não carregam
```bash
npm run build
php artisan view:clear
```

### Imagens não aparecem
```bash
php artisan storage:link
```

### Erro "Class not found"
```bash
composer dump-autoload
```

---

## 📞 Suporte

Para dúvidas ou problemas, consulte:
- Documentação Laravel: https://laravel.com/docs
- Repositório: https://github.com/GustavoPelissari/projeto-do-site-da-paroquia

---

**Desenvolvido com ❤️ para a Paróquia São Paulo Apóstolo - Diocese de Umuarama**
