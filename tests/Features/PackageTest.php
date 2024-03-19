<?php

declare(strict_types=1);

namespace App\Tests\Features;

use App\Features\Position;
use App\Features\Warehouse;
use App\Items\Package;
use App\Tests\TestBase;

class PackageTest extends TestBase
{
    private Warehouse $warehouse;
    private Package $package;

    public function setUp(): void
    {
        parent::setUp();

        $this->package = new Package();
        $this->warehouse = new Warehouse(10, 10);
        $this->warehouse->add($this->package, new Position(0, 9));
    }

    public function testPackageHasWarehouse(): void
    {
        $this->assertEquals($this->warehouse, $this->package->warehouse());
    }

    public function testPackageIsAtPosition(): void
    {
        $this->assertEquals(0, $this->package->position()->x());
        $this->assertEquals(9, $this->package->position()->y());
    }
}
