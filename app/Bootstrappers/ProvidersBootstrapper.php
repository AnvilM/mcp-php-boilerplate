<?php

declare(strict_types=1);

namespace Application\Bootstrappers;

use Application\Registry\Providers;

/**
 * Providers bootstrapper.
 *
 * Responsible for collecting and merging provider definitions
 * for container initialization.
 */
final class ProvidersBootstrapper
{
    /**
     * Returns all provider definitions.
     *
     * Merges application-specific providers with global providers
     * and returns a flat associative array compatible with the DI container.
     *
     * @return array<string, mixed> Map of service identifiers to instances
     */
    public static function getProviders(): array
    {
        return array_merge(
            ...array_map(
                static fn(string $provider): array => $provider::register(),
                array_merge(Providers::$appProviders, Providers::$providers)
            )
        );
    }
}
