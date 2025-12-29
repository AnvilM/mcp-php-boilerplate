<?php

declare(strict_types=1);

namespace Application\Bootloaders\Application;

use Application\Bootloaders\BootloaderInterface;
use Application\Bootloaders\Context;
use DI\Container as DIContainer;
use DI\DependencyException;
use DI\NotFoundException;
use Mcp\Server as McpServer;
use Psr\Log\LoggerInterface;

/**
 * Bootloader that sets up the main application server.
 * Requires a DI container in the input context and produces a server instance.
 *
 * @implements BootloaderInterface<array{container: DIContainer}, array{server: McpServer}>
 */
final readonly class ApplicationBootloader implements BootloaderInterface
{
    /**
     * Creates the MCP server instance using the logger resolved from the DI container.
     *
     * @param Context<array{container: DIContainer}> $context Context containing the DI container
     * @return Context<array{server: McpServer}> Context with initialized server instance
     *
     * @throws DependencyException Error while resolving the entry.
     * @throws NotFoundException No entry found for the given name
     */
    public static function boot(Context $context): Context
    {
        /** @var DIContainer $container */
        $container = $context->get('container');

        /** @var LoggerInterface $logger */
        $logger = $container->get(LoggerInterface::class);

        $server = Server::create($logger);

        return new Context([
            'server' => $server,
        ]);
    }
}