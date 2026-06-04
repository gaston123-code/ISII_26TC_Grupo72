<?php

namespace App\States;

use App\States\EstadoAutoState;

/**
 * Estado concreto: Auto en Mantenimiento
 */
class MantenimientoEstadoAuto extends EstadoAutoState
{
    public function __construct()
    {
        parent::__construct('Mantenimiento');
    }
}
?>
