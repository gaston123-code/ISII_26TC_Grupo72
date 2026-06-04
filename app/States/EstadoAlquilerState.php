<?php

namespace App\States;

use App\Models\Alquiler;
use App\Models\StateInterface;

/**
 * Abstract base class for EstadoAlquiler states.
 */
abstract class EstadoAlquilerState implements StateInterface
{
    protected string $stateName;

    public function __construct(string $stateName)
    {
        $this->stateName = $stateName;
    }

    /**
     * Apply the state to the given Alquiler model.
     */
    public function apply($model): void
    {
        if ($model instanceof Alquiler) {
            $estado = \App\Models\EstadoAlquiler::where('estado_alquiler', $this->stateName)->first();
            if ($estado) {
                $model->id_estadoAlquiler = $estado->id_estadoAlquiler;
                $model->save();
            }
        }
    }
}
?>
