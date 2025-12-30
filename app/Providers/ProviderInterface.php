<?php

declare(strict_types=1);

namespace Application\Providers;

/**
 * Interface for a container provider.
 *
 * Providers define dependencies to be registered in a DI container.
 */
interface ProviderInterface
{
    /**
     * Registers provider services in the container.
     *
     * Returns an associative array where the key is the class or interface name
     * and the value is the corresponding instance.
     *
     * @return array<string, mixed> Associative array of class/interface => instance
     */
    public static function register(): array;
}
