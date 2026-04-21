<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AutoRent — Crear Cuenta</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); padding: 20px; }
        .card { background: #fff; border-radius: 16px; padding: 40px; width: 100%; max-width: 520px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 28px; }
        .header .logo { font-size: 36px; margin-bottom: 8px; }
        .header h1 { font-size: 22px; font-weight: 700; color: #0f172a; }
        .header p { font-size: 14px; color: #64748b; margin-top: 4px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-group { margin-bottom: 14px; }
        .form-group.full { grid-column: 1 / -1; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 5px; }
        .form-group input {
            width: 100%; padding: 10px 13px; border: 1.5px solid #e5e7eb;
            border-radius: 8px; font-size: 14px; font-family: inherit; transition: border-color 0.15s;
        }
        .form-group input:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,.1); }
        .form-error { font-size: 12px; color: #dc2626; margin-top: 4px; }
        .section-title { font-size: 12px; font-weight: 700; text-transform: uppercase; color: #94a3b8; letter-spacing: 1px; margin: 18px 0 10px; }
        .btn { width: 100%; padding: 12px; background: #2563eb; color: #fff; border: none; border-radius: 8px; font-size: 15px; font-weight: 700; cursor: pointer; font-family:  inherit; transition: background 0.15s; margin-top: 8px; }
        .btn:hover { background: #1d4ed8; }
        .footer-links { text-align: center; margin-top: 18px; font-size: 13px; color: #64748b; }
        .footer-links a { color: #2563eb; text-decoration: none; font-weight: 500; }
    </style>
</head>
<body>
<div class="card">
    <div class="header">
        <div class="logo">🚗</div>
        <h1>Crear cuenta</h1>
        <p>Registrate en AutoRent y empezá a alquilar</p>
    </div>

    <form method="POST" action="{{ route('cliente.register.submit') }}">
        @csrf

        <p class="section-title">Datos personales</p>
        <div class="form-grid">
            <div class="form-group">
                <label for="nombre">Nombre *</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required placeholder="Ej: Juan">
                @error('nombre') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label for="apellido">Apellido *</label>
                <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" required placeholder="Ej: García">
                @error('apellido') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label for="dni">DNI *</label>
                <input type="text" id="dni" name="dni" value="{{ old('dni') }}" required placeholder="Ej: 38123456">
                @error('dni') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}" placeholder="Ej: 3794123456">
                @error('telefono') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div class="form-group full">
                <label for="direccion">Dirección</label>
                <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}" placeholder="Ej: San Martín 1234, Corrientes">
                @error('direccion') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div class="form-group full">
                <label for="licencia">Nro. de licencia de conducir</label>
                <input type="text" id="licencia" name="licencia" value="{{ old('licencia') }}" placeholder="Opcional">
                @error('licencia') <p class="form-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <p class="section-title">Credenciales de acceso</p>
        <div class="form-grid">
            <div class="form-group full">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="tu@email.com">
                @error('email') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña *</label>
                <input type="password" id="contrasena" name="contrasena" required placeholder="Mínimo 8 caracteres">
                @error('contrasena') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label for="contrasena_confirmation">Repetir contraseña *</label>
                <input type="password" id="contrasena_confirmation" name="contrasena_confirmation" required placeholder="Repetí tu contraseña">
            </div>
        </div>

        <button type="submit" class="btn">Crear mi cuenta</button>
    </form>

    <div class="footer-links">
        ¿Ya tenés cuenta? <a href="{{ route('cliente.login') }}">Iniciá sesión</a>
    </div>
</div>
</body>
</html>
