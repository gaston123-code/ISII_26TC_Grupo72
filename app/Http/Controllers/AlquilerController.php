<?php

namespace App\Http\Controllers;

use App\Models\Alquiler;
use App\Models\Auto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AlquilerController extends Controller
{
    /**
     * Muestra el listado de reservas del cliente autenticado.
     */
    public function index()
    {
        // Llamada al Diagrama de Secuencia: verificarReservas
        $reservas = Alquiler::verificarReservas(Auth::guard('cliente')->id());

        return view('mis-reservas', compact('reservas'));
    }

    /**
     * Procesa y guarda la reserva en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_auto' => 'required|exists:autos,id_auto',
            'fecha_retiro' => 'required|date|after_or_equal:today',
            'fecha_devolucion' => 'required|date|after:fecha_retiro',
            'hora_retiro' => 'required',
            'hora_devolucion' => 'required',
            'medio_pago' => 'required|string',
        ]);

        $auto = Auto::findOrFail($request->id_auto);

        $fechaRetiro = Carbon::parse($request->fecha_retiro);
        $fechaDevolucion = Carbon::parse($request->fecha_devolucion);
        $dias = $fechaRetiro->diffInDays($fechaDevolucion) ?: 1;
        $precioTotal = $auto->precio * $dias;

        // --- LLAMADAS AL DIAGRAMA DE SECUENCIA ---

        // 1. VerificarDatos
        Alquiler::verificarDatos($request->all());

        // 2. reservar (Crea el registro y bloquea el auto)
        $alquiler = Alquiler::reservar([
            'id_auto' => $request->id_auto,
            'id_cliente' => Auth::guard('cliente')->id(),
            'fecha_retiro' => $request->fecha_retiro,
            'fecha_devolucion' => $request->fecha_devolucion,
            'hora_retiro' => $request->hora_retiro,
            'hora_devolucion' => $request->hora_devolucion,
            'precioTotal' => $precioTotal,
        ]);

        // 3. RegistrarPago (Si es efectivo)
        if ($request->medio_pago == 'Efectivo') {
            \App\Models\Pago::registrarPago([
                'id_reserva' => $alquiler->id_reserva,
                'monto' => $precioTotal,
                'medio_pago' => 'Efectivo',
            ]);
            return redirect()->route('cliente.reserva.exitosa', ['id' => $alquiler->id_reserva]);
        } else {
            // Otros medios van a la pasarela
            session(['temp_medio_pago' => $request->medio_pago]);
            return redirect()->route('cliente.pago.pasarela', ['id' => $alquiler->id_reserva]);
        }
    }

    /**
     * Muestra la pasarela de pago simulada.
     */
    public function showPasarela($id)
    {
        $alquiler = Alquiler::with(['auto.modelo'])->findOrFail($id);
        $medio_pago = session('temp_medio_pago', 'Tarjeta');
        return view('pasarela-pago', compact('alquiler', 'medio_pago'));
    }

    /**
     * Procesa el pago simulado.
     */
    public function processPasarela(Request $request)
    {
        $request->validate([
            'id_reserva' => 'required|exists:alquileres,id_reserva',
            'medio_pago' => 'required|string',
        ]);

        $alquiler = Alquiler::findOrFail($request->id_reserva);

        // RegistrarPago tras la simulación exitosa (Diagrama de Secuencia)
        \App\Models\Pago::registrarPago([
            'id_reserva' => $alquiler->id_reserva,
            'monto' => $alquiler->precioTotal,
            'medio_pago' => $request->medio_pago,
        ]);

        // Limpiar sesión
        session()->forget('temp_medio_pago');

        return redirect()->route('cliente.reserva.exitosa', ['id' => $alquiler->id_reserva]);
    }

    /**
     * Muestra la pantalla de éxito.
     */
    public function success($id)
    {
        $alquiler = Alquiler::with(['auto.modelo.marca'])->findOrFail($id);
        return view('reserva-exitosa', compact('alquiler'));
    }

    /**
     * Cancela una reserva y libera el auto.
     */
    public function cancel($id)
    {
        // Buscar la reserva (verDetalleReserva)
        $alquiler = Alquiler::where('id_reserva', $id)
            ->where('id_cliente', Auth::guard('cliente')->id())
            ->firstOrFail();

        // Evitar cancelar si ya está cancelada o finalizada
        if ($alquiler->id_estadoAlquiler == 5) {
            return back()->with('error', 'Esta reserva ya está cancelada.');
        }

        // Llamada al Diagrama de Secuencia: cancelarReserva
        $alquiler->cancelarReserva();

        return redirect()->route('cliente.reserva.index')->with('success', 'Reserva cancelada correctamente. El auto ahora está disponible.');
    }
    /**
     * Consulta la disponibilidad de autos según fechas y horas.
     * Mapea al flujo del Tercer Diagrama de Secuencia.
     */
    public function consultarDisponibilidad(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('catalogo');
        }

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'fecha_retiro' => 'required|date|after_or_equal:today',
            'fecha_devolucion' => 'required|date|after:fecha_retiro',
            'hora_retiro' => 'required',
            'hora_devolucion' => 'required',
        ], [
            'fecha_retiro.after_or_equal' => 'La fecha de retiro debe ser de hoy en adelante.',
            'fecha_devolucion.after' => 'La fecha de devolución debe ser posterior a la fecha de retiro.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('catalogo')
                        ->withErrors($validator)
                        ->withInput();
        }

        // 1. verificarConsulta (Obtener IDs de autos NO disponibles)
        $autosOcupadosIds = Alquiler::verificarConsulta(
            $request->fecha_retiro,
            $request->fecha_devolucion,
            $request->hora_retiro,
            $request->hora_devolucion
        );

        // 2. Muestra lista de autos disponibles (Filtrar catálogo)
        // Obtenemos los autos que NO están en la lista de ocupados y cuyo estado base sea 'Disponible' (ID 1)
        $autos = Auto::whereNotIn('id_auto', $autosOcupadosIds)
            ->where('id_estadoAuto', 1)
            ->with(['modelo.marca', 'estadoAuto'])
            ->get();

        // Guardamos los datos de la consulta en sesión para autocompletar el formulario de reserva después
        session(['consulta_fechas' => $request->only(['fecha_retiro', 'fecha_devolucion', 'hora_retiro', 'hora_devolucion'])]);

        return view('autos', [
            'autos' => $autos,
            'busqueda' => $request->all()
        ]);
    }
}
