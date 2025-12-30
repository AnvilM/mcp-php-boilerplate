<?php

declare(strict_types=1);

namespace Application\Bootloaders\Environment;

use Application\Bootloaders\BootloaderInterface;
use Application\Bootloaders\Context;
use Dotenv\Dotenv;

/**
 * Loads environment variables from a .env file.
 *
 * This class provides a single static method to safely load environment variables
 * using vlucas/phpdotenv. The .env file is expected to be located three levels
 * above this file's directory.
 *
 * @implements BootloaderInterface<array{}, array{}>
 */
final readonly class EnvironmentBootloader implements BootloaderInterface
{
    /**
     * Loads environment variables from the .env file.
     *
     * Uses safeLoad(), so no error is thrown if the .env file is missing.
     *
     * @param Context<array{}> $context Empty context
     *
     * @return Context<array{}> Empty context
     */
    public static function boot(Context $context): Context
    {
        Dotenv::createImmutable(dirname(__DIR__, 3))->safeLoad();

        return $context;
    }
}
