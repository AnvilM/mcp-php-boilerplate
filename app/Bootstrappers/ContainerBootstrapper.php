<?php

declare(strict_types=1);

namespace Application\Bootstrappers;

use DI\Container;
use Mcp\Server\Builder;

/**
 * Container bootstrapper.
 *
 * Responsible for creating and registering the DI container
 * in the server builder.
 */
final readonly class ContainerBootstrapper
{
    /**
     * Creates and registers the DI container.
     *
     * @param Builder $builder Server builder instance
     * @param array<string, mixed> $providers Provider definitions
     *
     * @return Container Initialized DI container
     */
    public static function registerContainer(Builder $builder, array $providers): Container
    {
        $container = new Container($providers);

        $builder->setContainer($container);

        return $container;
    }
}
