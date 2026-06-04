<?php

namespace App\Models;

use App\Models\StateInterface;

/**
 * Extend Auto model with state handling.
 */
trait AutoStateTrait
{
    /**
     * Apply a StateInterface to this Auto model.
     */
    public function setState(StateInterface $state): void
    {
        $state->apply($this);
    }
}
