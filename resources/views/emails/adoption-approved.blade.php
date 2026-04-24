<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¡Adopción aprobada!</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, Helvetica, sans-serif; background:#FFF5EE; color:#2a2622;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#FFF5EE; padding: 32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0"
                       style="max-width:600px; width:100%; background:#ffffff; border-radius:12px; overflow:hidden;
                              box-shadow:0 4px 16px rgba(40,30,20,.08);">
                    <tr>
                        <td style="background:#E8531E; padding: 22px 28px; color:#ffffff;">
                            <h1 style="margin:0; font-size:1.3rem;">Super Patas y Colas</h1>
                            <p style="margin:4px 0 0; font-size:.85rem; letter-spacing:.08em; text-transform:uppercase; opacity:.9;">
                                Albergue · SMP, Lima
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 28px;">
                            <h2 style="margin:0 0 16px; font-size:1.2rem; color:#1b7a33;">
                                ¡Tu solicitud de adopción ha sido aprobada!
                            </h2>

                            <p style="margin:0 0 14px; line-height:1.55;">
                                Hola <strong>{{ $user->name }}</strong>,
                            </p>
                            <p style="margin:0 0 14px; line-height:1.55;">
                                ¡Excelentes noticias! Tu solicitud de adopción para
                                <strong>{{ $animal->name }}</strong> ha sido aprobada por nuestro equipo.
                                Estamos muy felices de que {{ $animal->name }} tenga un nuevo hogar contigo.
                            </p>

                            <div style="background:#FFF5EE; border-left:4px solid #E8531E; border-radius:8px;
                                        padding:14px 18px; margin:20px 0; font-size:.92rem;">
                                <p style="margin:0 0 6px;"><strong>Código de seguimiento:</strong>
                                    <span style="font-family: ui-monospace, Menlo, monospace;">{{ $adoptionRequest->tracking_code }}</span>
                                </p>
                                <p style="margin:0;"><strong>Animal:</strong> {{ $animal->name }} ({{ $animal->species->label() }})</p>
                            </div>

                            <h3 style="margin:20px 0 10px; font-size:1rem;">Próximos pasos</h3>
                            <p style="margin:0 0 12px; line-height:1.55;">
                                En los próximos días, un miembro del equipo del albergue te contactará al correo o teléfono
                                que registraste para coordinar la entrega de {{ $animal->name }} y explicarte los detalles
                                del proceso final de adopción responsable.
                            </p>
                            <p style="margin:0 0 12px; line-height:1.55;">
                                Si tienes alguna consulta previa, puedes responder a este correo o escribirnos a
                                <a href="mailto:contacto@superpatasycolas.pe" style="color:#E8531E;">contacto@superpatasycolas.pe</a>.
                            </p>

                            <p style="margin:24px 0 0; line-height:1.55;">
                                Gracias por elegir la adopción responsable.<br>
                                <strong>Equipo Super Patas y Colas</strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#343A40; color:#aea598; padding:16px 28px; font-size:.78rem; text-align:center;">
                            Av. Los Rescatados 1234, San Martín de Porres, Lima · +51 999 000 000
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
