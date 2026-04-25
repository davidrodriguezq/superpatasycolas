<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensaje de contacto — Super Patas y Colas</title>
</head>
<body style="font-family: Arial, sans-serif; color: #343A40; background: #f9f9f9; padding: 24px;">
    <div style="max-width: 560px; margin: 0 auto; background: #fff; border-radius: 10px; padding: 32px; border: 1px solid #e7e3de;">
        <div style="margin-bottom: 24px; border-bottom: 3px solid #E8531E; padding-bottom: 16px;">
            <span style="font-weight: 700; font-size: 1.1rem; color: #E8531E;">Super Patas y Colas</span>
            <p style="margin: 4px 0 0; font-size: .85rem; color: #8a7f72;">Nuevo mensaje desde el formulario de contacto web</p>
        </div>

        <table style="width: 100%; font-size: .92rem; margin-bottom: 20px;">
            <tr>
                <td style="width: 90px; color: #8a7f72; padding: 6px 0; vertical-align: top;">Nombre:</td>
                <td style="font-weight: 600; padding: 6px 0;">{{ $data['name'] }}</td>
            </tr>
            <tr>
                <td style="color: #8a7f72; padding: 6px 0; vertical-align: top;">Correo:</td>
                <td style="font-weight: 600; padding: 6px 0;">{{ $data['email'] }}</td>
            </tr>
            <tr>
                <td style="color: #8a7f72; padding: 6px 0; vertical-align: top;">Asunto:</td>
                <td style="font-weight: 600; padding: 6px 0;">{{ $data['subject'] }}</td>
            </tr>
        </table>

        <div style="background: #FFF5EE; border-left: 3px solid #E8531E; padding: 16px; border-radius: 6px; font-size: .92rem; line-height: 1.6; white-space: pre-line;">{{ $data['message'] }}</div>

        <p style="margin-top: 24px; font-size: .8rem; color: #b5a999; text-align: center;">
            Este mensaje fue enviado desde el formulario de contacto de
            <a href="https://superpatasycolas.azurewebsites.net" style="color: #E8531E;">superpatasycolas.azurewebsites.net</a>
        </p>
    </div>
</body>
</html>
