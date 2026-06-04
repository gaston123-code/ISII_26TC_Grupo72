<?php

namespace App\Models;

use App\Models\StateInterface;

/**
 * Trait to apply a StateInterface to an Alquiler model.
 */
trait AlquilerStateTrait
{
    /**
     * Apply a state to this Alquiler instance.
     */
    public function setState(StateInterface $state): void
    {
        $state->apply($this);
    }
}
?>
