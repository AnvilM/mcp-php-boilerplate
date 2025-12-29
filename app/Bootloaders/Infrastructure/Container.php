<?php

declare(strict_types=1);

namespace Application\Bootloaders\Infrastructure;

use DI\Container as DiContainer;

/**
 * Container bootstrapper.
 *
 * Responsible for creating and registering the DI container
 * in the server builder.
 */
final readonly class Container
{
    /**
     * Creates and registers the DI container.
     *
     * @param array<string, mixed> $providers Provider definitions
     *
     * @return DiContainer Initialized DI container
     */
    public static function createContainer(array $providers): DiContainer
    {
        return new DiContainer($providers);
    }
}
