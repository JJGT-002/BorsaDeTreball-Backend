<!DOCTYPE html>
<html>
<head>
    <title>Activación de cuenta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        p {
            margin-bottom: 10px;
        }
        .activation-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .activation-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Hola {{ $userName }},</h1>
    <p>Gracias por registrarte. Estos son tus datos de registro:</p>
    <ul>
        <li>Email: {{ $user->email }}</li>
        <li>Dirección: {{ $user->address }}</li>
        <li>Rol: {{ $user->role }}</li>
        <li>Nombre: {{ $userName }}</li>
        @if($user->role !== 'admin' && $user->role !== 'responsible')
            <ul>
                @if($user->role === 'student')
                    <li>Apellidos: {{ $user->Student->surnames }}</li>
                    <li>CV: {{ $user->Student->urlCV }}</li>
                @elseif($user->role === 'company')
                    <li>CIF: {{ $user->Company->cif }}</li>
                    <li>Nombre de contacto: {{ $user->Company->contactName }}</li>
                    <li>Web de la compañía: {{ $user->Company->companyWeb ?? 'No se ha agregado ninguna web de la compañía' }}</li>
                @endif
            </ul>
        @endif

    </ul>
    <p>Para activar tu cuenta, haz clic en el siguiente enlace:</p>
    <a class="activation-link" href="{{ $activationLink }}">Activar cuenta</a>
</div>
</body>
</html>
