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
}
