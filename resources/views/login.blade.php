<!DOCTYPE html>
<html>
<head>
    <title>Login - Fortune Cookie</title>
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
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 300px;
            color: white;
        }
        h2 { text-align: center; }
        input { width: 100%; padding: 10px; margin: 10px 0; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #C8A44B; color: #000000; border: none; cursor: pointer; }
        button:hover { background: #E5BF5A; }
        .error { color: red; }
        .link { text-align: center; margin-top: 10px; }
        a { color: #31a5e3; text-decoration: none; }
        a:hover {background: #E5BF5A;}
    </style>
</head>
<body>
<div class="form-container">
    <h2>Iniciar Sesión</h2>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Iniciar Sesión</button>
    </form>

    <div class="link">
        ¿No tienes cuenta? <a href="/register">Regístrate aquí</a>
    </div>
</div>
</body>
</html>
