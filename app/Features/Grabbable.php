<?php

declare(strict_types=1);

namespace App\Features;

use App\Items\Package;

trait Grabbable
{
    protected $inHands = null;

    public function grab(Position $position, Warehouse $warehouse): bool
    {
        if ($this->inHands) {
            logger()->error('Hands full');
            return false;
        }

        // Find any other robots in this position.
        $packages = array_filter(
            $warehouse->find($position),
            fn($item) => $item instanceof Package
        );

        if (!$packages) {
            logger()->error('Nothing at position');
            return false;
        }

        $this->inHands = array_pop($packages);
        $warehouse->remove($this->inHands);

        logger()->info("Committing grab", [
            'item' => $this->inHands->id(),
            'x' => $position->x(),
            'y' => $position->y(),
        ]);

        return true;
    }

    public function drop(Position $position, Warehouse $warehouse): bool
    {
        if (!$this->inHands) {
            logger()->error('Hands empty');
            return false;
        }

        // Find any other robots in this position.
        $collisions = array_filter(
            $warehouse->find($position),
            fn($item) => $item instanceof Package
        );

        if ($collisions) {
            logger()->error('Cannot drop on top of another package');
            return false;
        }

        logger()->info("Committing drop", [
            'item' => $this->inHands->id(),
            'x' => $position->x(),
            'y' => $position->y(),
        ]);

        $warehouse->add($this->inHands, $position);
        $this->inHands = null;

        return true;
    }
}
