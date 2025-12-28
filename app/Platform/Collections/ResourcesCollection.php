<?php

declare(strict_types=1);

namespace Application\Platform\Collections;

use Application\Platform\Primitives\AbstractResource;
use InvalidArgumentException;

final class ResourcesCollection
{
    /** @var array<AbstractResource> */
    private array $resources = [];

    /** @param array<AbstractResource> $resources */
    public function __construct(array $resources)
    {
        foreach ($resources as $resource) {
            if (!($resource instanceof AbstractResource)) throw new InvalidArgumentException("Only AbstractResource allowed");
            $this->resources[] = $resource;
        }
    }

    public function push(AbstractResource $resource): void
    {
        $this->resources[] = $resource;
    }

    public function toSchemaResourceArray(): array
    {
        return array_map(
            static fn(AbstractResource $resource) => $resource->toSchemaResource(),
            $this->resources
        );
    }

    public function findByUri(string $uri): ?AbstractResource
    {
        return array_find($this->resources, fn($resource) => $resource->getUri() === $uri);

    }
}