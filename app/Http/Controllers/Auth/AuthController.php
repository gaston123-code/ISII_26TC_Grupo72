<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Administrador;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

/**
 * AuthController
 * ─────────────────────────────────────────────────────────────────
 * Maneja el login/logout para AMBOS roles: Cliente y Administrador.
 * Cada rol usa su propio guard de Laravel.
 */
class AuthController extends Controller
{
    // ═══════════════════════════════════════════════
    //  LOGIN UNIFICADO
    // ═══════════════════════════════════════════════

    /** Muestra el formulario de login único. */
    public function showLogin(): View|RedirectResponse
    {
        // Si ya está autenticado, redirigir
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::guard('cliente')->check()) {
            return redirect()->route('catalogo');
        }

        return view('auth.login');
    }

    /** Procesa el login para todos los usuarios. */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'      => ['required', 'email'],
            'contrasena' => ['required', 'string'],
        ]);

        // Intentar autenticar como administrador
        if (Auth::guard('admin')->attempt([
            'email'    => $credentials['email'],
            'password' => $credentials['contrasena'],
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'))->with('success', 'Bienvenido al panel de administración.');
        }

        // Intentar autenticar como cliente
        if (Auth::guard('cliente')->attempt([
            'email'      => $credentials['email'],
            'password'   => $credentials['contrasena'],
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('catalogo'))->with('success', '¡Bienvenido de nuevo!');
        }

        throw ValidationException::withMessages([
            'email' => 'El correo o la contraseña son incorrectos.',
        ]);
    }

    /** Cierra la sesión activa (admin o cliente). */
    public function logout(Request $request): RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('cliente')->check()) {
            Auth::guard('cliente')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }

    // ═══════════════════════════════════════════════
    //  REGISTRO DE CLIENTES
    // ═══════════════════════════════════════════════

    /** Muestra el formulario de registro de cliente. */
    public function showRegister(): View
    {
        return view('auth.register');
    }

    /** Procesa el registro de un nuevo cliente. */
    public function register(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre'           => ['required', 'string', 'max:100'],
            'apellido'         => ['required', 'string', 'max:100'],
            'dni'              => ['required', 'string', 'max:20', 'unique:clientes,dni'],
            'telefono'         => ['nullable', 'string', 'max:20'],
            'direccion'        => ['nullable', 'string', 'max:255'],
            'email'            => ['required', 'email', 'max:255', 'unique:clientes,email'],
            'licencia'         => ['nullable', 'string', 'max:50', 'unique:clientes,licencia'],
            'contrasena'       => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $cliente = Cliente::create([
            ...$datos,
            'contrasena' => Hash::make($datos['contrasena']),
        ]);

        // Login automático tras el registro
        Auth::guard('cliente')->login($cliente);
        $request->session()->regenerate();

        return redirect()->route('catalogo')->with('success', '¡Cuenta creada! Bienvenido a AutoRent.');
    }
}
