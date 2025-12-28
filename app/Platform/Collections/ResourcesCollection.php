<?php

declare(strict_types=1);

namespace Application\Platform\Collections;

use Application\Platform\Primitives\AbstractResource;
use InvalidArgumentException;
use Mcp\Schema\Resource;


/**
 * Collection of resources.
 */
final class ResourcesCollection
{
    /**
     * Array of resources.
     *
     * @var AbstractResource[]
     */
    private array $resources = [];

    /**
     * Initializes the collection with an array of resources.
     *
     * @param AbstractResource[] $resources Array of AbstractResource instances
     * @throws InvalidArgumentException If any element is not an AbstractResource
     */
    public function __construct(array $resources)
    {
        foreach ($resources as $resource) {
            if (!($resource instanceof AbstractResource)) {
                throw new InvalidArgumentException('Only AbstractResource allowed');
            }
            $this->resources[] = $resource;
        }
    }

    /**
     * Adds a resource to the collection.
     *
     * @param AbstractResource $resource Resource instance to add
     * @return void
     */
    public function push(AbstractResource $resource): void
    {
        $this->resources[] = $resource;
    }

    /**
     * Converts the collection to an array of resource schemas.
     *
     * @return Resource[] Array of Resource schema objects
     */
    public function toSchemaResourceArray(): array
    {
        return array_map(
            static fn(AbstractResource $resource): Resource => $resource->toSchemaResource(),
            $this->resources
        );
    }

    /**
     * Finds a resource by its URI.
     *
     * @param string $uri URI of the resource
     * @return AbstractResource|null The resource if found, or null
     */
    public function findByUri(string $uri): ?AbstractResource
    {
        /** @var AbstractResource|null $result */
        $result = array_find($this->resources, fn(AbstractResource $resource) => $resource->getUri() === $uri);

        return $result;
    }

    /**
     * Returns all resources in the collection.
     *
     * @return AbstractResource[] Array of all resources
     */
    public function all(): array
    {
        return $this->resources;
    }
}