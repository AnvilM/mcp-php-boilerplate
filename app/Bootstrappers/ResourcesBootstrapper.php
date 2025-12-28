<?php

declare(strict_types=1);

namespace Application\Bootstrappers;

use Application\Platform\Collections\ResourcesCollection;
use Application\Platform\Handlers\Resource\ListResourcesHandler;
use Application\Platform\Handlers\Resource\ReadResourceHandler;
use Application\Registry\Resources;
use DI\Container;
use Mcp\Server\Builder;

final class ResourcesBootstrapper
{

    public static function registerResources(Builder $builder, Container $container): void
    {
        $resources = self::getResources($container);

        $builder->addRequestHandlers([
            new ListResourcesHandler($resources),
            new ReadResourceHandler($resources),
        ]);
    }

    private static function getResources(Container $container): ResourcesCollection
    {
        $resources = new ResourcesCollection([]);

        foreach (Resources::$resources as $resource) {
            $resources->push($container->get($resource));
        }

        return $resources;
    }
}