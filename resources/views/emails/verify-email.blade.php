<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de E-mail - Paróquia São Paulo Apóstolo</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .header {
            background: linear-gradient(135deg, #8B1538 0%, #6B0F2A 100%);
            padding: 40px 20px;
            text-align: center;
        }
        .header img {
            max-width: 80px;
            height: auto;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #ffffff;
            font-size: 24px;
            margin: 0;
            font-weight: 600;
        }
        .header p {
            color: #FFD66B;
            font-size: 14px;
            margin: 10px 0 0;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 20px;
            color: #333333;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .message {
            font-size: 16px;
            color: #555555;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .button-container {
            text-align: center;
            margin: 40px 0;
        }
        .button {
            display: inline-block;
            padding: 16px 40px;
            background: linear-gradient(135deg, #8B1538 0%, #6B0F2A 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(139, 21, 56, 0.3);
            transition: all 0.3s ease;
        }
        .button:hover {
            box-shadow: 0 6px 16px rgba(139, 21, 56, 0.4);
            transform: translateY(-2px);
        }
        .info-box {
            background-color: #FFF9E6;
            border-left: 4px solid #FFD66B;
            padding: 15px 20px;
            margin: 30px 0;
            border-radius: 4px;
        }
        .info-box p {
            margin: 0;
            font-size: 14px;
            color: #666666;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #eeeeee;
        }
        .footer p {
            margin: 5px 0;
            font-size: 14px;
            color: #888888;
        }
        .footer .verse {
            font-style: italic;
            color: #8B1538;
            margin-top: 15px;
            font-size: 13px;
        }
        .divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, #FFD66B, transparent);
            margin: 30px 0;
        }
        @media only screen and (max-width: 600px) {
            .content {
                padding: 30px 20px;
            }
            .header h1 {
                font-size: 20px;
            }
            .button {
                padding: 14px 30px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🕊️ Paróquia São Paulo Apóstolo</h1>
            <p>Diocese de Umuarama</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">Olá, {{ $userName }}! 👋</div>
            
            <p class="message">
                Seja muito bem-vindo(a) à nossa comunidade de fé! Estamos felizes em tê-lo(a) conosco.
            </p>

            <p class="message">
                Para completar seu cadastro e começar a participar ativamente da vida paroquial, 
                precisamos que você verifique seu endereço de e-mail clicando no botão abaixo:
            </p>

            <div class="button-container">
                <a href="{{ $verificationUrl }}" class="button">
                    ✓ Verificar Meu E-mail
                </a>
            </div>

            <div class="divider"></div>

            <div class="info-box">
                <p><strong>⏰ Importante:</strong> Este link expira em 60 minutos por questões de segurança.</p>
            </div>

            <p class="message" style="font-size: 14px; color: #888888;">
                Se você não criou esta conta, pode ignorar este e-mail com segurança.
            </p>

            <p class="message" style="font-size: 13px; color: #999999; margin-top: 30px;">
                <strong>Problemas com o botão?</strong> Copie e cole este link no seu navegador:<br>
                <span style="color: #8B1538; word-break: break-all;">{{ $verificationUrl }}</span>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Paróquia São Paulo Apóstolo</strong></p>
            <p>Uma comunidade de fé inspirada no exemplo missionário de São Paulo</p>
            <p class="verse">"Combati o bom combate, terminei a corrida, guardei a fé." - 2 Timóteo 4:7</p>
            <p style="margin-top: 20px; font-size: 12px;">
                © {{ date('Y') }} Paróquia São Paulo Apóstolo. Todos os direitos reservados.
            </p>
        </div>
    </div>
</body>
</html>
