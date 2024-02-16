<!DOCTYPE html>
<html>
<head>
    <title>Activación de cuenta</title>
</head>
<body>
    <p>Hola {{ $userName }},</p>
    <p>Gracias por registrarte. Para activar tu cuenta, haz clic en el siguiente enlace:</p>
    <a href="{{ $activationLink }}">Activar cuenta</a>
</body>
</html>
