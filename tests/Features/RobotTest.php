<?php

declare(strict_types=1);

namespace App\Tests\Features;

use App\Enumerations\Command;
use App\Features\Controller;
use App\Features\Position;
use App\Features\Warehouse;
use App\Items\Package;
use App\Tests\TestBase;
use App\Items\Robot;

class RobotTest extends TestBase
{
    private Warehouse $warehouse;
    private Controller $controller;
    private Robot $robot;

    public function setUp(): void
    {
        parent::setUp();

        $this->warehouse = new Warehouse(10, 10);
        $this->controller = new Controller();
        $this->robot = new Robot();
        $this->robot->controller($this->controller);
        $this->warehouse->add($this->robot, new Position(0, 9));
    }

    public function testRobotMovesInCircle(): void
    {
        $this->assertEquals(0, $this->robot->position()->x());
        $this->assertEquals(9, $this->robot->position()->y());
        $this->controller->process('N E S W');
        $this->assertEquals(0, $this->robot->position()->x());
        $this->assertEquals(9, $this->robot->position()->y());
    }

    public function testRobotMovesInCircleWithCollision(): void
    {
        $this->assertEquals(0, $this->robot->position()->x());
        $this->assertEquals(9, $this->robot->position()->y());
        $this->controller->process('N E S W W W W W W W W W W N E S W');
        $this->assertEquals(0, $this->robot->position()->x());
        $this->assertEquals(9, $this->robot->position()->y());
    }

    public function testRobotStaysInsideBoundary(): void
    {
        $this->robot->position(new Position(0, 0));
        $this->assertEquals(0, $this->robot->position()->y());
        $this->controller->process('S S S S S S S S S S S S S S S S S S S');
        $this->assertEquals(9, $this->robot->position()->y());
    }

    public function testControllerRejectsInvalidCommands(): void
    {
        $mock = $this->createMock(Robot::class);
        $mock->expects($this->once())->method('input');

        // Swap out the controller dependency.
        $this->controller->connection($mock);
        $this->controller->process('X Y M O P E');
    }

    public function testRobotMovesNorth(): void
    {
        $this->controller->process('N');
        $this->assertEquals(8, $this->robot->position()->y());
    }

    public function testRobotMovesSouth(): void
    {
        $this->robot->position(new Position(0, 0));
        $this->controller->process('S');
        $this->assertEquals(1, $this->robot->position()->y());
    }

    public function testRobotMovesEast(): void
    {
        $this->controller->process('E');
        $this->assertEquals(1, $this->robot->position()->x());
    }

    public function testRobotMovesWest(): void
    {
        $this->robot->position(new Position(1, 0));
        $this->controller->process('W');
        $this->assertEquals(0, $this->robot->position()->x());
    }

    public function testRobotCanGrab(): void
    {
        $this->warehouse->add(new Package(), $this->robot->position());
        $this->assertTrue(
            $this->robot->grab(
                $this->robot->position(),
                $this->robot->warehouse()
            )
        );
    }

    public function testRobotWontDropWithEmptyHands(): void
    {
        $this->assertFalse(
            $this->robot->drop(
                $this->robot->position(),
                $this->robot->warehouse()
            )
        );
    }

    public function testRobotWillDrop(): void
    {
        $this->warehouse->add(new Package(), $this->robot->position());

        $this->robot->input(Command::GRAB);

        $this->assertTrue(
            $this->robot->drop(
                $this->robot->position(),
                $this->robot->warehouse()
            )
        );
    }

    public function testRobotWontDropOntop(): void
    {
        // Add item at current loc and pickup
        $this->warehouse->add(new Package(), $this->robot->position());
        $this->robot->input(Command::GRAB);

        // Add another item at 0,0, and move ot it.
        $this->warehouse->add(new Package(), new Position(0, 0));
        $this->robot->position(new Position(0, 0));

        // Try to drop on top and fail.
        $this->assertFalse(
            $this->robot->drop(
                $this->robot->position(),
                $this->robot->warehouse()
            )
        );
    }

    public function testRobotWillDropSomewhereElse(): void
    {
        // Add item at current loc and pickup
        $package = new Package();
        $this->warehouse->add($package, $this->robot->position());
        $this->robot->input(Command::GRAB);
        $this->robot->position(new Position(0, 1));

        // Try to drop on top and fail.
        $this->assertTrue(
            $this->robot->drop(
                $this->robot->position(),
                $this->robot->warehouse()
            )
        );

        $this->assertEquals($package->position(), new Position(0, 1));
    }


    public function testRobotGrabCommand(): void
    {
        $mock = $this->createMock(Robot::class);
        $mock->expects($this->once())->method('input');

        // Swap out the controller dependency.
        $this->controller->connection($mock);
        $this->controller->process('G');
    }

    public function testRobotDropCommand(): void
    {
        $mock = $this->createMock(Robot::class);
        $mock->expects($this->once())->method('input');

        // Swap out the controller dependency.
        $this->controller->connection($mock);
        $this->controller->process('D');
    }

    public function testPickupAndDropoff(): void
    {
        // Add item at current loc and pickup
        $package = new Package();
        $this->warehouse->add(new Package(), new Position(9, 0));
        $this->warehouse->add($package, new Position(5, 5));

        $this->controller->process('N N N N E E E E E G N N N N N E E E E D W D');

        $this->assertEquals($package->position(), new Position(8, 0));
    }
}
