<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
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

    <form method="POST" action="<?php echo e(route('cliente.register.submit')); ?>">
        <?php echo csrf_field(); ?>

        <p class="section-title">Datos personales</p>
        <div class="form-grid">
            <div class="form-group">
                <label for="nombre">Nombre *</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo e(old('nombre')); ?>" required placeholder="Ej: Juan">
                <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido *</label>
                <input type="text" id="apellido" name="apellido" value="<?php echo e(old('apellido')); ?>" required placeholder="Ej: García">
                <?php $__errorArgs = ['apellido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group">
                <label for="dni">DNI *</label>
                <input type="text" id="dni" name="dni" value="<?php echo e(old('dni')); ?>" required placeholder="Ej: 38123456">
                <?php $__errorArgs = ['dni'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" value="<?php echo e(old('telefono')); ?>" placeholder="Ej: 3794123456">
                <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group full">
                <label for="direccion">Dirección</label>
                <input type="text" id="direccion" name="direccion" value="<?php echo e(old('direccion')); ?>" placeholder="Ej: San Martín 1234, Corrientes">
                <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group full">
                <label for="licencia">Nro. de licencia de conducir</label>
                <input type="text" id="licencia" name="licencia" value="<?php echo e(old('licencia')); ?>" placeholder="Opcional">
                <?php $__errorArgs = ['licencia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <p class="section-title">Credenciales de acceso</p>
        <div class="form-grid">
            <div class="form-group full">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required placeholder="tu@email.com">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña *</label>
                <input type="password" id="contrasena" name="contrasena" required placeholder="Mínimo 8 caracteres">
                <?php $__errorArgs = ['contrasena'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group">
                <label for="contrasena_confirmation">Repetir contraseña *</label>
                <input type="password" id="contrasena_confirmation" name="contrasena_confirmation" required placeholder="Repetí tu contraseña">
            </div>
        </div>

        <button type="submit" class="btn">Crear mi cuenta</button>
    </form>

    <div class="footer-links">
        ¿Ya tenés cuenta? <a href="<?php echo e(route('cliente.login')); ?>">Iniciá sesión</a>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\xampp1\htdocs\ISII_26TC_Grupo72-main\resources\views/auth/cliente-register.blade.php ENDPATH**/ ?>