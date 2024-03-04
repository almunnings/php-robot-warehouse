<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Enumerations\Command;
use App\Features\Controller;

interface HasController
{
    /**
     * Accept the input command and process it.
     */
    public function input(Command $command): void;

    /**
     * Get the controller associated with the connection.
     */
    public function controller(?Controller $controller = null): Controller;
}
