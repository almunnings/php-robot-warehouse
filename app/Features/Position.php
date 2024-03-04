<?php

declare(strict_types=1);

namespace App\Features;

use App\Enumerations\Command;
use App\Features\Warehouse;

/**
 * A position in a two-dimensional space.
 */
class Position
{
    public function __construct(
        private int $x,
        private int $y
    ) {
    }

    public function x(): int
    {
        return $this->x;
    }

    public function y(): int
    {
        return $this->y;
    }

    public function equals(Position $position): bool
    {
        return $this->x === $position->x() && $this->y === $position->y();
    }

    public function move(Command $command, Warehouse $warehouse): void
    {
        switch ($command) {
            case Command::MOVE_NORTH:
                if ($this->y > 0) {
                    $this->y -= 1;
                }
                break;
            case Command::MOVE_SOUTH:
                if ($this->y < $warehouse->height() - 1) {
                    $this->y += 1;
                }
                break;
            case Command::MOVE_EAST:
                if ($this->x < $warehouse->width() - 1) {
                    $this->x += 1;
                }
                break;
            case Command::MOVE_WEST:
                if ($this->x > 0) {
                    $this->x -= 1;
                }
                break;
        }
    }
}
