<?php

declare(strict_types=1);

namespace App\Features;

/**
 * A controllable item requires a connection to a controller.
 */
trait Controllable
{
    protected Controller $controller;

    public function controller(?Controller $controller = null): Controller
    {
        if (!is_null($controller)) {
            $controller->connection($this);
            $this->controller = $controller;
        }

        return $this->controller;
    }
}
