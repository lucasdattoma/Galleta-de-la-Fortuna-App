<!DOCTYPE html>
<html>
<head>
    <title>Registro - Fortune Cookie</title>
    <style>
        body {
            font-family: Arial;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url("{{ asset('imagenes/Background_inicio.jpg') }}") center/cover no-repeat;
        }
        .form-container {
            background: #3A2C0F;
            color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 300px;
        }
        h2 { text-align: center; }
        input { width: 100%; padding: 10px; margin: 10px 0; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #C8A44B; color: #000000; border: none; cursor: pointer; }
        button:hover { background: #E5BF5A; }
        .error { color: red; }
        .link { text-align: center; margin-top: 10px; }
        a { color: #31a5e3; text-decoration: none;}
        a:hover {background: #E5BF5A;}

    </style>
</head>
<body>
<div class="form-container">
    <h2>Registrarse</h2>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/register">
        @csrf
        <input type="text" name="name" placeholder="Nombre" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <input type="password" name="password_confirmation" placeholder="Confirmar Contraseña" required>
        <button type="submit">Registrarse</button>
    </form>

    <div class="link">
        ¿Ya tienes cuenta? <a href="/login">Inicia sesión aquí</a>
    </div>
</div>
</body>
</html>
