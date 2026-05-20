<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar correo — Super Patas y Colas</title>
</head>
<body style="margin: 0; padding: 0; background-color: #FFF5EE; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #FFF5EE; padding: 40px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="560" cellpadding="0" cellspacing="0"
                       style="max-width: 560px; width: 100%; background-color: #ffffff; border-radius: 12px;
                              overflow: hidden; box-shadow: 0 4px 16px rgba(40,30,20,.08);">
                    <tr>
                        <td style="background: #E8531E; padding: 22px 28px; color: #ffffff;">
                            <h1 style="margin: 0; font-size: 1.3rem;">Super Patas y Colas</h1>
                            <p style="margin: 4px 0 0; font-size: .85rem; letter-spacing: .08em; text-transform: uppercase; opacity: .9;">
                                Albergue de animales · SMP, Lima
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 32px 28px;">
                            <h2 style="margin: 0 0 16px; font-size: 1.1rem; color: #343A40;">¡Hola, {{ $userName }}!</h2>
                            <p style="margin: 0 0 24px; font-size: 15px; line-height: 1.6; color: #52525b;">
                                Gracias por registrarte en Super Patas y Colas. Para activar tu cuenta, haz clic en el siguiente botón:
                            </p>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding: 4px 0 28px 0;">
                                        <a href="{!! $verificationUrl !!}" target="_blank"
                                           style="display: inline-block; background-color: #E8531E; color: #ffffff;
                                                  text-decoration: none; font-size: 15px; font-weight: bold;
                                                  padding: 14px 32px; border-radius: 8px;">
                                            Verificar correo electrónico
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin: 0 0 8px; font-size: 13px; line-height: 1.6; color: #52525b;">
                                Este enlace expirará en 60 minutos.
                            </p>
                            <p style="margin: 0 0 24px; font-size: 13px; line-height: 1.6; color: #52525b;">
                                Si no creaste una cuenta en nuestro sitio, puedes ignorar este mensaje.
                            </p>
                            <hr style="border: none; border-top: 1px solid #e4e4e7; margin: 0 0 20px 0;">
                            <p style="margin: 0 0 4px; font-size: 11px; line-height: 1.5; color: #a1a1aa;">
                                Si el botón no funciona, copia y pega esta dirección en tu navegador:
                            </p>
                            {{-- {!! !!} es seguro aquí: la URL la genera Laravel internamente, no viene de input de usuario --}}
                            <p style="margin: 0; font-size: 11px; line-height: 1.5; color: #a1a1aa; word-break: break-all;">
                                {!! $verificationUrl !!}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background: #343A40; color: #aea598; padding: 16px 28px; font-size: .78rem; text-align: center;">
                            © 2026 Super Patas y Colas · San Martín de Porres, Lima, Perú
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
