# 🚀 Guia de Deployment — Sistema Paroquial

## Pré-requisitos

- PHP 8.2+
- MySQL 5.7+ ou MariaDB
- Node.js 18+
- Composer
- SSL Certificate (HTTPS)

## 1️⃣ Preparação do Servidor

### 1.1 Criar banco de dados e usuário

```sql
CREATE DATABASE paroquia_sistema CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'paroquia_user'@'localhost' IDENTIFIED BY 'SENHA_FORTE_AQUI';
GRANT ALL PRIVILEGES ON paroquia_sistema.* TO 'paroquia_user'@'localhost';
FLUSH PRIVILEGES;
```

### 1.2 Configurar arquivo .env para produção

```bash
cp .env.production.example .env
# Edite .env com credenciais reais
nano .env
```

**Variáveis críticas a verificar:**
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_KEY=base64:...` (gerado)
- `APP_URL=https://seu-dominio.com.br`
- `SESSION_SECURE_COOKIE=true`
- `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `MAIL_HOST`, `MAIL_USERNAME`, `MAIL_PASSWORD`

### 1.3 Configurar permissões

```bash
chmod -R 755 bootstrap/cache
chmod -R 755 storage
chmod -R 755 public
chown -R www-data:www-data /var/www/paroquia
```

## 2️⃣ Deploy Inicial

### 2.1 Instalação de dependências

```bash
cd /var/www/paroquia

# PHP dependencies
composer install --no-dev --optimize-autoloader

# Frontend dependencies
npm ci
npm run build
```

### 2.2 Gerar chave de aplicação

```bash
php artisan key:generate
```

### 2.3 Executar migrações

```bash
php artisan migrate --force
```

### 2.4 Cache routes e config

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 3️⃣ Configuração do Nginx (ou Apache)

### Nginx

```nginx
server {
    listen 443 ssl http2;
    server_name paroquia.seu-dominio.com.br;
    
    ssl_certificate /etc/ssl/certs/seu-certificado.crt;
    ssl_certificate_key /etc/ssl/private/sua-chave.key;
    
    root /var/www/paroquia/public;
    index index.php;
    
    # Security headers
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains; preload" always;
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    
    # Compression
    gzip on;
    gzip_vary on;
    gzip_types text/plain text/css text/xml text/javascript 
               application/x-javascript application/xml+rss 
               application/json image/svg+xml;
    
    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.ht {
        deny all;
    }
    
    location ~* \.(?:jpg|jpeg|gif|png|ico|cur|gz|svg|svgz|mp4|ogg|ogv|webm|htc)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
    
    location ~* \.(?:css|js|woff|woff2)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}

# Redirecionar HTTP para HTTPS
server {
    listen 80;
    server_name paroquia.seu-dominio.com.br;
    return 301 https://$server_name$request_uri;
}
```

## 4️⃣ Cronjobs

Adicionar ao crontab (`crontab -e`):

```bash
# Laravel scheduler
* * * * * cd /var/www/paroquia && php artisan schedule:run >> /dev/null 2>&1

# Backup diário do banco
0 2 * * * mysqldump -u paroquia_user -pSENHA paroquia_sistema > /backups/paroquia_$(date +\%Y\%m\%d).sql
```

## 5️⃣ Monitoring e Logs

### Ver logs em tempo real

```bash
tail -f /var/www/paroquia/storage/logs/laravel.log
```

### Monitorar performance

```bash
# Verificar uso de disco
df -h /var/www/paroquia

# Verificar tamanho do storage
du -sh /var/www/paroquia/storage/*
```

### Limpar logs antigos

```bash
php artisan logs:prune --days=30
```

## 6️⃣ Atualização de Deploy

### Para atualizações futuras:

```bash
git pull origin main

composer install --no-dev --optimize-autoloader

npm ci && npm run build

php artisan migrate --force

php artisan config:cache
php artisan route:cache
php artisan view:cache

# Reiniciar services
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
```

## 7️⃣ Troubleshooting

### 500 Internal Server Error

```bash
# Limpar cache
php artisan cache:clear
php artisan config:clear

# Regenerar APP_KEY se necessário
php artisan key:generate

# Verificar permissões
sudo chown -R www-data:www-data storage/
```

### Migrations falhando

```bash
# Ver status
php artisan migrate:status

# Rollback de uma migração
php artisan migrate:rollback --step=1

# Reiniciar migrações (⚠️ apaga dados!)
php artisan migrate:refresh --seed
```

### Emails não enviando

```bash
# Testar conexão SMTP
php artisan tinker
>>> Mail::raw('test', function($msg) { $msg->to('seu-email@domain.com'); });
```

## 📊 Checklist Final

- [ ] APP_DEBUG=false
- [ ] SESSION_SECURE_COOKIE=true
- [ ] HTTPS configurado e funcionando
- [ ] Banco de dados migrado
- [ ] Assets otimizados (npm run build)
- [ ] Cronjobs configurados
- [ ] Backup automatizado ativo
- [ ] SSL com auto-renewal (certbot)
- [ ] Monitoramento de logs ativo
- [ ] Emails funcionando

---

**Support:** Para dúvidas, verifique `USUARIOS_TESTE.md` e `GUIA_INSTALACAO.md`
