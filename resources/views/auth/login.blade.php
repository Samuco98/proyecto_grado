<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Veterinaria J&C</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #007bff, #6f42c1);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            width: 400px;
            padding: 30px;
        }
        .login-card img {
            width: 100px;
            display: block;
            margin: 0 auto 15px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <img src="{{ asset('images/logo2.png') }}" alt="Veterinaria J&C">

        <h4 class="text-center text-primary mb-3">Iniciar Sesión</h4>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input id="password" type="password" name="password" required class="form-control">
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">Ingresar</button>

            <p class="text-center text-muted mb-0">
                © 2025 Veterinaria J&C<br>
                <small>Todos los derechos reservados</small>
            </p>
        </form>
    </div>
</body>
</html>
