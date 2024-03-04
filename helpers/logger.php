<?php

/**
 * @file
 * This file is included very early. Logger utility function.
 *
 * @see composer.json (autoload.files)
 * @see https://getcomposer.org/doc/04-schema.md#files
 */

declare(strict_types=1);

use App\Logger\Log;

/**
 * Get the logger instance.
 *
 * @param string|null $channel
 *   The channel name of the logger. Defaults to app.
 *
 * @return \App\Logger\Log
 */
function logger(?string $channel = null): Log
{
    return Log::get($channel ?: 'app');
}
