<?php

namespace App\States;

/**
 * Estado concreto: Auto Ocupado (reservado/alquilado)
 */
class OcupadoEstadoAuto extends EstadoAutoState
{
    public function __construct()
    {
        parent::__construct('Alquilado');
    }
}
