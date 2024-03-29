<?php

declare(strict_types=1);

namespace App\Items;

use App\Contracts\HasClaw;
use App\Contracts\HasController;
use App\Contracts\HasId;
use App\Contracts\HasPosition;
use App\Contracts\HasWarehouse;
use App\Enumerations\Command;
use App\Features\Controllable;
use App\Features\Positionable;
use App\Features\Warehouseable;
use App\Features\Clawable;

class Robot implements HasId, HasController, HasPosition, HasWarehouse, HasClaw
{
    use Controllable;
    use Positionable;
    use Warehouseable;
    use Clawable;

    private string $id;

    public function id(): string
    {
        return $this->id ??= uniqid('robot');
    }

    public function input(Command $command): void
    {
        match ($command) {
            Command::MOVE_NORTH => $this->move($command),
            Command::MOVE_SOUTH => $this->move($command),
            Command::MOVE_EAST => $this->move($command),
            Command::MOVE_WEST => $this->move($command),
            Command::GRAB => $this->grab($this->position(), $this->warehouse()),
            Command::DROP => $this->drop($this->position(), $this->warehouse()),
        };
    }

    public function move(Command $command): void
    {
        $position = clone $this->position();
        $warehouse = $this->warehouse();
        $position->move($command, $warehouse);

        // Find any other robots in this position.
        $collisions = array_filter(
            $warehouse->find($position),
            fn($item) => $item instanceof Robot
        );

        if (!empty($collisions)) {
            logger()->info("Collision detected");
            return;
        }

        logger()->info("Committing move", [
            'robot' => $this->id(),
            'command' => $command->value,
            'x' => $position->x(),
            'y' => $position->y(),
        ]);

        $this->position($position);
    }
}
