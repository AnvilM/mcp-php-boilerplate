<?php

declare(strict_types=1);

namespace Application\Registry;

use Application\Platform\Primitives\AbstractResource;
use Application\Resources\ExampleResource;

final class Resources
{
    /** @var array<class-string<AbstractResource>> */
    public static array $resources = [
        ExampleResource::class
    ];
}