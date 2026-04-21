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
        if ($this->imagen && file_exists(public_path('storage/' . $this->imagen))) {
            return asset('storage/' . $this->imagen);
        }

        // Fallback dinámico a imágenes de stock profesionales (Unsplash)
        $query = $this->modelo ? str_replace(' ', '+', $this->modelo->marca->nombre_marca . '+' . $this->modelo->nombre_modelo) : 'car+stock';
        return "https://images.unsplash.com/photo-1542362567-b052d1f0b74a?q=80&w=600&auto=format&fit=crop&sig=" . $this->id_auto; // Imagen de stock genérica de alta calidad
        // O mejor aún, una búsqueda por modelo:
        // return "https://source.unsplash.com/featured/?car," . $query; 
    }
}
