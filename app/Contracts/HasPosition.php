<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Features\Position\Position;

interface HasPosition
{
    public function position(?Position $position = null): Position;
}
