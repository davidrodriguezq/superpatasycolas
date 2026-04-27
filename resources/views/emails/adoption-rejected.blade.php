<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualización sobre tu solicitud de adopción</title>
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
                            <h2 style="margin:0 0 16px; font-size:1.2rem; color:#2a2622;">
                                Actualización sobre tu solicitud de adopción
                            </h2>

                            <p style="margin:0 0 14px; line-height:1.55;">
                                Hola <strong>{{ $user->name }}</strong>,
                            </p>
                            <p style="margin:0 0 14px; line-height:1.55;">
                                Gracias por el interés que mostraste en adoptar a
                                <strong>{{ $animal->name }}</strong>. Queremos informarte que, luego de revisar tu solicitud,
                                nuestro equipo ha decidido no proceder con la adopción en esta oportunidad.
                            </p>

                            <div style="background:#FFF5EE; border-left:4px solid #E8531E; border-radius:8px;
                                        padding:14px 18px; margin:20px 0; font-size:.92rem;">
                                <p style="margin:0 0 6px;"><strong>Código de seguimiento:</strong>
                                    <span style="font-family: ui-monospace, Menlo, monospace;">{{ $adoptionRequest->tracking_code }}</span>
                                </p>
                                <p style="margin:0;"><strong>Animal:</strong> {{ $animal->name }} ({{ $animal->species->label() }})</p>
                            </div>

                            <p style="margin:0 0 12px; line-height:1.55;">
                                Esta decisión no significa que no seas un buen candidato para adoptar. Cada caso se evalúa
                                considerando las necesidades específicas del animal y el entorno que ofrece cada hogar.
                            </p>
                            <p style="margin:0 0 12px; line-height:1.55;">
                                Te invitamos a seguir explorando nuestro catálogo de mascotas; hay muchos animales buscando
                                un hogar como el tuyo.
                            </p>

                            <p style="margin:24px 0 0; line-height:1.55;">
                                <a href="{{ url('/catalogo') }}"
                                   style="display:inline-block; background:#E8531E; color:#ffffff; text-decoration:none;
                                          padding: 10px 20px; border-radius:8px; font-weight:600;">
                                    Explorar catálogo
                                </a>
                            </p>

                            <p style="margin:24px 0 0; line-height:1.55;">
                                Gracias nuevamente por tu interés.<br>
                                <strong>Equipo Super Patas y Colas</strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#343A40; color:#aea598; padding:16px 28px; font-size:.78rem; text-align:center;">
                            San Martín de Porres, Lima, Perú · +51 999 000 000
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
