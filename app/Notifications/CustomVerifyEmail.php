<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends VerifyEmailNotification
{
    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verificação de E-mail - Paróquia São Paulo Apóstolo')
            ->view('emails.verify-email', [
                'userName' => $notifiable->name,
                'verificationUrl' => $verificationUrl,
            ]);
    }
}
