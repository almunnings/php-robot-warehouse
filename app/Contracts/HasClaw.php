<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Features\Position;
use App\Features\Warehouse;

interface HasClaw
{
    /**
     * Instruct claw to grab.
     */
    public function grab(Position $position, Warehouse $warehouse): bool;

    /**
     * Instruct claw to drop.
     */
    public function drop(Position $position, Warehouse $warehouse): bool;
}
