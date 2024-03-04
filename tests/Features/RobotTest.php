<?php

declare(strict_types=1);

namespace App\Tests\Features;

use App\Features\Controller;
use App\Features\Position;
use App\Features\Warehouse;
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
}
