<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo: Marca
 * Represeta una marca de auto (ej: Toyota, Ford).
 */
class Marca extends Model
{
    protected $table      = 'marcas';
    protected $primaryKey = 'id_marca';

    protected $fillable = ['nombre_marca'];

    /** Una marca tiene muchos modelos. */
    public function modelos(): HasMany
    {
        return $this->hasMany(Modelo::class, 'id_marca', 'id_marca');
    }
}
