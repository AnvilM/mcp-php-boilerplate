<?php

declare(strict_types=1);

namespace Application\Bootstrappers;

use Application\Resources\AbstractResource;
use Mcp\Server\Builder;

final class ResourcesBootstrapper
{
    /** @var array<AbstractResource> **/
    private static array $resources = [
        
    ];
    
    public static function registerResources(Builder $builder): Builder {
        foreach (self::$resources as $resource) {
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
}