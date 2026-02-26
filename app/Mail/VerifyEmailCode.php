<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmailCode extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $code,
        public int $expiresMinutes
    ) {}

    public function build(): self
    {
        return $this->subject('Seu código de verificação')
            ->view('emails.verify_code')
            ->with([
                'user' => $this->user,
                'code' => $this->code,
                'expiresMinutes' => $this->expiresMinutes,
            ]);
    }
}
