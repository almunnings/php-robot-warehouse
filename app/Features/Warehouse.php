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
     * The items in the warehouse.
     *
     * @var \App\Contracts\HasId&\App\Contracts\HasPosition[]
     */
    protected array $items = [];

    public function __construct(
        private int $width,
        private int $height
    ) {
    }

    public function width(): int
    {
        return $this->width;
    }

    public function height(): int
    {
        return $this->height;
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
    public function remove(HasId&HasPosition&HasWarehouse $item): void
    {
        $this->items = array_filter(
            $this->items,
            fn (HasId $item) => $item->id() !== $item->id()
        );
    }

    /**
     * Find items at a position.
     */
    public function find(Position $position): array
    {
        return array_filter(
            $this->items,
            fn($item) => $item instanceof HasPosition && $item->position()->equals($position)
        );
    }
}
