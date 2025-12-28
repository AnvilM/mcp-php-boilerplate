<?php

declare(strict_types=1);

namespace Application\Registry;

use Application\Platform\Primitives\AbstractResource;
use Application\Resources\ExampleResource;

/**
 * Registry of available resources.
 *
 * This class holds a static list of resource classes.
 */
final class Resources
{
    /**
     * List of resource classes.
     *
     * @var array<class-string<AbstractResource>> Array of resource class names
     */
    public static array $resources = [
        ExampleResource::class
    ];
}
