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
    //  CLIENTE — Login / Logout / Registro
    // ═══════════════════════════════════════════════

    /** Muestra el formulario de login para clientes. */
    public function showClienteLogin(): View
    {
        return view('auth.cliente-login');
    }

    /** Procesa el login del cliente. */
    public function clienteLogin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'      => ['required', 'email'],
            'contrasena' => ['required', 'string', 'min:6'],
        ]);

        // Intentar autenticar con el guard 'cliente'
        if (Auth::guard('cliente')->attempt([
            'email'      => $credentials['email'],
            'password'   => $credentials['contrasena'],   // Laravel mapea 'password' al campo auth
        ], $request->boolean('remember'))) {

            $request->session()->regenerate();

            return redirect()
                ->intended(route('catalogo'))
                ->with('success', '¡Bienvenido, ' . Auth::guard('cliente')->user()->nombre . '!');
        }

        throw ValidationException::withMessages([
            'email' => 'El correo o la contraseña son incorrectos.',
        ]);
    }

    /** Cierra la sesión del cliente. */
    public function clienteLogout(Request $request): RedirectResponse
    {
        Auth::guard('cliente')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('catalogo')->with('success', 'Sesión cerrada correctamente.');
    }

    /** Muestra el formulario de registro de cliente. */
    public function showClienteRegister(): View
    {
        return view('auth.cliente-register');
    }

    /** Procesa el registro de un nuevo cliente. */
    public function clienteRegister(Request $request): RedirectResponse
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

    // ═══════════════════════════════════════════════
    //  ADMINISTRADOR — Login / Logout
    // ═══════════════════════════════════════════════

    /** Muestra el formulario de login para administradores. */
    public function showAdminLogin(): View
    {
        // Si ya está autenticado como admin, redirigir al panel
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.admin-login');
    }

    /** Procesa el login del administrador. */
    public function adminLogin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'      => ['required', 'email'],
            'contrasena' => ['required', 'string'],
        ]);

        if (Auth::guard('admin')->attempt([
            'email'    => $credentials['email'],
            'password' => $credentials['contrasena'],
        ], $request->boolean('remember'))) {

            $request->session()->regenerate();

            return redirect()
                ->intended(route('admin.dashboard'))
                ->with('success', 'Bienvenido al panel de administración.');
        }

        throw ValidationException::withMessages([
            'email' => 'Credenciales de administrador incorrectas.',
        ]);
    }

    /** Cierra la sesión del administrador. */
    public function adminLogout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
