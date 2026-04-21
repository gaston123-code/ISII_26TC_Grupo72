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
        $reservas = Alquiler::with(['auto.modelo.marca', 'estadoAlquiler'])
            ->where('id_cliente', Auth::guard('cliente')->id())
            ->where('id_estadoAlquiler', '!=', 5) // Excluir canceladas
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mis-reservas', compact('reservas'));
    }

    /**
     * Procesa y guarda la reserva en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_auto'          => 'required|exists:autos,id_auto',
            'fecha_retiro'     => 'required|date|after_or_equal:today',
            'fecha_devolucion' => 'required|date|after:fecha_retiro',
            'hora_retiro'      => 'required',
            'hora_devolucion'  => 'required',
            'medio_pago'       => 'required|string',
        ]);

        $auto = Auto::findOrFail($request->id_auto);
        
        $fechaRetiro = Carbon::parse($request->fecha_retiro);
        $fechaDevolucion = Carbon::parse($request->fecha_devolucion);
        $dias = $fechaRetiro->diffInDays($fechaDevolucion) ?: 1;
        $precioTotal = $auto->precio * $dias;

        // 1. Crear el alquiler (Estado: Pendiente)
        $alquiler = Alquiler::create([
            'id_auto'           => $request->id_auto,
            'id_cliente'        => Auth::guard('cliente')->id(),
            'fecha_retiro'      => $request->fecha_retiro,
            'fecha_devolucion'  => $request->fecha_devolucion,
            'hora_retiro'       => $request->hora_retiro,
            'hora_devolucion'   => $request->hora_devolucion,
            'precioTotal'       => $precioTotal,
            'id_estadoAlquiler' => 1,
        ]);

        // 2. Bloquear el auto inmediatamente
        $auto->update(['id_estadoAuto' => 2]);

        // 3. Lógica de redirección según medio de pago
        if ($request->medio_pago == 'Efectivo') {
            // Pago en efectivo se registra directo
            \App\Models\Pago::create([
                'id_reserva' => $alquiler->id_reserva,
                'monto'      => $precioTotal,
                'medio_pago' => 'Efectivo',
                'fecha_pago' => now(),
            ]);
            return redirect()->route('cliente.reserva.exitosa', ['id' => $alquiler->id_reserva]);
        } else {
            // Otros medios van a la pasarela (Guardamos el medio elegido en sesión temporalmente)
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

        // Crear el registro de pago tras la simulación exitosa
        \App\Models\Pago::create([
            'id_reserva' => $alquiler->id_reserva,
            'monto'      => $alquiler->precioTotal,
            'medio_pago' => $request->medio_pago,
            'fecha_pago' => now(),
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
        // Buscar la reserva del cliente actual
        $alquiler = Alquiler::where('id_reserva', $id)
            ->where('id_cliente', Auth::guard('cliente')->id())
            ->firstOrFail();

        // Evitar cancelar si ya está cancelada o finalizada
        if ($alquiler->id_estadoAlquiler == 5) {
            return back()->with('error', 'Esta reserva ya está cancelada.');
        }

        // 1. Cambiar estado de la reserva a 'Cancelado' (ID 5)
        $alquiler->update(['id_estadoAlquiler' => 5]);

        // 2. Liberar el auto -> Cambiar estado a 'Disponible' (ID 1)
        if ($alquiler->auto) {
            $alquiler->auto->update(['id_estadoAuto' => 1]);
        }

        return redirect()->route('cliente.reserva.index')->with('success', 'Reserva cancelada correctamente. El auto ahora está disponible.');
    }
}
