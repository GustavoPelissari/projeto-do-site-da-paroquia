# 🔀 Como Aceitar Pull Requests no GitHub | How to Accept Pull Requests on GitHub

**Guia bilíngue (Português/English) para gerenciar Pull Requests**

---

## 📋 Índice | Table of Contents

- [Português](#português)
  - [O que é um Pull Request?](#o-que-é-um-pull-request)
  - [Como Aceitar um Pull Request](#como-aceitar-um-pull-request)
  - [Opções de Merge](#opções-de-merge)
  - [Boas Práticas](#boas-práticas)
  - [Glossário GitHub](#glossário-github)
- [English](#english)
  - [What is a Pull Request?](#what-is-a-pull-request)
  - [How to Accept a Pull Request](#how-to-accept-a-pull-request)
  - [Merge Options](#merge-options)
  - [Best Practices](#best-practices)
  - [GitHub Glossary](#github-glossary)

---

# Português

## O que é um Pull Request?

Um **Pull Request (PR)** é uma solicitação para incorporar mudanças de código de uma branch (ramificação) para outra, geralmente da branch de um contribuidor para a branch principal do projeto (`main` ou `master`).

### Fluxo Básico:
1. Um desenvolvedor cria mudanças em uma branch separada
2. Ele abre um Pull Request solicitando que essas mudanças sejam aceitas
3. O mantenedor do projeto revisa as mudanças
4. Se aprovadas, o mantenedor **aceita/merge** o Pull Request

---

## Como Aceitar um Pull Request

### Passo 1: Acessar a Aba Pull Requests

1. Abra seu repositório no GitHub
2. Clique na aba **"Pull requests"** no topo da página
3. Você verá uma lista de todos os PRs abertos

### Passo 2: Revisar o Pull Request

1. Clique no Pull Request que deseja revisar
2. Você verá três abas importantes:
   - **Conversation**: Discussão e comentários sobre o PR
   - **Commits**: Lista de commits incluídos no PR
   - **Files changed**: Visualização das mudanças no código (diff)

3. Revise as mudanças em **"Files changed"**:
   - Linhas verdes (+) = código adicionado
   - Linhas vermelhas (-) = código removido
   - Você pode adicionar comentários clicando no botão **"+"** ao lado de cada linha

### Passo 3: Verificar Status dos Checks

- Na parte inferior do PR, você verá **"Checks"** (verificações automáticas)
- ✅ Verde = Todos os testes passaram
- ❌ Vermelho = Algum teste falhou
- **Importante**: Só aceite PRs com todos os checks verdes

### Passo 4: Aceitar (Merge) o Pull Request

1. Role até o final da página do PR
2. Você verá um botão verde **"Merge pull request"**
3. Clique no botão
4. Confirme clicando em **"Confirm merge"**
5. Opcionalmente, você pode deletar a branch após o merge clicando em **"Delete branch"**

### Interface Visual:

```
┌─────────────────────────────────────────────────┐
│ Pull Request #123                                │
│ "Adiciona nova funcionalidade"                   │
├─────────────────────────────────────────────────┤
│ Conversation | Commits | Files changed          │
├─────────────────────────────────────────────────┤
│                                                   │
│ ✅ All checks have passed                       │
│                                                   │
│ [▼ Merge pull request]  ← Clique aqui           │
│                                                   │
│ Depois:                                           │
│ [ Confirm merge ]       ← Confirme aqui          │
│ [ Delete branch ]       ← Opcional               │
└─────────────────────────────────────────────────┘
```

---

## Opções de Merge

Ao clicar no botão de merge, você verá um menu dropdown com três opções:

### 1. **Merge Commit** (Padrão)
- Cria um commit de merge que preserva todo o histórico
- Mantém todos os commits da branch de origem
- **Use quando**: Quer preservar o histórico completo

```
Antes:  main ──────○────
                    ╲
        feature ─────○──○──
        
Depois: main ──────○─────●  (merge commit)
                    ╲   ╱
        feature ─────○─○
```

### 2. **Squash and Merge**
- Combina todos os commits em um único commit
- Cria um histórico mais limpo
- **Use quando**: PR tem muitos commits pequenos/experimentais

```
Antes:  main ──────○────
        feature ─────○──○──○── (3 commits)
        
Depois: main ──────○──●  (1 commit único)
```

### 3. **Rebase and Merge**
- Reaplica os commits em sequência linear
- Não cria commit de merge
- **Use quando**: Quer manter histórico linear sem merge commits

```
Antes:  main ──────○────
        feature ─────○──○──
        
Depois: main ──────○──○──○  (commits em linha)
```

**Recomendação para este projeto**: Use **"Squash and Merge"** para manter o histórico limpo.

---

## Boas Práticas

### ✅ Antes de Aceitar um PR:

1. **Revisar o código** em "Files changed"
2. **Verificar os checks** estão todos verdes (✅)
3. **Testar localmente** se necessário:
   ```bash
   git fetch origin
   git checkout -b test-pr-123 origin/branch-name
   npm install
   npm run build
   php artisan migrate
   ```
4. **Ler a descrição** do PR para entender as mudanças
5. **Verificar conflitos** - Se aparecer "This branch has conflicts", peça ao autor para resolver

### ❌ Não Aceitar se:

- ❌ Checks estão falhando (vermelho)
- ❌ Há conflitos de merge não resolvidos
- ❌ O código não segue os padrões do projeto
- ❌ Faltam testes ou documentação necessária
- ❌ Você não entende o que o código faz

### 💬 Comunicação:

- Use comentários para pedir mudanças: **"Request changes"**
- Aprove mudanças boas: **"Approve"**
- Peça esclarecimentos se não entender algo

---

## Glossário GitHub

| Termo em Inglês | Significado em Português |
|-----------------|--------------------------|
| **Pull Request (PR)** | Solicitação de Pull (incorporação de código) |
| **Merge** | Mesclar/Aceitar (incorporar mudanças) |
| **Branch** | Ramificação/Branch (linha de desenvolvimento separada) |
| **Commit** | Confirmar (salvar mudanças) |
| **Fork** | Bifurcação (cópia do repositório) |
| **Clone** | Clonar (baixar repositório) |
| **Push** | Enviar (enviar mudanças para o servidor) |
| **Pull** | Puxar (baixar mudanças do servidor) |
| **Conflict** | Conflito (mudanças incompatíveis) |
| **Review** | Revisão (avaliar código) |
| **Approve** | Aprovar (autorizar mudanças) |
| **Request changes** | Solicitar mudanças (pedir modificações) |
| **Comment** | Comentário (adicionar observação) |
| **Files changed** | Arquivos modificados |
| **Conversation** | Conversa/Discussão |
| **Checks** | Verificações (testes automáticos) |
| **Draft** | Rascunho (PR ainda em progresso) |
| **Ready for review** | Pronto para revisão |
| **Squash** | Comprimir (combinar commits) |
| **Rebase** | Reorganizar (reaplicar commits) |

---

# English

## What is a Pull Request?

A **Pull Request (PR)** is a request to incorporate code changes from one branch into another, usually from a contributor's branch into the project's main branch (`main` or `master`).

### Basic Flow:
1. A developer creates changes in a separate branch
2. They open a Pull Request requesting these changes to be accepted
3. The project maintainer reviews the changes
4. If approved, the maintainer **accepts/merges** the Pull Request

---

## How to Accept a Pull Request

### Step 1: Access the Pull Requests Tab

1. Open your repository on GitHub
2. Click on the **"Pull requests"** tab at the top of the page
3. You'll see a list of all open PRs

### Step 2: Review the Pull Request

1. Click on the Pull Request you want to review
2. You'll see three important tabs:
   - **Conversation**: Discussion and comments about the PR
   - **Commits**: List of commits included in the PR
   - **Files changed**: View of code changes (diff)

3. Review the changes in **"Files changed"**:
   - Green lines (+) = code added
   - Red lines (-) = code removed
   - You can add comments by clicking the **"+"** button next to each line

### Step 3: Check Status of Checks

- At the bottom of the PR, you'll see **"Checks"** (automated verifications)
- ✅ Green = All tests passed
- ❌ Red = Some test failed
- **Important**: Only accept PRs with all checks green

### Step 4: Accept (Merge) the Pull Request

1. Scroll to the bottom of the PR page
2. You'll see a green button **"Merge pull request"**
3. Click the button
4. Confirm by clicking **"Confirm merge"**
5. Optionally, you can delete the branch after merging by clicking **"Delete branch"**

### Visual Interface:

```
┌─────────────────────────────────────────────────┐
│ Pull Request #123                                │
│ "Add new feature"                                │
├─────────────────────────────────────────────────┤
│ Conversation | Commits | Files changed          │
├─────────────────────────────────────────────────┤
│                                                   │
│ ✅ All checks have passed                       │
│                                                   │
│ [▼ Merge pull request]  ← Click here            │
│                                                   │
│ Then:                                             │
│ [ Confirm merge ]       ← Confirm here           │
│ [ Delete branch ]       ← Optional               │
└─────────────────────────────────────────────────┘
```

---

## Merge Options

When clicking the merge button, you'll see a dropdown menu with three options:

### 1. **Merge Commit** (Default)
- Creates a merge commit that preserves the entire history
- Keeps all commits from the source branch
- **Use when**: You want to preserve complete history

```
Before: main ──────○────
                    ╲
        feature ─────○──○──
        
After:  main ──────○─────●  (merge commit)
                    ╲   ╱
        feature ─────○─○
```

### 2. **Squash and Merge**
- Combines all commits into a single commit
- Creates a cleaner history
- **Use when**: PR has many small/experimental commits

```
Before: main ──────○────
        feature ─────○──○──○── (3 commits)
        
After:  main ──────○──●  (1 single commit)
```

### 3. **Rebase and Merge**
- Reapplies commits in linear sequence
- Doesn't create a merge commit
- **Use when**: You want to maintain linear history without merge commits

```
Before: main ──────○────
        feature ─────○──○──
        
After:  main ──────○──○──○  (commits in line)
```

**Recommendation for this project**: Use **"Squash and Merge"** to keep history clean.

---

## Best Practices

### ✅ Before Accepting a PR:

1. **Review the code** in "Files changed"
2. **Check that checks** are all green (✅)
3. **Test locally** if needed:
   ```bash
   git fetch origin
   git checkout -b test-pr-123 origin/branch-name
   npm install
   npm run build
   php artisan migrate
   ```
4. **Read the description** of the PR to understand the changes
5. **Check for conflicts** - If "This branch has conflicts" appears, ask the author to resolve

### ❌ Don't Accept if:

- ❌ Checks are failing (red)
- ❌ There are unresolved merge conflicts
- ❌ Code doesn't follow project standards
- ❌ Missing necessary tests or documentation
- ❌ You don't understand what the code does

### 💬 Communication:

- Use comments to request changes: **"Request changes"**
- Approve good changes: **"Approve"**
- Ask for clarification if you don't understand something

---

## GitHub Glossary

| English Term | Portuguese Meaning |
|--------------|-------------------|
| **Pull Request (PR)** | Solicitação de Pull (code incorporation request) |
| **Merge** | Mesclar/Aceitar (incorporate changes) |
| **Branch** | Ramificação (separate development line) |
| **Commit** | Confirmar (save changes) |
| **Fork** | Bifurcação (repository copy) |
| **Clone** | Clonar (download repository) |
| **Push** | Enviar (send changes to server) |
| **Pull** | Puxar (download changes from server) |
| **Conflict** | Conflito (incompatible changes) |
| **Review** | Revisão (evaluate code) |
| **Approve** | Aprovar (authorize changes) |
| **Request changes** | Solicitar mudanças (ask for modifications) |
| **Comment** | Comentário (add observation) |
| **Files changed** | Arquivos modificados |
| **Conversation** | Conversa/Discussão |
| **Checks** | Verificações (automated tests) |
| **Draft** | Rascunho (PR still in progress) |
| **Ready for review** | Pronto para revisão |
| **Squash** | Comprimir (combine commits) |
| **Rebase** | Reorganizar (reapply commits) |

---

## 🔗 Links Úteis | Useful Links

- [GitHub Docs - About Pull Requests](https://docs.github.com/en/pull-requests/collaborating-with-pull-requests/proposing-changes-to-your-work-with-pull-requests/about-pull-requests)
- [GitHub Docs - Merging a Pull Request](https://docs.github.com/en/pull-requests/collaborating-with-pull-requests/incorporating-changes-from-a-pull-request/merging-a-pull-request)
- [GitHub Docs - Reviewing Changes in Pull Requests](https://docs.github.com/en/pull-requests/collaborating-with-pull-requests/reviewing-changes-in-pull-requests)

---

## 📞 Precisa de Ajuda? | Need Help?

Se você tiver dúvidas sobre um Pull Request específico:
- Comente diretamente no PR
- Peça esclarecimentos ao autor
- Consulte a [documentação oficial do GitHub](https://docs.github.com)

If you have questions about a specific Pull Request:
- Comment directly on the PR
- Ask the author for clarification
- Check the [official GitHub documentation](https://docs.github.com)

---

**✅ Lembre-se**: Não há problema em pedir mudanças ou esclarecimentos antes de aceitar um PR. É melhor revisar com cuidado do que aceitar código problemático!

**✅ Remember**: There's no problem asking for changes or clarifications before accepting a PR. It's better to review carefully than to accept problematic code!
