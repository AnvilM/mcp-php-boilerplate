<?php

declare(strict_types=1);

namespace Application\Bootloaders\Infrastructure;

use Application\Bootloaders\BootloaderInterface;
use Application\Bootloaders\Context;
use DI\Container as DIContainer;

/**
 * Bootloader responsible for setting up the dependency injection container.
 * Starts from an empty context and adds the fully configured DI container.
 *
 * @implements BootloaderInterface<array{}, array{container: DIContainer}>
 */
final readonly class InfrastructureBootloader implements BootloaderInterface
{
    /**
     * Creates and configures the DI container, then places it into the context.
     *
     * @param Context<array{}> $context Empty initial context
     * @return Context<array{container: DIContainer}> Context with initialized container
     */
    public static function boot(Context $context): Context
    {
        $container = Container::createContainer(
            Providers::getProviders()
        );

        return new Context([
            "container" => $container,
        ]);
    }
}