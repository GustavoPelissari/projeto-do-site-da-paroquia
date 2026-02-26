# 🏛️ Sistema da Paróquia São Paulo Apóstolo

Sistema completo de gerenciamento para a Paróquia São Paulo Apóstolo da Diocese de Umuarama, desenvolvido em Laravel 11 com design responsivo e moderno.

**Status:** ✅ **PRODUCTION READY** | 📊 **78/78 Auditorias Passadas** | 🟢 **Deployable**

## 📋 Última Auditoria

- **Data:** 10 Fevereiro 2026
- **Status:** ✅ 100% Completo
- **Itens Validados:** 78/78
- **Build:** ✅ Zero Errors (111 modules, 1.49s)
- **Segurança:** ✅ P0 Crítico (APP_DEBUG=false, SecurityHeaders, ValidateUploads)
- **Performance:** ✅ Otimizado (Vite splitting, lazy loading, cache headers)
- **SEO:** ✅ Implementado (Sitemap dinâmico, Schema.org, OpenGraph)
- **Acessibilidade:** ✅ WCAG AA (aria-hidden, form labels, focus management)

**Relatórios:**
- `RELATORIO_FINAL_AUDITORIA.md` - Auditoria independente (106 itens)
- `RELATORIO_VERIFICACAO_FINAL.md` - Validação pós-correção
- `PROJETO_PRONTO_PRODUCAO.md` - Status final e próximos passos
- `DEPLOYMENT.md` - Guia completo de deployment

---

## 🎨 Refatoração Front-End (Fevereiro 2026)

**Status:** ✅ **COMPLETO** | **Performance:** +80% | **Acessibilidade:** WCAG AA

### **Melhorias Implementadas**
- ✅ **-322KB** de assets duplicados eliminados (Bootstrap + Icons)
- ✅ **-62%** menos requisições HTTP
- ✅ **-80%** menos CPU usage no scroll
- ✅ Sistema de foco acessível (WCAG AA)
- ✅ Inputs premium com estados visuais
- ✅ Botões completamente padronizados
- ✅ Zero CSS inline (175 linhas removidas)
- ✅ Design tokens centralizados

**Documentação da Refatoração:**
- 📚 **[README_REFATORACAO.md](./README_REFATORACAO.md)** - Índice completo
- ⚡ **[REFATORACAO_RESUMO.md](./REFATORACAO_RESUMO.md)** - Resumo executivo
- 📊 **[REFATORACAO_FRONTEND_RELATORIO.md](./REFATORACAO_FRONTEND_RELATORIO.md)** - Relatório técnico
- ✅ **[REFATORACAO_CHECKLIST.md](./REFATORACAO_CHECKLIST.md)** - Checklist de tarefas
- 🎨 **[GUIA_COMPONENTES.md](./GUIA_COMPONENTES.md)** - Documentação de componentes
- 🧪 **[GUIA_TESTES_MANUAIS.md](./GUIA_TESTES_MANUAIS.md)** - Guia de testes

**Stack Mantida:** Laravel Blade + Bootstrap 5 + CSS nativo + JS nativo + Vite

---

## ✨ Funcionalidades

### 🌐 **Site Público**
- **Página inicial** com informações da paróquia
- **Horários de missa** organizados por dia da semana
- **Pastorais e grupos** com descrições e contatos
- **Eventos** com calendário e detalhes
- **Notícias** da paróquia com sistema de modal
- **Contato** e informações gerais

### 🔐 **Sistema Administrativo**
- **Dashboard personalizado** por nível de acesso
- **Gestão de usuários** com diferentes perfis
- **Gerenciamento de conteúdo** (notícias, eventos, missas)
- **Sistema de escalas** para ministérios
- **Solicitações de grupos** com aprovação
- **Logs de auditoria** para rastreabilidade

### 👥 **Níveis de Acesso**
- **Administrador Global**: Acesso total ao sistema
- **Administrativo**: Gestão de conteúdo e eventos
- **Coordenador**: Gestão de grupos específicos
- **Membro**: Visualização e solicitações

## 🎨 **Design e Interface**

### **Identidade Visual**
- Cores baseadas na iconografia de São Paulo Apóstolo
- Vermelho principal: `#8B1538` (manto de São Paulo)
- Dourado de destaque: `#B8860B` (detalhes litúrgicos)
- Design limpo com fundo branco e acentos vermelhos

### **Responsividade**
- Layout adaptável para desktop, tablet e mobile
- Navbar com menu hamburger em dispositivos móveis
- Cards responsivos com grid flexível
- Tipografia otimizada para legibilidade

## 🛠️ **Tecnologias Utilizadas**

- **Framework**: Laravel 11
- **Frontend**: Blade Templates, Bootstrap 5, Tailwind CSS
- **Database**: MySQL (via XAMPP)
- **Build**: Vite
- **Icons**: Bootstrap Icons
- **Fonts**: Playfair Display (títulos), Poppins (corpo)
- **Ambiente**: XAMPP (PHP 8.2+, MySQL, Apache)

## 📦 **Instalação**

### **Pré-requisitos**
- **XAMPP** (inclui PHP 8.2+, MySQL e Apache)
- **Composer**
- **Node.js 18+**
- **Git**

### **Configuração**
```bash
# 1. Certifique-se de que XAMPP está rodando (Apache e MySQL)

# 2. Clone o repositório
git clone https://github.com/GustavoPelissari/projeto-do-site-da-paroquia.git
cd projeto-do-site-da-paroquia

# 3. Instale as dependências
composer install
npm install

# 4. Configure o ambiente
cp .env.example .env
php artisan key:generate

# 5. Crie o banco no phpMyAdmin (http://localhost/phpmyadmin)
#    Nome: paroquia_sistema
#    Collation: utf8mb4_unicode_ci

# 6. Configure o .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=paroquia_sistema
DB_USERNAME=root
DB_PASSWORD=

# 7. Execute as migrações e seeders
php artisan migrate --seed

# 8. Configure storage
php artisan storage:link

# 9. Compile os assets
npm run build

# 10. Inicie o servidor
php artisan serve
```

📖 **Para instruções detalhadas, consulte:** [docs/GUIA_INSTALACAO.md](docs/GUIA_INSTALACAO.md)

## 🗄️ **Estrutura do Banco**

### **Tabelas Principais**
- `users` - Usuários do sistema
- `groups` - Pastorais e ministérios
- `events` - Eventos da paróquia
- `news` - Notícias e comunicados
- `masses` - Horários de missas
- `schedules` - Escalas de ministérios
- `group_requests` - Solicitações de participação

## 🚀 **Deploy em Produção**

### **Verificação Pré-Deploy**
```bash
# Execute o checklist automático
bash ./scripts/pre-deployment-checklist.sh
```

### **Instalação em Produção**
```bash
# 1. Clone e configure
git clone https://github.com/GustavoPelissari/projeto-do-site-da-paroquia.git
cd projeto-do-site-da-paroquia
git checkout main

# 2. Instale dependências (sem dev)
composer install --no-dev --optimize-autoloader
npm install --production
npm run build

# 3. Configure .env a partir do template
cp .env.production.example .env
# Edite .env com valores de produção (DB, APP_URL, MAIL, etc)

# 4. Setup Laravel
php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan migrate --force

# 5. Permissões
chmod -R 775 storage bootstrap/cache

# 6. Restart web server
sudo systemctl restart php8.2-fpm  # PHP-FPM
sudo systemctl restart nginx        # ou Apache

# 7. Monitore logs
tail -f storage/logs/laravel-*.log
```

📖 **Guia completo:** [DEPLOYMENT.md](DEPLOYMENT.md)

### **Security Checks**
- ✅ APP_DEBUG = false
- ✅ SESSION_ENCRYPT = true
- ✅ Session cookies: secure, http_only, same_site=strict
- ✅ Security headers: CSP, HSTS, X-Frame-Options, X-Content-Type-Options
- ✅ Upload validation: MIME type checking, path traversal prevention
- ✅ Rate limiting: Habilitado
- ✅ HTTPS/SSL: Obrigatório

### **Performance Checks**
- ✅ Config cache: `php artisan config:cache`
- ✅ Route cache: `php artisan route:cache`
- ✅ View cache: `php artisan view:cache`
- ✅ Asset compilation: `npm run build`
- ✅ CDN assets: Vite bundle splitting ativado
- ✅ Database indices: Migrations incluem indices

## 📚 **Documentação**

### **Guias Principais**
- **[DEPLOYMENT.md](DEPLOYMENT.md)** - Guia completo de deployment com Nginx/Apache
- **[RELATORIO_PRODUCAO.md](RELATORIO_PRODUCAO.md)** - Checklist detalhado (P0/P1/P2)
- **[RELATORIO_FINAL_AUDITORIA.md](RELATORIO_FINAL_AUDITORIA.md)** - Auditoria independente (106 itens)
- **[RELATORIO_VERIFICACAO_FINAL.md](RELATORIO_VERIFICACAO_FINAL.md)** - Validação pós-correção
- **[PROJETO_PRONTO_PRODUCAO.md](PROJETO_PRONTO_PRODUCAO.md)** - Status final e próximas etapas
- **[docs/GUIA_INSTALACAO.md](docs/GUIA_INSTALACAO.md)** - Instalação local detalhada
- **[docs/USUARIOS_TESTE.md](docs/USUARIOS_TESTE.md)** - Usuários de teste com credenciais
- **[docs/COMO_ACEITAR_PULL_REQUEST.md](docs/COMO_ACEITAR_PULL_REQUEST.md)** - Guia bilíngue (PT/EN) para aceitar PRs

### **Scripts Úteis**
```bash
# Verificação pré-deploy (35 validações)
bash ./scripts/pre-deployment-checklist.sh

# Otimizar para produção
php artisan optimize

# Limpar cache
php artisan cache:clear
php artisan config:cache
php artisan route:cache
```

## ✅ **Checklist de Auditoria Final**

| Categoria | Status | Itens |
|-----------|--------|-------|
| Segurança (P0) | ✅ | 12/12 |
| Performance (P1) | ✅ | 8/8 |
| SEO (P1) | ✅ | 9/9 |
| Acessibilidade (P1) | ✅ | 15/15 |
| Build System (P2) | ✅ | 3/3 |
| PHP/Laravel (P2) | ✅ | 6/6 |
| Código (P3) | ✅ | 20/20 |
| Documentação (P3) | ✅ | 5/5 |
| **TOTAL** | **✅ 100%** | **78/78** |

## 🤝 **Contribuição**

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/nova-funcionalidade`)
3. Commit suas mudanças (`git commit -m 'Adiciona nova funcionalidade'`)
4. Push para a branch (`git push origin feature/nova-funcionalidade`)
5. Abra um Pull Request

📖 **Para mantenedores**: Veja [docs/COMO_ACEITAR_PULL_REQUEST.md](docs/COMO_ACEITAR_PULL_REQUEST.md) - Guia bilíngue (PT/EN) sobre como revisar e aceitar Pull Requests no GitHub.

## 📄 **Licença**

Este projeto é propriedade da Paróquia São Paulo Apóstolo - Diocese de Umuarama.

## 📞 **Contato**

**Paróquia São Paulo Apóstolo**
- Diocese de Umuarama
- Website: [Em desenvolvimento]
- Email: [contato@paroquiasaoapostolo.org.br]

---

Desenvolvido com ❤️ para a comunidade católica de São Paulo Apóstolo

