<?php

declare(strict_types=1);

use App\Features\Controller;
use App\Features\Position;
use App\Features\Warehouse;
use App\Items\Robot;

require_once __DIR__ . '/../vendor/autoload.php';

// Create a warehouse and a robot and a way to control it.
$warehouse = new Warehouse(10, 10);
$controller = new Controller();
$robot = new Robot();

// Connect the robot to the controller.
$robot->controller($controller);

// Add and position the robot bottom left.
$warehouse->add($robot, new Position(0, 9));

// CLI input.
echo "Domo arigato!" . PHP_EOL;
echo "Commands: N, S, E, W, exit" . PHP_EOL;

while (true) {
    echo "Input: ";
    $line = trim(fgets(STDIN));
    $controller->process($line);
    echo PHP_EOL;

    if (stristr($line, 'exit')) {
        echo "Ack.";
        break;
    }
}
