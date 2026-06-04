<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\AlquilerStateTrait;

/**
 * Modelo: Alquiler (Reserva)
 */
class Alquiler extends Model
{
    use AlquilerStateTrait;
    protected $table = 'alquileres';
    protected $primaryKey = 'id_reserva';

    protected $fillable = [
        'fecha_retiro',
        'fecha_devolucion',
        'hora_retiro',
        'hora_devolucion',
        'precioTotal',
        'id_cliente',
        'id_auto',
        'id_estadoAlquiler',
        'identificador_unico',
        'firma_digital',
    ];

    protected $casts = [
        'fecha_retiro' => 'date',
        'fecha_devolucion' => 'date',
        'precioTotal' => 'decimal:2',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    public function auto(): BelongsTo
    {
        return $this->belongsTo(Auto::class, 'id_auto', 'id_auto');
    }

    public function estadoAlquiler(): BelongsTo
    {
        return $this->belongsTo(EstadoAlquiler::class, 'id_estadoAlquiler', 'id_estadoAlquiler');
    }

    public function pago(): HasOne
    {
        return $this->hasOne(Pago::class, 'id_reserva', 'id_reserva');
    }

    /**
     * Calcula la cantidad de días del alquiler.
     */
    public function getCantidadDiasAttribute(): int
    {
        return $this->fecha_retiro->diffInDays($this->fecha_devolucion) ?: 1;
    }

    /**
     * MÉTODOS DEL DIAGRAMA DE SECUENCIA
     */

    /**
     * Verifica la validez de los datos de la reserva.
     * Mapea al paso 'VerificarDatos' del diagrama.
     */
    public static function verificarDatos($data)
    {
        // En Laravel, la validación principal ocurre en el controlador.
        // Este método puede usarse para validaciones adicionales de lógica de negocio.
        return true;
    }

    /**
     * Calcula el precio total del alquiler.
     */
    public static function calcularPrecioTotal($precioDiario, $fechaRetiro, $fechaDevolucion)
    {
        $fechaRetiroCarbon = $fechaRetiro instanceof \Carbon\Carbon ? $fechaRetiro : \Carbon\Carbon::parse($fechaRetiro);
        $fechaDevolucionCarbon = $fechaDevolucion instanceof \Carbon\Carbon ? $fechaDevolucion : \Carbon\Carbon::parse($fechaDevolucion);
        if ($fechaDevolucionCarbon->lt($fechaRetiroCarbon)) {
            throw new \InvalidArgumentException('La fecha de devolución no puede ser anterior a la de retiro.');
        }
        $dias = $fechaRetiroCarbon->diffInDays($fechaDevolucionCarbon) ?: 1;
        if ($dias > 30) {
            throw new \InvalidArgumentException('El alquiler no puede superar los 30 días.');
        }
        return round($precioDiario * $dias, 2);
    }

    /**
     * Procesa la creación de la reserva y actualiza el estado del auto.
     * Mapea al paso 'reservar' del diagrama.
     */
    public static function reservar($data)
    {
        $alquiler = self::create([
            'id_auto' => $data['id_auto'],
            'id_cliente' => $data['id_cliente'],
            'fecha_retiro' => $data['fecha_retiro'],
            'fecha_devolucion' => $data['fecha_devolucion'],
            'hora_retiro' => $data['hora_retiro'],
            'hora_devolucion' => $data['hora_devolucion'],
            'precioTotal' => $data['precioTotal'],
            // Use lookup for Pendiente state
                        'id_estadoAlquiler' => \App\Models\EstadoAlquiler::where('estado_alquiler', 'Pendiente')->value('id_estadoAlquiler'),
        ]);

        // Bloquear el auto (Estado: Alquilado)
        if ($alquiler->auto) {
            $alquiladoId = \App\Models\EstadoAuto::where('estado_auto', 'Alquilado')->value('id_estadoAuto');
            $alquiler->auto->update(['id_estadoAuto' => $alquiladoId]);
        }

        return $alquiler;
    }

    /**
     * MÉTODOS DEL SEGUNDO DIAGRAMA DE SECUENCIA
     */

    /**
     * Obtiene las reservas de un cliente.
     * Mapea al paso 'verificarReservas' del diagrama.
     */
    public static function verificarReservas($id_cliente)
    {
        return self::with(['auto.modelo.marca', 'estadoAlquiler'])
            ->where('id_cliente', $id_cliente)
            ->where('id_estadoAlquiler', '!=', 5) // Excluir canceladas
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Obtiene el detalle de una reserva.
     * Mapea al paso 'verDetalleReserva' del diagrama.
     */
    public static function verDetalleReserva($id_reserva)
    {
        return self::with(['auto.modelo.marca', 'estadoAlquiler'])->findOrFail($id_reserva);
    }

    /**
     * Procesa la cancelación de la reserva y libera el auto.
     * Mapea al paso 'cancelarReserva' del diagrama.
     */
    public function cancelarReserva()
    {
        // 1. Cambiar estado a 'Cancelado' usando lookup
        $canceladoId = \App\Models\EstadoAlquiler::where('estado_alquiler', 'Cancelado')->value('id_estadoAlquiler');
        $this->update(['id_estadoAlquiler' => $canceladoId]);

        // 2. Liberar el auto (Estado: Disponible) usando lookup
        if ($this->auto) {
                        $disponibleId = \App\Models\EstadoAuto::where('estado_auto', 'Disponible')->value('id_estadoAuto');
            $this->auto->update(['id_estadoAuto' => $disponibleId]);
        }

        return true;
    }
    /**
     * MÉTODOS DEL TERCER DIAGRAMA DE SECUENCIA
     */

    /**
     * Verifica qué autos están ocupados en un rango de fechas/horas.
     * Mapea al paso 'verificarConsulta' del diagrama.
     */
    public static function verificarConsulta($f_retiro, $f_devolucion, $h_retiro, $h_devolucion)
    {
        // Buscamos alquileres que se solapen con el rango solicitado
        // Un alquiler se solapa si (inicio1 < fin2) Y (fin1 > inicio2)
        // Nota: id_estadoAlquiler != 5 (excluimos cancelados)

        return self::where('id_estadoAlquiler', '!=', 5)
            ->where(function ($query) use ($f_retiro, $f_devolucion) {
                $query->whereBetween('fecha_retiro', [$f_retiro, $f_devolucion])
                    ->orWhereBetween('fecha_devolucion', [$f_retiro, $f_devolucion])
                    ->orWhere(function ($q) use ($f_retiro, $f_devolucion) {
                        $q->where('fecha_retiro', '<=', $f_retiro)
                            ->where('fecha_devolucion', '>=', $f_devolucion);
                    });
            })
            ->pluck('id_auto')
            ->unique()
            ->toArray();
    }
}
