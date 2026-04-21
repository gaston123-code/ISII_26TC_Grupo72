<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** Modelo: EstadoAuto */
class EstadoAuto extends Model
{
    protected $table      = 'estado_autos';
    protected $primaryKey = 'id_estadoAuto';

    protected $fillable = ['estado_auto'];

    public function autos(): HasMany
    {
        return $this->hasMany(Auto::class, 'id_estadoAuto', 'id_estadoAuto');
    }
}
