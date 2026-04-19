<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AutoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — AutoRent
|--------------------------------------------------------------------------
|
| Estructura de rutas:
|   /              → Catálogo público (responsabilidad de Gastón)
|   /cliente/*     → Rutas del cliente autenticado
|   /admin/*       → Rutas del administrador (protegidas por AdminMiddleware)
|
*/

// ═══════════════════════════════════════════════════════════
//  RUTAS PÚBLICAS
// ═══════════════════════════════════════════════════════════

Route::get('/', function () {
    return view('welcome');
})->name('home');

// ═══════════════════════════════════════════════════════════
//  AUTENTICACIÓN — CLIENTE
// ═══════════════════════════════════════════════════════════

Route::prefix('cliente')->name('cliente.')->group(function () {

    // Login
    Route::get('/login',  [AuthController::class, 'showClienteLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'clienteLogin'])->name('login.submit');

    // Registro
    Route::get('/registro',  [AuthController::class, 'showClienteRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'clienteRegister'])->name('register.submit');

    // Logout (protegida)
    Route::post('/logout', [AuthController::class, 'clienteLogout'])
         ->middleware('auth.cliente')
         ->name('logout');

    // Rutas protegidas del cliente (perfil, mis alquileres, etc.)
    // Para ser completadas por Gastón según el flujo de renta
    Route::middleware('auth.cliente')->group(function () {
        Route::get('/perfil', fn() => view('cliente.perfil'))->name('perfil');
    });

});

// ═══════════════════════════════════════════════════════════
//  AUTENTICACIÓN — ADMINISTRADOR
// ═══════════════════════════════════════════════════════════

Route::prefix('admin')->name('admin.')->group(function () {

    // Login del admin (público)
    Route::get('/login',  [AuthController::class, 'showAdminLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'adminLogin'])->name('login.submit');

    // Logout
    Route::post('/logout', [AuthController::class, 'adminLogout'])
         ->middleware('auth.admin')
         ->name('logout');

    // ── Panel protegido por AdminMiddleware ──────────────────
    Route::middleware('auth.admin')->group(function () {

        // Dashboard
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

        // Gestión de Autos (RF3) — CRUD completo
        Route::resource('autos', AutoController::class)->parameters([
            'autos' => 'id',
        ]);
        // Genera automáticamente:
        //   GET    /admin/autos           → admin.autos.index
        //   GET    /admin/autos/create    → admin.autos.create
        //   POST   /admin/autos           → admin.autos.store
        //   GET    /admin/autos/{id}      → admin.autos.show
        //   GET    /admin/autos/{id}/edit → admin.autos.edit
        //   PUT    /admin/autos/{id}      → admin.autos.update
        //   DELETE /admin/autos/{id}      → admin.autos.destroy

    });

});
