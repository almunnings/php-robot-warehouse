<?php

declare(strict_types=1);

namespace App\Features\Warehouse;

/**
 * A warehouseable item is in a warehouse.
 */
trait Warehouseable
{
    protected Warehouse $warehouse;

    public function warehouse(?Warehouse $warehouse = null): Warehouse
    {
        $this->warehouse = $warehouse ?: $this->warehouse;
        return $this->warehouse;
    }
}
