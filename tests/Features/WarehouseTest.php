<?php

declare(strict_types=1);

namespace App\Tests\Features;

use App\Features\Position;
use App\Features\Warehouse;
use App\Items\Package;
use App\Items\Robot;
use App\Tests\TestBase;

class WarehouseTest extends TestBase
{
    private Warehouse $warehouse;
    public function setUp(): void
    {
        parent::setUp();

        $this->warehouse = new Warehouse(10, 10);
    }

    public function testDeletingOneItemDeletesOnlyThatItem(): void
    {
        $deleting = new Package();

        $this->warehouse->add(new Package(), new Position(0, 0));
        $this->warehouse->add($deleting, new Position(0, 1));
        $this->warehouse->add(new Package(), new Position(0, 2));
        $this->warehouse->add(new Package(), new Position(0, 3));
        $this->warehouse->add(new Robot(), new Position(0, 4));

        $this->warehouse->remove($deleting);

        $this->assertCount(4, $this->warehouse->items());
    }
}
