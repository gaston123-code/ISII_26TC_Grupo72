<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Modelo: Pago */
class Pago extends Model
{
    protected $table      = 'pagos';
    protected $primaryKey = 'id_pago';

    protected $fillable = ['monto', 'medio_pago', 'fecha_pago', 'id_reserva'];

    protected $casts = [
        'monto'      => 'decimal:2',
        'fecha_pago' => 'date',
    ];

    public function alquiler(): BelongsTo
    {
        return $this->belongsTo(Alquiler::class, 'id_reserva', 'id_reserva');
    }

    /**
     * MÉTODOS DEL DIAGRAMA DE SECUENCIA
     */

    /**
     * Registra un nuevo pago para una reserva.
     * Mapea al paso 'RegistrarPago' del diagrama.
     */
    public static function registrarPago($data)
    {
        return self::create([
            'id_reserva' => $data['id_reserva'],
            'monto'      => $data['monto'],
            'medio_pago' => $data['medio_pago'],
            'fecha_pago' => now(),
        ]);
    }
}
