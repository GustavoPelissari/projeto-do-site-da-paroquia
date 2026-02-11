# 🎨 GUIA DE COMPONENTES - SISTEMA DE DESIGN

## Botões

### Primário (Vinho)
```html
<button type="button" class="btn btn-primary">
    <i class="bi bi-check-circle" aria-hidden="true"></i> Salvar
</button>
```

### Outline Primário
```html
<button type="button" class="btn btn-outline-primary">
    <i class="bi bi-eye" aria-hidden="true"></i> Visualizar
</button>
```

### Warning (Dourado)
```html
<button type="button" class="btn btn-warning">
    <i class="bi bi-exclamation-triangle" aria-hidden="true"></i> Atenção
</button>
```

### Danger
```html
<button type="button" class="btn btn-danger">
    <i class="bi bi-trash" aria-hidden="true"></i> Excluir
</button>
```

### Success
```html
<button type="button" class="btn btn-success">
    <i class="bi bi-check" aria-hidden="true"></i> Aprovar
</button>
```

### Secondary
```html
<button type="button" class="btn btn-secondary">
    <i class="bi bi-x" aria-hidden="true"></i> Cancelar
</button>
```

### Desabilitado
```html
<button type="button" class="btn btn-primary" disabled>
    Não disponível
</button>
```

### Com Loading
```html
<button type="button" class="btn btn-primary loading">
    Salvando...
</button>
```

### Tamanhos
```html
<button class="btn btn-primary btn-sm">Pequeno</button>
<button class="btn btn-primary">Normal</button>
<button class="btn btn-primary btn-lg">Grande</button>
```

---

## Inputs

### Input Básico
```html
<div class="mb-3">
    <label for="nome" class="form-label">Nome</label>
    <input type="text" class="form-control" id="nome" placeholder="Digite seu nome">
    <div class="form-text">Insira seu nome completo</div>
</div>
```

### Input Obrigatório
```html
<div class="mb-3">
    <label for="email" class="form-label required">E-mail</label>
    <input type="email" class="form-control" id="email" required>
</div>
```

### Input com Erro
```html
<div class="mb-3">
    <label for="senha" class="form-label">Senha</label>
    <input type="password" class="form-control is-invalid" id="senha">
    <div class="invalid-feedback">
        A senha deve ter no mínimo 8 caracteres
    </div>
</div>
```

### Input com Sucesso
```html
<div class="mb-3">
    <label for="cpf" class="form-label">CPF</label>
    <input type="text" class="form-control is-valid" id="cpf" value="123.456.789-00">
    <div class="valid-feedback">
        CPF válido
    </div>
</div>
```

### Input Desabilitado
```html
<div class="mb-3">
    <label for="codigo" class="form-label">Código</label>
    <input type="text" class="form-control" id="codigo" value="ABC123" disabled>
</div>
```

### Textarea
```html
<div class="mb-3">
    <label for="mensagem" class="form-label">Mensagem</label>
    <textarea class="form-control" id="mensagem" rows="4"></textarea>
</div>
```

### Select
```html
<div class="mb-3">
    <label for="estado" class="form-label">Estado</label>
    <select class="form-select" id="estado">
        <option selected>Selecione...</option>
        <option value="PR">Paraná</option>
        <option value="SP">São Paulo</option>
    </select>
</div>
```

### Checkbox
```html
<div class="form-check">
    <input class="form-check-input" type="checkbox" id="termos">
    <label class="form-check-label" for="termos">
        Aceito os termos e condições
    </label>
</div>
```

### Radio
```html
<div class="form-check">
    <input class="form-check-input" type="radio" name="genero" id="masculino" value="M">
    <label class="form-check-label" for="masculino">
        Masculino
    </label>
</div>
<div class="form-check">
    <input class="form-check-input" type="radio" name="genero" id="feminino" value="F">
    <label class="form-check-label" for="feminino">
        Feminino
    </label>
</div>
```

### Input Group
```html
<div class="mb-3">
    <label for="valor" class="form-label">Valor</label>
    <div class="input-group">
        <span class="input-group-text">R$</span>
        <input type="text" class="form-control" id="valor" placeholder="0,00">
    </div>
</div>
```

### File Upload
```html
<div class="mb-3">
    <label for="arquivo" class="form-label">Arquivo</label>
    <input class="form-control" type="file" id="arquivo">
</div>
```

---

## Cards

### Card Básico
```html
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Título do Card</h5>
        <p class="card-text">Conteúdo do card</p>
    </div>
</div>
```

### Card com Header
```html
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Header</h5>
    </div>
    <div class="card-body">
        <p class="card-text">Conteúdo</p>
    </div>
</div>
```

### Card Paróquia (Premium)
```html
<div class="card-paroquia">
    <img src="imagem.jpg" class="card-img-top" alt="Descrição">
    <div class="card-body">
        <h5 class="card-title">Título</h5>
        <p class="card-text">Descrição</p>
        <a href="#" class="btn btn-primary">Ver mais</a>
    </div>
</div>
```

---

## Alerts

### Sucesso
```html
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle-fill me-2" aria-hidden="true"></i>
    Operação realizada com sucesso!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
</div>
```

### Erro
```html
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2" aria-hidden="true"></i>
    Ocorreu um erro ao processar sua solicitação.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
</div>
```

### Aviso
```html
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-circle-fill me-2" aria-hidden="true"></i>
    Atenção: esta ação não pode ser desfeita.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
</div>
```

### Info
```html
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <i class="bi bi-info-circle-fill me-2" aria-hidden="true"></i>
    Mantenha seus dados atualizados.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
</div>
```

---

## Badges

### Padrão
```html
<span class="badge bg-primary">Novo</span>
<span class="badge bg-secondary">Processando</span>
<span class="badge bg-success">Ativo</span>
<span class="badge bg-danger">Cancelado</span>
<span class="badge bg-warning text-dark">Pendente</span>
<span class="badge bg-info text-dark">Info</span>
```

---

## Modal

```html
<!-- Botão que abre modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#meuModal">
    Abrir Modal
</button>

<!-- Modal -->
<div class="modal fade" id="meuModal" tabindex="-1" aria-labelledby="meuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="meuModalLabel">Título do Modal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                Conteúdo do modal aqui...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>
```

---

## Classes Utilitárias

### Cores de Texto
```html
<p class="text-vinho">Texto vinho</p>
<p class="text-dourado">Texto dourado</p>
<p class="text-muted">Texto secundário</p>
```

### Backgrounds
```html
<div class="bg-vinho">Fundo vinho</div>
<div class="bg-rose">Fundo rose</div>
<div class="bg-gradiente-vinho">Gradiente vinho</div>
```

### Sombras
```html
<div class="shadow-suave">Sombra suave</div>
<div class="shadow-media">Sombra média</div>
<div class="shadow-forte">Sombra forte</div>
```

### Tipografia
```html
<p class="font-titulo">Fonte display (Playfair)</p>
<p class="font-corpo">Fonte corpo (Poppins)</p>
<p class="fw-light">Peso leve</p>
<p class="fw-semibold">Peso semi-bold</p>
<p class="fw-bold">Peso bold</p>
```

### Acessibilidade
```html
<!-- Texto apenas para leitores de tela -->
<span class="visually-hidden">Informação oculta</span>

<!-- Skip navigation -->
<a href="#main-content" class="skip-to-content">
    Pular para o conteúdo principal
</a>
```

---

## Ícones Bootstrap

### Em Botões
```html
<button class="btn btn-primary">
    <i class="bi bi-save" aria-hidden="true"></i> Salvar
</button>
```

### Standalone (com aria-label)
```html
<i class="bi bi-info-circle" aria-label="Informação"></i>
```

### Em Alertas
```html
<div class="alert alert-success">
    <i class="bi bi-check-circle-fill me-2" aria-hidden="true"></i>
    Sucesso!
</div>
```

---

## Navegação

### Nav Tabs
```html
<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab1">
            Tab 1
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab2">
            Tab 2
        </button>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active" id="tab1">Conteúdo 1</div>
    <div class="tab-pane fade" id="tab2">Conteúdo 2</div>
</div>
```

---

## Formulário Completo (Exemplo)

```html
<form>
    <div class="mb-3">
        <label for="nome" class="form-label required">Nome Completo</label>
        <input type="text" class="form-control" id="nome" required>
    </div>
    
    <div class="mb-3">
        <label for="email" class="form-label required">E-mail</label>
        <input type="email" class="form-control" id="email" required>
        <div class="form-text">Nunca compartilharemos seu e-mail.</div>
    </div>
    
    <div class="mb-3">
        <label for="telefone" class="form-label">Telefone</label>
        <input type="tel" class="form-control" id="telefone" placeholder="(00) 00000-0000">
    </div>
    
    <div class="mb-3">
        <label for="mensagem" class="form-label required">Mensagem</label>
        <textarea class="form-control" id="mensagem" rows="4" required></textarea>
    </div>
    
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="termos" required>
        <label class="form-check-label" for="termos">
            Aceito os termos e condições
        </label>
    </div>
    
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-send" aria-hidden="true"></i> Enviar
    </button>
    <button type="reset" class="btn btn-secondary">
        <i class="bi bi-x" aria-hidden="true"></i> Limpar
    </button>
</form>
```

---

## Boas Práticas

### ✅ SEMPRE fazer:
- Use `aria-hidden="true"` em ícones decorativos dentro de botões/links com texto
- Use `aria-label` em ícones standalone sem texto
- Sempre inclua `<label>` para inputs (nunca apenas placeholder)
- Use `.form-label.required` para campos obrigatórios
- Adicione `.form-text` para instruções de preenchimento
- Use estados `.is-invalid` e `.is-valid` com feedback visual

### ❌ NUNCA fazer:
- Usar apenas placeholder sem label
- Esquecer `aria-hidden` em ícones decorativos
- Usar cores sem contraste suficiente (mínimo 4.5:1)
- Desabilitar outline de foco sem alternativa
- Usar apenas cor para indicar estado (sempre adicione texto/ícone)

---

**Última atualização:** 10/02/2026
