<?php

declare(strict_types=1);

namespace Application\Bootstrappers;

use Application\Resources\AbstractResource;
use LogicException;
use Mcp\Server\Builder;

final class ResourcesBootstrapper
{
    /** @var array<AbstractResource> * */
    private static array $resources = [

    ];

    public static function registerResources(Builder $builder): Builder
    {
        foreach (self::$resources as $resource) {

            self::assertResourceIsCallable($resource);

            $builder->addResource(
                $resource,
                $resource->getName(),
                $resource->getDescription(),
                $resource->getMimeType(),
                $resource->getSize(),
                $resource->getAnnotations(),
                $resource->getIcons(),
                $resource->getMeta()
            );
        }

        return $builder;
    }

    private static function assertResourceIsCallable(AbstractResource $resource): void
    {
        if (!is_callable($resource)) {
            throw new LogicException("Resource " . get_class($resource) . " must be a callable");
        }
    }
}