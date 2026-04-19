<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'AutoRent — Acceso Administrador' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #1e3a5f 100%);
        }
        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }
        .login-card {
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.35);
        }
        .login-header { text-align: center; margin-bottom: 32px; }
        .login-header .logo { font-size: 40px; margin-bottom: 8px; }
        .login-header h1 { font-size: 22px; font-weight: 700; color: #0f172a; }
        .login-header p  { font-size: 14px; color: #64748b; margin-top: 4px; }
        .badge-admin {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            margin-top: 6px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .form-group { margin-bottom: 18px; }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }
        .form-group input {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
        }
        .form-error { font-size: 12px; color: #dc2626; margin-top: 4px; }
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 18px;
        }
        .form-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 13px;
        }
        .form-row label { display: flex; gap: 6px; align-items: center; color: #475569; cursor: pointer; }
        .btn-submit {
            width: 100%;
            padding: 13px;
            background: #1e293b;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            font-family: inherit;
            transition: background 0.15s, transform 0.1s;
        }
        .btn-submit:hover { background: #0f172a; transform: translateY(-1px); }
        .login-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #94a3b8;
        }
        .login-footer a { color: #2563eb; text-decoration: none; }
    </style>
</head>
<body>
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <div class="logo">🔐</div>
            <h1>AutoRent</h1>
            <p>Panel de Administración</p>
            <span class="badge-admin">Acceso Restringido</span>
        </div>

        {{-- Error de sesión --}}
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="admin@autorent.com"
                >
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="contrasena">Contraseña</label>
                <input
                    type="password"
                    id="contrasena"
                    name="contrasena"
                    required
                    placeholder="••••••••"
                >
                @error('contrasena')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-row">
                <label>
                    <input type="checkbox" name="remember"> Recordarme
                </label>
            </div>

            <button type="submit" class="btn-submit">Ingresar al sistema</button>
        </form>

        <div class="login-footer">
            <a href="{{ route('home') }}">← Volver al sitio</a>
        </div>
    </div>
</div>
</body>
</html>
