<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * AdminMiddleware
 * ─────────────────────────────────────────────────────────────────
 * Protege las rutas del panel de administración.
 * Solo permite el acceso si el usuario está autenticado
 * con el guard 'admin'.
 *
 * Uso en rutas:
 *   Route::middleware('auth.admin')->group(function () { ... });
 */
class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar autenticación con el guard 'admin'
        if (! Auth::guard('admin')->check()) {
            // Guardar la URL intentada para redirigir después del login
            $request->session()->put('url.intended', $request->url());

            return redirect()
                ->route('admin.login')
                ->with('error', 'Debes iniciar sesión como administrador para acceder.');
        }

        return $next($request);
    }
}
