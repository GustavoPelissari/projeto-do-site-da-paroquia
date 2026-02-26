<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinição de Senha</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f7f3f4; margin: 0; padding: 0; }
        .email-container { max-width: 640px; margin: 24px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        .header { display: flex; align-items: center; gap: 12px; padding: 20px 24px; background: #fff5f7; border-bottom: 1px solid #f0d9de; }
        .header img { height: 40px; }
        .header .title { font-weight: 700; color: #7a0f2d; }
        .subtitle { font-size: 12px; color: #7a0f2d; opacity: 0.8; }
        .content { padding: 24px; color: #333; }
        .content h1 { font-size: 22px; margin: 0 0 12px; color: #7a0f2d; }
        .content p { margin: 0 0 12px; line-height: 1.6; }
        .button { display: inline-block; background: #0d6efd; color: #fff; text-decoration: none; padding: 12px 18px; border-radius: 8px; font-weight: 600; }
        .note { font-size: 12px; color: #666; margin-top: 14px; }
        .footer { padding: 16px 24px; background: #fafafa; border-top: 1px solid #eee; font-size: 12px; color: #666; text-align: center; }
        .link { word-break: break-all; color: #0d6efd; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="{{ asset('images/sao-paulo-logo.png') }}" alt="Paróquia São Paulo Apóstolo">
            <div>
                <div class="title">Paróquia São Paulo Apóstolo</div>
                <div class="subtitle">Diocese de Umuarama</div>
            </div>
        </div>
        <div class="content">
            <h1>Redefinição de Senha</h1>
            <p>Olá, {{ $userName }}.</p>
            <p>Recebemos uma solicitação para redefinir a sua senha. Para continuar, clique no botão abaixo:</p>
            <p>
                <a class="button" href="{{ $resetUrl }}" target="_blank" rel="noopener">Redefinir minha senha</a>
            </p>
            <p class="note">Se você não solicitou esta alteração, pode ignorar este e‑mail. O link expira em tempo determinado por segurança.</p>
            <p class="note">Caso o botão não funcione, copie e cole este link no navegador:</p>
            <p class="link">{{ $resetUrl }}</p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} Paróquia São Paulo Apóstolo — "Graça e paz da parte de Deus nosso Pai e do Senhor Jesus Cristo" (Ef 1:2)</p>
        </div>
    </div>
</body>
</html>
