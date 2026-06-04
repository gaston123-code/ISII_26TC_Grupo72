<?php

namespace App\States;

use App\Models\Auto;
use App\Models\StateInterface;

abstract class EstadoAutoState implements StateInterface
{
    protected string $stateName;

    public function __construct(string $stateName)
    {
        $this->stateName = $stateName;
    }

    /**
     * Apply the state to the given Auto model.
     */
    public function apply($model): void
    {
        if ($model instanceof Auto) {
            // Assuming the EstadoAuto model has a matching id for each state name.
            // Here we simply set the relation based on state name lookup.
            $estado = \App\Models\EstadoAuto::where('estado_auto', $this->stateName)->first();
            if ($estado) {
                $model->id_estadoAuto = $estado->id_estadoAuto;
                $model->save();
            }
        }
    }
}
?>
