<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends VerifyEmail
{
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verifica tu correo — Super Patas y Colas')
            ->view('emails.verify-email', [
                'verificationUrl' => $verificationUrl,
                'userName'        => $notifiable->name,
            ]);
    }
}
