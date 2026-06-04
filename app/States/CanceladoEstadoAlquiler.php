<?php

namespace App\States;

use App\Models\Alquiler;
use App\Models\EstadoAlquiler;

/**
 * Estado concreto: Alquiler Cancelado
 */
class CanceladoEstadoAlquiler extends EstadoAlquilerState
{
    public function __construct()
    {
        parent::__construct('Cancelado');
    }

    /**
     * Apply the Cancelado state to the given Alquiler model.
     */
    public function apply($model): void
    {
        if ($model instanceof Alquiler) {
            $estado = EstadoAlquiler::where('estado_alquiler', $this->stateName)->first();
            if ($estado) {
                $model->id_estadoAlquiler = $estado->id_estadoAlquiler;
                $model->save();
            }
        }
    }
}
