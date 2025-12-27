<?php

declare(strict_types=1);

namespace Application\Bootstrappers;

use DI\Container;
use Mcp\Server\Builder;

final readonly class ContainerBootstrapper
{
    /** @param array<string, mixed> $providers */
    public static function registerContainer(Builder $builder, array $providers): void
    {
        $builder->setContainer(
            new Container(
                $providers
            )
        );
    }
}