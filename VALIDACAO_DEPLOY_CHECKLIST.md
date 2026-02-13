# Validação rápida de deploy (execução local)

Data: 2026-02-13

## Escopo e limitações
- Não foi informada URL de staging/produção neste chamado; portanto os itens de SSL, DNS, entregabilidade real e comportamento do ambiente remoto ficaram **pendentes**.
- O ambiente local não conseguiu instalar dependências PHP via Composer por bloqueio de rede (GitHub 403), então os testes Laravel/rotas em runtime ficaram **pendentes**.

## 1) Bate-pronto: saúde do sistema
- **URL staging/produção**: pendente (URL não fornecida).
- **HTTPS/SSL/conteúdo misto**: pendente (depende da URL remota).
- **Health check (`/health`/`/status`)**: não há rota explícita de health check em `routes/web.php`; recomendada criação dedicada.
- **Logs na carga da home**: pendente (aplicação PHP não pôde subir sem `vendor/`).

## 2) Smoke test funcional
- **Navegação/UI**: pendente em runtime (sem bootstrap Laravel completo).
- **Auth/sessão**: cobertura parcial por leitura de rotas e testes existentes:
  - Login/logout/registro estão declarados em `routes/auth.php`.
  - Verificação de e-mail usa `signed` + `throttle:6,1`.

## 3) Cadastro + e-mail de confirmação
- Fluxo de cadastro cria usuário com validação de campos obrigatórios, e-mail único e regra de senha (`Rules\Password::defaults()`).
- Após criação, dispara evento `Registered($user)` (fluxo padrão de envio de e-mail de verificação quando listener está ativo).
- Pendências para validação real: entrega do e-mail, template renderizado, links corretos por ambiente, SPF/DKIM/DMARC e comportamento em múltiplos cadastros.

## 4) Back-end checklist
- **Variáveis de ambiente/integrações/migrações em runtime**: pendente por impossibilidade de instalar dependências PHP.
- **Segurança básica em código**:
  - Rotas de verificação com assinatura e throttling presentes.
  - Middleware de auth aplicado para rotas protegidas.

## 5) Testes/CI
- `vitest` executado com sucesso (4 testes).
- `vite build` inicialmente falhava por `terser` opcional não instalado; ajustado para usar `esbuild` e build agora passa.
- Testes PHPUnit/Laravel: pendentes por falha de instalação de dependências PHP.

## 6) Observabilidade e rollback
- Não validado em runtime remoto (sem URL/sem deploy target).

## 7) Resultado executivo
- **Concluído agora**: validação estática de rotas/fluxo de cadastro, testes de frontend e correção do build frontend.
- **Ação recomendada imediata**:
  1. Fornecer URL de staging/prod para executar smoke real.
  2. Expor endpoint `/health` com versão/build, uptime e status de dependências.
  3. Rodar checklist de e-mail fim-a-fim com 2 cadastros sequenciais em staging.
