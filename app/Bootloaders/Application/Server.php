<?php

declare(strict_types=1);

namespace Application\Bootloaders\Application;

use Application\Config\ApplicationConfig\ApplicationConfig;
use DI\Container as DiContainer;
use Mcp\Schema\ServerCapabilities;
use Mcp\Server as McpServer;
use Mcp\Server\Session\InMemorySessionStore;
use Psr\Log\LoggerInterface;

/**
 * Server bootstrapper.
 *
 * Responsible for configuring core server settings such as
 * metadata, capabilities, session storage, and logging.
 */
final readonly class Server
{
    /**
     * Bootstraps the server with core configuration and services.
     *
     * Configures server information, capabilities, session storage,
     * and resolves the logger instance from the DI container.
     *
     * @param LoggerInterface $logger Logger
     * @param DiContainer $container Dependency injection container
     *
     * @return McpServer
     */
    public static function create(LoggerInterface $logger, DiContainer $container): McpServer
    {
        return McpServer::builder()
            ->setDiscovery(ApplicationConfig::baseDir() . "/app/", ['Tools', 'Resources', 'Prompts'])
            ->setServerInfo(ApplicationConfig::appName(), ApplicationConfig::appDescription())
            ->setCapabilities(new ServerCapabilities())
            ->setSession(new InMemorySessionStore())
            ->setContainer($container)
            ->setLogger($logger)
            ->build();

    }
}