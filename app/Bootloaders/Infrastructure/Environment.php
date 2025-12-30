<?php

declare(strict_types=1);

namespace Application\Bootloaders\Infrastructure;

use Dotenv\Dotenv;

/**
 * Loads environment variables from a .env file.
 *
 * This class provides a single static method to safely load environment variables
 * using vlucas/phpdotenv. The .env file is expected to be located three levels
 * above this file's directory.
 */
final readonly class Environment
{
    /**
     * Loads environment variables from the .env file.
     *
     * Uses safeLoad(), so no error is thrown if the .env file is missing.
     *
     * @return void
     */
    public static function load(): void
    {
        Dotenv::createImmutable(dirname(__DIR__, 3))->safeLoad();
    }
}
