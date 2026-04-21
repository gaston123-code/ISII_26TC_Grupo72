<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Modelo: Alquiler (Reserva)
 */
class Alquiler extends Model
{
    protected $table      = 'alquileres';
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
    ];

    protected $casts = [
        'fecha_retiro'     => 'date',
        'fecha_devolucion' => 'date',
        'precioTotal'      => 'decimal:2',
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
}
