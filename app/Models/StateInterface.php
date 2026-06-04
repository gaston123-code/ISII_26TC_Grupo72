<?php

namespace App\Models;

interface StateInterface
{
    /**
     * Apply the state to the given model.
     *
     * @param Model $model
     * @return void
     */
    public function apply($model): void;
}
