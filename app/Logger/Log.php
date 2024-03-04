<?php

declare(strict_types=1);

namespace App\Logger;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Setup an app-wide log using Monolog.
 */
class Log extends Logger
{
    /**
     * The singleton logger instances.
     */
    private static array $instances;

    /**
     * A logger that can be used to log messages.
     */
    public function __construct(string $name)
    {
        parent::__construct($name);

        $path = [
            getenv('BASE_DIR'),
            getenv('LOG_STORAGE'),
            $this->getName() . '-' . date('Y-m-d') . '.log'
        ];

        $path = implode(DIRECTORY_SEPARATOR, $path);
        $this->pushHandler(new StreamHandler($path, Level::Debug));

        // Also output to console if not in phpunit
        if (getenv('APP_ENV') !== 'testing' && PHP_SAPI === 'cli') {
            $this->pushHandler(new StreamHandler('php://stdout', Level::Debug));
        }
    }

    /**
     * Get the logger instance.
     */
    public static function get(string $name): Log
    {
        return static::$instances[$name] ??= (new static($name));
    }
}
