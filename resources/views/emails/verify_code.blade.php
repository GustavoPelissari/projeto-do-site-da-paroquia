<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Código de verificação</title>
</head>
<body style="font-family: Arial, sans-serif; color:#111;">
    <h2>Olá, {{ $user->name }}!</h2>
    <p>Seu código de verificação de e-mail é:</p>
    <p style="font-size:24px; font-weight:bold; letter-spacing:4px;">{{ $code }}</p>
    <p>Ele expira em {{ $expiresMinutes }} minutos.</p>
    <p>Se você não solicitou este código, ignore este e-mail.</p>
    <hr>
    <p style="font-size:12px; color:#666;">Paróquia — verificação de e-mail</p>
</body>
</html>
