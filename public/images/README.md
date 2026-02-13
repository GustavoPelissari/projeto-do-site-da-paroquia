# Logo da Paróquia (com transparência)

O projeto usa, por padrão, o arquivo:

- `public/images/sao-paulo-apostolo.svg`

Esse arquivo deve ter fundo transparente.

## Como trocar a logo

1. Adicione um arquivo PNG ou SVG com transparência em `public/images/`.
2. Configure o caminho no `.env`:

```env
APP_LOGO_PATH=images/sua-logo-transparente.svg
```

3. Limpe o cache de configuração:

```bash
php artisan config:clear
```

## Onde a logo é exibida

- Layout público (navbar e rodapé)
- Layout de autenticação (login, recuperação de senha, etc.)
- Header compartilhado
