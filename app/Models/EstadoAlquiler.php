<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** Modelo: EstadoAlquiler */
class EstadoAlquiler extends Model
{
    protected $table      = 'estado_alquileres';
    protected $primaryKey = 'id_estadoAlquiler';

    protected $fillable = ['estado_alquiler'];

    public function alquileres(): HasMany
    {
        return $this->hasMany(Alquiler::class, 'id_estadoAlquiler', 'id_estadoAlquiler');
    }
}
