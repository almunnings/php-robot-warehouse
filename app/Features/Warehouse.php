<?php

declare(strict_types=1);

namespace App\Features;

use App\Contracts\HasId;
use App\Contracts\HasPosition;
use App\Contracts\HasWarehouse;
use App\Features\Position;

class Warehouse
{
    /**
     * Create a new warehouse.
     *
     * @param int $width Warehouse width
     * @param int $height Warehouse height
     * @param HasId&HasPosition&HasWarehouse[] $items Items in the warehouse
     */
    public function __construct(
        public readonly int $width,
        public readonly int $height,
        protected array $items = []
    ) {
    }

    public function items(): array
    {
        return $this->items;
    }

    /**
     * Add an item to the warehouse.
     */
    public function add(HasId&HasPosition&HasWarehouse $item, Position $position): void
    {
        $item->warehouse($this);
        $item->position($position);
        $this->items[] = $item;
    }

    /**
     * Remove an item from the warehouse.
     */
    public function remove(HasId&HasPosition&HasWarehouse $find): void
    {
        $this->items = array_filter(
            $this->items,
            fn (HasId $item) => $find->id() !== $item->id()
        );
    }

    /**
     * Find items at a position.
     */
    public function find(Position $position): array
    {
        return array_filter(
            $this->items,
            fn($item) => $item->position()->equals($position)
        );
    }
}
