<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Features\Warehouse\Warehouse;

interface HasWarehouse
{
    public function warehouse(?Warehouse $warehouse = null): Warehouse;
}
