<?php

declare(strict_types=1);

namespace App\Features\Logger;

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
     *
     * @var array
     */
    private static $instances;

    /**
     * A logger that can be used to log messages.
     *
     * @param string $name
     *  The name of the logger.
     *
     * @return void
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
     *
     * @param string $name
     *  The name of the logger.
     *
     * @return Log
     */
    public static function get(string $name): Log
    {
        return static::$instances[$name] ??= (new static($name));
    }
}
