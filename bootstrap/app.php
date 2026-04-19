<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ClienteAuthMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
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
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
