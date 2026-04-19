<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo: Auto
 * Vehículo disponible para alquiler.
 */
class Auto extends Model
{
    protected $table      = 'autos';
    protected $primaryKey = 'id_auto';

    protected $fillable = [
        'precio',
        'anio',
        'imagen',
        'descripcion',
        'id_modelo',
        'id_estadoAuto',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'anio'   => 'integer',
    ];

    /** Pertenece a un modelo. */
    public function modelo(): BelongsTo
    {
        return $this->belongsTo(Modelo::class, 'id_modelo', 'id_modelo');
    }

    /** Tiene un estado. */
    public function estadoAuto(): BelongsTo
    {
        return $this->belongsTo(EstadoAuto::class, 'id_estadoAuto', 'id_estadoAuto');
    }

    /** Tiene muchos alquileres. */
    public function alquileres(): HasMany
    {
        return $this->hasMany(Alquiler::class, 'id_auto', 'id_auto');
    }

    /**
     * Devuelve la URL pública de la imagen.
     * Si no hay imagen, devuelve un placeholder.
     */
    public function getImagenUrlAttribute(): string
    {
        return $this->imagen
            ? asset('storage/' . $this->imagen)
            : asset('images/auto-placeholder.jpg');
    }
}
