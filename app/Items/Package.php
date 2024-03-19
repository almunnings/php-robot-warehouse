<?php

declare(strict_types=1);

namespace App\Items;

use App\Contracts\HasId;
use App\Contracts\HasPosition;
use App\Contracts\HasWarehouse;
use App\Features\Positionable;
use App\Features\Warehouseable;

class Package implements HasId, HasPosition, HasWarehouse
{
    use Positionable;
    use Warehouseable;

    private string $id;

    public function id(): string
    {
        return $this->id ??= uniqid('package');
    }
}
