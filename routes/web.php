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
    $autos = \App\Models\Auto::with(['modelo.marca', 'estadoAuto'])->get();
    return view('autos', compact('autos'));
})->name('catalogo');

Route::match(['get', 'post'], '/consultar-disponibilidad', [\App\Http\Controllers\AlquilerController::class, 'consultarDisponibilidad'])->name('consultar.disponibilidad');

// ═══════════════════════════════════════════════════════════
//  AUTENTICACIÓN Y REGISTRO
// ═══════════════════════════════════════════════════════════

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
Route::post('/registro', [AuthController::class, 'register'])->name('register.submit');

// ═══════════════════════════════════════════════════════════
//  RUTAS DEL CLIENTE (Requiere login como cliente)
// ═══════════════════════════════════════════════════════════

Route::prefix('cliente')->name('cliente.')->middleware('auth.cliente')->group(function () {
    Route::get('/perfil', fn() => view('cliente.perfil'))->name('perfil');

    Route::get('/reservar/{id_auto}', function ($id_auto) {
        $auto = \App\Models\Auto::findOrFail($id_auto);
        return view('reservar', compact('auto'));
    })->name('reservar');

    // Procesar Alquiler y Pagos
    Route::get('/mis-reservas', [\App\Http\Controllers\AlquilerController::class, 'index'])->name('reserva.index');
    Route::post('/alquiler', [\App\Http\Controllers\AlquilerController::class, 'store'])->name('reserva.store');
    Route::get('/reserva-exitosa/{id}', [\App\Http\Controllers\AlquilerController::class, 'success'])->name('reserva.exitosa');
    Route::delete('/reserva/{id}/cancelar', [\App\Http\Controllers\AlquilerController::class, 'cancel'])->name('reserva.cancel');

    // Pasarela de Pago
    Route::get('/pago/pasarela/{id}', [\App\Http\Controllers\AlquilerController::class, 'showPasarela'])->name('pago.pasarela');
    Route::post('/pago/procesar', [\App\Http\Controllers\AlquilerController::class, 'processPasarela'])->name('pago.procesar');
});

// ═══════════════════════════════════════════════════════════
//  AUTENTICACIÓN — ADMINISTRADOR
// ═══════════════════════════════════════════════════════════

Route::prefix('admin')->name('admin.')->group(function () {

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
