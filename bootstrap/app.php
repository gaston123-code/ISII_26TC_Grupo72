<?php

use App\Http\Controllers\Admin\AutoController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ClienteAuthMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Registrar AutoController como Singleton en el contenedor de Laravel
$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web:        __DIR__.'/../routes/web.php',
        commands:   __DIR__.'/../routes/console.php',
        health:     '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Registrar los alias de middleware personalizados
        $middleware->alias([
            'auth.admin'    => AdminMiddleware::class,
            'auth.cliente'  => ClienteAuthMiddleware::class,
        ]);

        // Evitar error 419 en el logout durante el demo local
        $middleware->validateCsrfTokens(except: [
            'cliente/logout',
            'admin/logout',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

// Patrón Singleton: registrar AutoController como instancia única
$app->singleton(AutoController::class);

return $app;
