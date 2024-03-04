<?php

/**
 * @file
 * This file is included very early. Load env.
 *
 * @see composer.json (autoload.files)
 * @see https://getcomposer.org/doc/04-schema.md#files
 */

declare(strict_types=1);

use Dotenv\Dotenv;

$dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../');
$dotenv->safeLoad();
