<?php

namespace App\States;

use App\States\EstadoAutoState;

/**
 * Estado concreto: Auto Disponible
 */
class DisponibleEstadoAuto extends EstadoAutoState
{
    public function __construct()
    {
        parent::__construct('Disponible');
    }
}
?>
