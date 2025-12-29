<?php

declare(strict_types=1);

namespace Application;

use Application\Bootloaders\Application\ApplicationBootloader;
use Application\Bootloaders\Context;
use Application\Bootloaders\Infrastructure\InfrastructureBootloader;
use DI\Container as DIContainer;
use DI\DependencyException;
use DI\NotFoundException;
use Mcp\Server as McpServer;

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
     *
     *
     * @return McpServer Fully configured server instance
     * @throws NotFoundException No entry found for the given name
     *
     * @throws DependencyException Error while resolving the entry.
     */
    public static function createServer(): McpServer
    {
        /** @var Context<array{server: McpServer}> $applicationContext */
        $applicationContext = ApplicationBootloader::boot(new Context([]));

        /** @var Context<array{container: DIContainer}> $infrastructureContext */
        $infrastructureContext = InfrastructureBootloader::boot($applicationContext);
        
        return $infrastructureContext->get('server');
    }
}
