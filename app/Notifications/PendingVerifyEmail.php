<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PendingVerifyEmail extends Notification
{
    use Queueable;

    public function __construct(
        private string $userName,
        private string $verificationUrl
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Verificação de E-mail - Paróquia São Paulo Apóstolo')
            ->view('emails.verify-email', [
                'userName' => $this->userName,
                'verificationUrl' => $this->verificationUrl,
            ]);
    }
}
