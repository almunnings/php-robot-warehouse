<?php

declare(strict_types=1);

namespace App\Features;

use App\Contracts\HasController;
use App\Enumerations\Command;

/**
 * A controller just passes input to a controllable item via a connection.
 */
class Controller
{
    protected HasController $connection;

    public function connection(?HasController $controllable = null): HasController
    {
        $this->connection = $controllable ?: $this->connection;
        return $this->connection;
    }

    /**
     * Pass input from the controller to the controller's connection.
     */
    public function process(mixed $input): void
    {
        $parts = explode(' ', $input);

        $valid = array_filter(
            $parts,
            fn($part) => Command::tryFrom($part)
        );

        array_map(
            fn($part) => $this->connection()->input(Command::from($part)),
            $valid
        );
    }
}
