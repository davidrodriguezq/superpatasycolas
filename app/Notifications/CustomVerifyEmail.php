<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends VerifyEmail
{
    protected function buildMailMessage($url): MailMessage
    {
        return (new MailMessage)
            ->subject('Verifica tu correo — Super Patas y Colas')
            ->greeting('¡Hola!')
            ->line('Gracias por registrarte en Super Patas y Colas. Para activar tu cuenta, haz clic en el siguiente botón:')
            ->action('Verificar correo electrónico', $url)
            ->line('Este enlace expirará en 60 minutos.')
            ->line('Si no creaste una cuenta en nuestro sitio, puedes ignorar este mensaje.')
            ->salutation('— Equipo Super Patas y Colas');
    }
}
