<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auto;
use App\Models\EstadoAuto;
use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * AutoController (RF3 — Registro y Gestión de Autos)
 * ─────────────────────────────────────────────────────────────────
 * Permite al Administrador gestionar la flota de autos (CRUD).
 * Todas las rutas de este controller están protegidas por AdminMiddleware.
 */
class AutoController extends Controller
{
    /**
     * index() — Lista todos los autos con sus relaciones.
     * Ruta: GET /admin/autos
     */
    public function index(): View
    {
        $autos = Auto::with(['modelo.marca', 'estadoAuto'])
                     ->orderBy('created_at', 'desc')
                     ->paginate(10);

        return view('admin.autos.index', compact('autos'));
    }

    /**
     * create() — Muestra el formulario para registrar un nuevo auto.
     * Ruta: GET /admin/autos/create
     */
    public function create(): View
    {
        $modelos     = Modelo::with('marca')->orderBy('nombre_modelo')->get();
        $estadosAuto = EstadoAuto::all();

        return view('admin.autos.create', compact('modelos', 'estadosAuto'));
    }

    /**
     * store() — Guarda un nuevo auto en la base de datos (RF3).
     * Ruta: POST /admin/autos
     *
     * Validaciones según el informe:
     *   - precio: decimal positivo
     *   - anio: año válido (no menor de 2000 ni mayor al actual + 1)
     *   - imagen: archivo de imagen opcional, máx. 2MB
     */
    public function store(Request $request): RedirectResponse
    {
        $anioMinimo = 2000;
        $anioMaximo = (int) date('Y') + 1;

        $datos = $request->validate([
            'id_modelo'     => ['required', 'exists:modelos,id_modelo'],
            'id_estadoAuto' => ['required', 'exists:estado_autos,id_estadoAuto'],
            'precio'        => ['required', 'numeric', 'gt:0', 'max:9999999.99'],
            'anio'          => ['required', 'integer', "min:{$anioMinimo}", "max:{$anioMaximo}"],
            'descripcion'   => ['nullable', 'string', 'max:255'],
            'imagen'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            // Mensajes personalizados en español
            'id_modelo.required'     => 'Debes seleccionar un modelo.',
            'id_modelo.exists'       => 'El modelo seleccionado no existe.',
            'id_estadoAuto.required' => 'Debes seleccionar el estado del auto.',
            'precio.required'        => 'El precio por día es obligatorio.',
            'precio.numeric'         => 'El precio debe ser un número.',
            'precio.gt'              => 'El precio debe ser mayor a cero.',
            'anio.required'          => 'El año del auto es obligatorio.',
            'anio.integer'           => 'El año debe ser un número entero.',
            'anio.min'               => "El año no puede ser anterior a {$anioMinimo}.",
            'anio.max'               => "El año no puede superar {$anioMaximo}.",
            'imagen.image'           => 'El archivo debe ser una imagen.',
            'imagen.mimes'           => 'La imagen debe ser JPG, JPEG, PNG o WebP.',
            'imagen.max'             => 'La imagen no puede superar los 2MB.',
        ]);

        // Manejo de la imagen: guardar en storage/app/public/autos/
        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('autos', 'public');
        }

        Auto::create([
            'id_modelo'     => $datos['id_modelo'],
            'id_estadoAuto' => $datos['id_estadoAuto'],
            'precio'        => $datos['precio'],
            'anio'          => $datos['anio'],
            'descripcion'   => $datos['descripcion'] ?? null,
            'imagen'        => $imagenPath,
        ]);

        return redirect()
            ->route('admin.autos.index')
            ->with('success', '✅ Auto registrado correctamente en la flota.');
    }

    /**
     * show() — Muestra los detalles de un auto.
     * Ruta: GET /admin/autos/{id}
     */
    public function show(int $id): View
    {
        $auto = Auto::with(['modelo.marca', 'estadoAuto', 'alquileres'])->findOrFail($id);

        return view('admin.autos.show', compact('auto'));
    }

    /**
     * edit() — Muestra el formulario de edición de un auto.
     * Ruta: GET /admin/autos/{id}/edit
     */
    public function edit(int $id): View
    {
        $auto        = Auto::findOrFail($id);
        $modelos     = Modelo::with('marca')->orderBy('nombre_modelo')->get();
        $estadosAuto = EstadoAuto::all();

        return view('admin.autos.edit', compact('auto', 'modelos', 'estadosAuto'));
    }

    /**
     * update() — Actualiza los datos de un auto.
     * Ruta: PUT /admin/autos/{id}
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $auto = Auto::findOrFail($id);

        $anioMinimo = 2000;
        $anioMaximo = (int) date('Y') + 1;

        $datos = $request->validate([
            'id_modelo'     => ['required', 'exists:modelos,id_modelo'],
            'id_estadoAuto' => ['required', 'exists:estado_autos,id_estadoAuto'],
            'precio'        => ['required', 'numeric', 'gt:0', 'max:9999999.99'],
            'anio'          => ['required', 'integer', "min:{$anioMinimo}", "max:{$anioMaximo}"],
            'descripcion'   => ['nullable', 'string', 'max:255'],
            'imagen'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // Si se sube nueva imagen, eliminar la anterior
        if ($request->hasFile('imagen')) {
            if ($auto->imagen) {
                Storage::disk('public')->delete($auto->imagen);
            }
            $datos['imagen'] = $request->file('imagen')->store('autos', 'public');
        }

        $auto->update($datos);

        return redirect()
            ->route('admin.autos.index')
            ->with('success', '✅ Auto actualizado correctamente.');
    }

    /**
     * destroy() — Elimina un auto de la base de datos.
     * Ruta: DELETE /admin/autos/{id}
     * Solo se puede eliminar si no tiene alquileres activos.
     */
    public function destroy(int $id): RedirectResponse
    {
        $auto = Auto::with('alquileres')->findOrFail($id);

        // Verificar que no tenga alquileres activos
        $alquileresActivos = $auto->alquileres()
            ->whereHas('estadoAlquiler', fn($q) => $q->whereIn('estado_alquiler', ['Activo', 'Confirmado']))
            ->count();

        if ($alquileresActivos > 0) {
            return redirect()
                ->back()
                ->with('error', '⛔ No se puede eliminar: el auto tiene alquileres activos.');
        }

        // Eliminar imagen del storage
        if ($auto->imagen) {
            Storage::disk('public')->delete($auto->imagen);
        }

        $auto->delete();

        return redirect()
            ->route('admin.autos.index')
            ->with('success', '🗑️ Auto eliminado de la flota.');
    }
}
