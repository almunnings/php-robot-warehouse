<?php

declare(strict_types=1);

namespace App\Enumerations;

/**
 * Commands input from controllers.
 */
enum Command: string
{
    case MOVE_NORTH = 'N';
    case MOVE_SOUTH = 'S';
    case MOVE_EAST = 'E';
    case MOVE_WEST = 'W';
}
