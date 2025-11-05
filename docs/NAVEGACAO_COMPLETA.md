# Sistema de Navegação - Paróquia São Paulo Apóstolo

## Estrutura Completa de Navegação

### 1. Menu Principal (Navbar)

#### Admin Global
- **Dashboard** → `/admin/global/dashboard`
- **Notícias** → `/admin/global/news`
- **Eventos** → `/admin/global/events`
- **Grupos** → `/admin/global/groups`
- **Missas** → `/admin/global/masses`
- **Usuários** → `/admin/global/users`
- **Site Público** → `/` (com detecção de página ativa)

#### Coordenador de Pastoral
- **Dashboard** → `/admin/coordenador/dashboard`
- **Notícias** → `/admin/coordenador/news`
- **Escalas** → `/admin/coordenador/scales`
- **Solicitações** → `/admin/coordenador/requests`
- **Site Público** → `/` (com detecção de página ativa)

#### Administrativo
- **Dashboard** → `/admin/administrativo/dashboard`
- **Notícias** → `/admin/administrativo/news`
- **Missas** → `/admin/administrativo/masses`
- **Site Público** → `/` (com detecção de página ativa)

#### Usuário Padrão
- **Minha Área** → `/user/dashboard`
- **Início** → `/`
- **Grupos** → `/groups`
- **Missas** → `/masses`
- **Eventos** → `/events`
- **Notícias** → `/news`
- **Escalas** → `/user/scales` *(apenas para Coroinhas - parish_group_id = 5)*

#### Não Autenticado
- **Início** → `/`
- **Grupos** → `/groups`
- **Missas** → `/masses`
- **Eventos** → `/events`
- **Notícias** → `/news`

### 2. Dropdown de Usuário

#### Para Todos os Usuários Autenticados
- **Meu Perfil** → `/profile/edit`

#### Admin Global (adicional)
- Dashboard Admin
- Gerenciar Usuários
- Ver Site Público

#### Coordenador de Pastoral (adicional)
- Meu Dashboard
- Solicitações Pendentes
- Minhas Escalas
- Ver Site Público

#### Administrativo (adicional)
- Meu Dashboard
- Gerenciar Notícias
- Gerenciar Missas
- Ver Site Público

#### Usuário Padrão (adicional)
- Minha Área
- Solicitar Entrada em Grupo
- Minhas Solicitações
- Minhas Escalas *(apenas Coroinhas)*

#### Para Todos
- **Sair** (em vermelho)

### 3. Breadcrumbs

Implementados nas páginas públicas:

```blade
<!-- Exemplo de uso -->
<x-breadcrumbs :items="[
    ['label' => 'Notícias', 'icon' => 'newspaper']
]" />

<x-breadcrumbs :items="[
    ['label' => 'Grupos', 'url' => route('groups')],
    ['label' => 'Pastoral da Família', 'icon' => 'people']
]" />
```

**Páginas com Breadcrumbs:**
- `/news` - Notícias
- `/events` - Eventos
- `/groups` - Grupos e Pastorais
- `/masses` - Horários de Missas

### 4. Detecção de Página Ativa

O sistema usa `request()->routeIs()` para destacar a página atual:
- Classe aplicada: `active text-brand-vinho fw-bold`
- Funciona em todas as rotas e subrotas (ex: `admin.global.news.*`)

### 5. Fluxos de Navegação por Role

#### Admin Global
```
Login → Dashboard Admin → [Todas as funcionalidades] ↔ Site Público
                        ↓
                   Dropdown → Perfil / Usuários / Site / Sair
```

#### Coordenador
```
Login → Dashboard → Notícias / Escalas / Solicitações ↔ Site Público
                ↓
          Dropdown → Perfil / Dashboard / Solicitações / Escalas / Site / Sair
```

#### Administrativo
```
Login → Dashboard → Notícias / Missas ↔ Site Público
                ↓
          Dropdown → Perfil / Dashboard / Notícias / Missas / Site / Sair
```

#### Usuário Padrão
```
Login → Minha Área → Site Público (Início/Grupos/Missas/Eventos/Notícias)
                  ↓
    [Se Coroinha] → Escalas
                  ↓
            Dropdown → Perfil / Minha Área / Solicitar Grupo / Solicitações / [Escalas] / Sair
```

#### Visitante
```
Site Público → Início / Grupos / Missas / Eventos / Notícias
            ↓
      Entrar / Cadastrar
```

### 6. Componentes de Navegação

#### Componente Breadcrumbs
**Localização:** `resources/views/components/breadcrumbs.blade.php`
**Classe PHP:** `app/View/Components/Breadcrumbs.php`

**Propriedades:**
- `items` (array): Lista de itens do breadcrumb
- Cada item pode ter: `label`, `url`, `icon`
- Último item sempre sem link (página atual)
- Primeiro item sempre "Início" com link para home

**Exemplo de uso:**
```blade
<x-breadcrumbs :items="[
    ['label' => 'Dashboard', 'url' => route('admin.global.dashboard'), 'icon' => 'speedometer2'],
    ['label' => 'Notícias', 'icon' => 'newspaper']
]" />
```

### 7. Estilos e Ícones

#### Ícones Bootstrap usados:
- `bi-speedometer2` - Dashboard
- `bi-newspaper` - Notícias
- `bi-calendar-event` - Eventos
- `bi-people` - Grupos
- `bi-peace` - Missas
- `bi-calendar3` - Escalas
- `bi-envelope` - Solicitações
- `bi-person-gear` - Usuários
- `bi-globe` - Site Público
- `bi-house-heart` - Minha Área
- `bi-person-circle` - Perfil
- `bi-box-arrow-right` - Sair

#### Classes CSS personalizadas:
- `text-brand-vinho` - Cor principal da marca (vinho)
- `btn-primary-paroquia` - Botão primário estilizado
- `breadcrumb` - Navegação breadcrumb com fundo claro

### 8. Segurança e Validações

- Todos os menus verificam `@auth` antes de mostrar conteúdo
- Roles são validados com `Auth::user()->role->value`
- Escalas de Coroinhas verificam `parish_group_id == 5`
- Dropdown sempre mostra opções contextuais ao role
- Links "Site Público" detectam se está em página pública

### 9. Responsividade

- Menu colapsa em mobile com `navbar-toggler`
- Dropdown alinha à direita com `dropdown-menu-end`
- Breadcrumbs são responsivos (wrap automático)
- Todos os links têm área de toque adequada

## Páginas do Sistema

### Públicas (não requerem autenticação)
- `/` - Home
- `/groups` - Grupos e Pastorais
- `/masses` - Horários de Missas
- `/events` - Eventos
- `/news` - Notícias
- `/login` - Login
- `/register` - Cadastro

### Usuário Padrão
- `/user/dashboard` - Minha Área
- `/user/scales` - Escalas (apenas Coroinhas)
- `/group-requests/create` - Solicitar Entrada
- `/group-requests` - Minhas Solicitações
- `/profile/edit` - Editar Perfil

### Coordenador
- `/admin/coordenador/dashboard` - Dashboard
- `/admin/coordenador/news` - Notícias
- `/admin/coordenador/scales` - Escalas
- `/admin/coordenador/requests` - Solicitações

### Administrativo
- `/admin/administrativo/dashboard` - Dashboard
- `/admin/administrativo/news` - Notícias
- `/admin/administrativo/masses` - Missas

### Admin Global
- `/admin/global/dashboard` - Dashboard
- `/admin/global/news` - Notícias
- `/admin/global/events` - Eventos
- `/admin/global/groups` - Grupos
- `/admin/global/masses` - Missas
- `/admin/global/users` - Usuários

## Melhorias Implementadas

✅ Menu contextual por role com ícones
✅ Detecção de página ativa em todos os níveis
✅ Dropdown organizado com separadores
✅ Link "Site Público" para admins voltarem ao site
✅ Breadcrumbs em páginas públicas
✅ Componente reutilizável de breadcrumbs
✅ Menu de Escalas condicional para Coroinhas
✅ Botão "Sair" destacado em vermelho
✅ Ícones consistentes em toda navegação
✅ Responsividade completa
✅ Cache limpo após mudanças

## Como Usar

### Adicionar nova página com breadcrumb:
```blade
<div class="container mt-4">
    <x-breadcrumbs :items="[
        ['label' => 'Categoria', 'url' => route('categoria.index')],
        ['label' => 'Subcategoria', 'icon' => 'icone-bootstrap']
    ]" />
</div>
```

### Verificar página ativa no menu:
```blade
<a class="nav-link {{ request()->routeIs('rota.*') ? 'active text-brand-vinho fw-bold' : '' }}" 
   href="{{ route('rota.index') }}">
    Nome
</a>
```

### Adicionar item ao dropdown:
```blade
<li>
    <a class="dropdown-item" href="{{ route('rota') }}">
        <i class="bi bi-icone"></i> Texto
    </a>
</li>
```
