# Guia da logo transparente

Para manter a logo sem fundo branco em todo o sistema, siga este padrão:

1. Salve a versão transparente da logo em:
   `public/images/sao-paulo-logo-transparent.png`
2. Formatos recomendados: **PNG transparente** ou **SVG**.
3. O componente `<x-parish-logo />` usa automaticamente esta ordem de fallback:
   - `images/sao-paulo-logo-transparent.png` (prioritário)
   - `images/sao-paulo-apostolo.svg`
   - `images/sao-paulo-logo.png` (legado)

## Onde a logo é usada
- Navbar pública
- Rodapé público
- Layout de autenticação
- Navbar interna de usuários
- Sidebar administrativa

> Se você trocar apenas o arquivo `sao-paulo-logo-transparent.png`, o sistema inteiro atualiza sem alterar views/CSS.
