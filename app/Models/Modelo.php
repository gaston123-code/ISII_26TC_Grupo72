<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo: Modelo (de auto)
 */
class Modelo extends Model
{
    protected $table      = 'modelos';
    protected $primaryKey = 'id_modelo';

    protected $fillable = ['nombre_modelo', 'id_marca'];

    /** Pertenece a una marca. */
    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class, 'id_marca', 'id_marca');
    }

    /** Tiene muchos autos. */
    public function autos(): HasMany
    {
        return $this->hasMany(Auto::class, 'id_modelo', 'id_modelo');
    }
}
