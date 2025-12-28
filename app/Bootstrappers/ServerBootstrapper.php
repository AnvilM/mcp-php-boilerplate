<?php

declare(strict_types=1);

namespace Application\Bootstrappers;

use Application\Config\ApplicationConfig\ApplicationConfig;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Mcp\Schema\ServerCapabilities;
use Mcp\Server\Builder;
use Mcp\Server\Session\FileSessionStore;
use Psr\Log\LoggerInterface;

/**
 * Server bootstrapper.
 *
 * Responsible for configuring core server settings such as
 * metadata, capabilities, session storage, and logging.
 */
final readonly class ServerBootstrapper
{
    /**
     * Bootstraps the server with core configuration and services.
     *
     * Configures server information, capabilities, session storage,
     * and resolves the logger instance from the DI container.
     *
     * @param Builder $builder Server builder instance
     * @param Container $container Dependency injection container
     *
     * @return void
     *
     * @throws NotFoundException   No entry found for the given identifier
     * @throws DependencyException Error while resolving a container entry
     */
    public static function bootstrap(Builder $builder, Container $container): void
    {
        $builder
            ->setServerInfo(
                ApplicationConfig::appName(),
                ApplicationConfig::appDescription()
            )
            ->setCapabilities(
                new ServerCapabilities()
            )
            ->setSession(
                new FileSessionStore(
                    ApplicationConfig::baseDir() . '/sessions'
                )
            )
            ->setLogger(
                $container->get(LoggerInterface::class)
            );
    }
}