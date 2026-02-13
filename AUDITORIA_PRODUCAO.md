# Auditoria de prontidão para produção

Data: 2026-02-12

## Problemas críticos encontrados

1. Rotas apontam para métodos inexistentes nos controllers (quebra imediata com erro 500/BadMethodCallException).
2. Diversas actions retornam views que não existem no projeto (erro `View [..] not found`).
3. Múltiplos fluxos de criação/edição usam campos que não existem no schema (ex.: `date`, `time`) ou valores fora do enum do banco (ex.: `pending`).
4. Há inconsistência de modelagem entre `group_id` e `parish_group_id`, gerando lógica quebrada e dashboards com dados incorretos/zerados.
5. Há relações Eloquent usadas no código que não existem (`users`, `groups`) e que podem causar exceções em runtime.
6. Parte do painel administrativo referencia rotas não registradas no `routes/web.php`, impedindo uso normal da interface.

## Observações de validação

- Lint de PHP passou (sem erros de sintaxe).
- Testes PHP não puderam ser executados neste ambiente por incompatibilidade de versão do PHP com o lockfile.
- Testes de frontend (Vitest) existentes passaram.
