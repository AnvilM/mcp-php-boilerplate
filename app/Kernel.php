<?php

declare(strict_types=1);

namespace Application;

use Application\Bootstrappers\ContainerBootstrapper;
use Application\Bootstrappers\PromptsBootstrapper;
use Application\Bootstrappers\ProvidersBootstrapper;
use Application\Bootstrappers\ResourcesBootstrapper;
use Application\Bootstrappers\ServerBootstrapper;
use Application\Bootstrappers\ToolsBootstrapper;
use DI\DependencyException;
use DI\NotFoundException;
use Mcp\Server;


/**
 * Application kernel.
 *
 * Responsible for bootstrapping and building the application server.
 * Acts as the main entry point for server initialization.
 */
final readonly class Kernel
{
    /**
     * Creates and configures the application server instance.
     *
     * This method initializes the server builder, registers the DI container,
     * bootstraps core services, and registers tools, resources, and prompts.
     *
     * @return Server Fully configured server instance
     *
     * @throws NotFoundException   No entry found for the given identifier
     * @throws DependencyException Error while resolving a container entry
     */
    public static function createServer(): Server
    {
        $builder = Server::builder();

        $container = ContainerBootstrapper::registerContainer($builder, ProvidersBootstrapper::getProviders());

        ServerBootstrapper::bootstrap($builder, $container);

        ToolsBootstrapper::registerTools($builder, $container);

        ResourcesBootstrapper::registerResources($builder, $container);

        PromptsBootstrapper::registerPrompts($builder, $container);

        return $builder->build();
    }
}