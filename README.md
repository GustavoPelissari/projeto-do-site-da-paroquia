# 🏛️ Sistema da Paróquia São Paulo Apóstolo

Sistema completo de gerenciamento para a Paróquia São Paulo Apóstolo da Diocese de Umuarama, desenvolvido em Laravel 11 com design responsivo e moderno.

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

## 🚀 **Deploy**

Para produção, execute:
```bash
# Otimize para produção
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🤝 **Contribuição**

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/nova-funcionalidade`)
3. Commit suas mudanças (`git commit -m 'Adiciona nova funcionalidade'`)
4. Push para a branch (`git push origin feature/nova-funcionalidade`)
5. Abra um Pull Request

## 📄 **Licença**

Este projeto é propriedade da Paróquia São Paulo Apóstolo - Diocese de Umuarama.

## 📞 **Contato**

**Paróquia São Paulo Apóstolo**
- Diocese de Umuarama
- Website: [Em desenvolvimento]
- Email: [contato@paroquiasaoapostolo.org.br]

---

Desenvolvido com ❤️ para a comunidade católica de São Paulo Apóstolo

