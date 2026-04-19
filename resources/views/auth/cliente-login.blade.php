<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AutoRent — Iniciar Sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        }
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        .header { text-align: center; margin-bottom: 28px; }
        .header .logo { font-size: 36px; margin-bottom: 8px; }
        .header h1 { font-size: 22px; font-weight: 700; color: #0f172a; }
        .header p  { font-size: 14px; color: #64748b; margin-top: 4px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 5px; }
        .form-group input {
            width: 100%; padding: 10px 13px; border: 1.5px solid #e5e7eb;
            border-radius: 8px; font-size: 14px; font-family: inherit; transition: border-color 0.15s;
        }
        .form-group input:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,.1); }
        .form-error { font-size: 12px; color: #dc2626; margin-top: 4px; }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 10px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; }
        .btn { width: 100%; padding: 12px; background: #2563eb; color: #fff; border: none; border-radius: 8px; font-size: 15px; font-weight: 700; cursor: pointer; font-family: inherit; transition: background 0.15s; }
        .btn:hover { background: #1d4ed8; }
        .footer-links { text-align: center; margin-top: 18px; font-size: 13px; color: #64748b; }
        .footer-links a { color: #2563eb; text-decoration: none; font-weight: 500; }
        .divider { border: none; border-top: 1px solid #e5e7eb; margin: 20px 0; }
    </style>
</head>
<body>
<div class="card">
    <div class="header">
        <div class="logo">🚗</div>
        <h1>AutoRent</h1>
        <p>Iniciá sesión para hacer tu reserva</p>
    </div>

    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('cliente.login.submit') }}">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                   required autofocus placeholder="tu@email.com">
            @error('email') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="contrasena">Contraseña</label>
            <input type="password" id="contrasena" name="contrasena" required placeholder="••••••••">
            @error('contrasena') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn">Iniciar sesión</button>
    </form>

    <hr class="divider">

    <div class="footer-links">
        ¿No tenés cuenta? <a href="{{ route('cliente.register') }}">Registrate gratis</a>
        <br><br>
        <a href="{{ route('home') }}">← Volver al catálogo</a>
    </div>
</div>
</body>
</html>
