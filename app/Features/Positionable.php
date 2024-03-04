<?php

declare(strict_types=1);

namespace App\Features;

/**
 * A positional item has a position in the warehouse.
 */
trait Positionable
{
    protected Position $position;

    public function position(?Position $position = null): Position
    {
        if ($position) {
            $this->position = $position;
        }

        return $this->position;
    }
}
