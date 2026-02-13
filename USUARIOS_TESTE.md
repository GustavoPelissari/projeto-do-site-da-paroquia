# Usuários de teste por perfil

## Seed recomendada

```bash
php artisan db:seed --class=TestRoleUsersSeeder
```

Essa seed é **idempotente**: se o e-mail já existir, o usuário é atualizado (não duplica).

## Credenciais (DEV)

- **PADRE** (equivalente técnico: `admin_global`)
  - E-mail: `padre@teste.com`
  - Senha: `Teste@1234`

- **ADMINISTRAÇÃO** (equivalente técnico: `administrativo`)
  - E-mail: `admin@teste.com`
  - Senha: `Teste@1234`

- **COORDENADOR_DE_PASTORAL** (equivalente técnico: `coordenador_de_pastoral`)
  - E-mail: `coordenador@teste.com`
  - Senha: `Teste@1234`

## Validação rápida

1. Execute a seed.
2. Faça login com cada usuário em `/login`.
3. Confirme o redirecionamento e as permissões conforme o perfil.
