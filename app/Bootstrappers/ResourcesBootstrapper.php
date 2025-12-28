<?php

declare(strict_types=1);

namespace Application\Bootstrappers;

use Application\Platform\Collections\ResourcesCollection;
use Application\Platform\Handlers\Resource\ListResourcesHandler;
use Application\Platform\Handlers\Resource\ReadResourceHandler;
use Application\Registry\Resources;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Mcp\Server\Builder;

/**
 * Resources bootstrapper.
 *
 * Responsible for resolving resource instances from the DI container
 * and registering resource-related request handlers.
 */
final class ResourcesBootstrapper
{
    /**
     * Registers resource handlers in the server builder.
     *
     * @param Builder $builder Server builder instance
     * @param Container $container Dependency injection container
     *
     * @return void
     *
     * @throws NotFoundException   No entry found for the given identifier
     * @throws DependencyException Error while resolving a container entry
     */
    public static function registerResources(Builder $builder, Container $container): void
    {
        $resources = self::getResources($container);

        $builder->addRequestHandlers([
            new ListResourcesHandler($resources),
            new ReadResourceHandler($resources),
        ]);
    }

    /**
     * Resolves resource instances from the DI container.
     *
     * @param Container $container Dependency injection container
     *
     * @return ResourcesCollection Collection of resolved resources
     *
     * @throws NotFoundException   No entry found for the given identifier
     * @throws DependencyException Error while resolving a container entry
     */
    private static function getResources(Container $container): ResourcesCollection
    {
        $resources = new ResourcesCollection([]);

        foreach (Resources::$resources as $resource) {
            $resources->push($container->get($resource));
        }

        return $resources;
    }
}
