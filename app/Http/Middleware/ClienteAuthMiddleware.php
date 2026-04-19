<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * ClienteAuthMiddleware
 * ─────────────────────────────────────────────────────────────────
 * Protege las rutas que requieren un cliente autenticado.
 * Uso en rutas:
 *   Route::middleware('auth.cliente')->group(function () { ... });
 */
class ClienteAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::guard('cliente')->check()) {
            $request->session()->put('url.intended', $request->url());

            return redirect()
                ->route('cliente.login')
                ->with('error', 'Debes iniciar sesión para realizar una reserva.');
        }

        return $next($request);
    }
}
