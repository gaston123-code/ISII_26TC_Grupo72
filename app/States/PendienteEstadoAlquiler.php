<?php

namespace App\States;

use App\Models\Alquiler;
use App\Models\EstadoAlquiler;

/**
 * Estado concreto: Alquiler Pendiente
 */
class PendienteEstadoAlquiler extends EstadoAlquilerState
{
    public function __construct()
    {
        parent::__construct('Pendiente');
    }

    /**
     * Apply the Pendiente state to the given Alquiler model.
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
