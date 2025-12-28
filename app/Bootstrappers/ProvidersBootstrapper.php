<?php

declare(strict_types=1);

namespace Application\Bootstrappers;

use Application\Registry\Providers;

final class ProvidersBootstrapper
{

    /** @return array<string, mixed> */
    public static function getProviders(): array
    {
        return array_merge(
            ...array_map(
                fn($provider) => $provider::register(),
                array_merge(Providers::$appProviders, Providers::$providers)
            )
        );
    }
}