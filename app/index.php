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

// Create a controller for the robot.
$robot->controller($controller);

// Position the robot bottom left initially.
$warehouse->add($robot, new Position(0, 9));

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
