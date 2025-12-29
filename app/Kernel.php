<?php

declare(strict_types=1);

namespace Application;

use Application\Bootloaders\Application\ApplicationBootloader;
use Application\Bootloaders\Context;
use Application\Bootloaders\Infrastructure\InfrastructureBootloader;
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
     * @return McpServer Fully configured server instance
     *
     *
     * @throws DependencyException Error while resolving the entry.
     * @throws NotFoundException No entry found for the given name
     */
    public static function createServer(): McpServer
    {
        return ApplicationBootloader::boot(
            InfrastructureBootloader::boot(
                new Context()
            )
        )->get('server');
    }
}