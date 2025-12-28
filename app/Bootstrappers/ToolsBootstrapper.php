<?php

declare(strict_types=1);

namespace Application\Bootstrappers;

use Application\Platform\Collections\ToolsCollection;
use Application\Platform\Handlers\Tool\CallToolHandler;
use Application\Platform\Handlers\Tool\ListToolsHandler;
use Application\Platform\Primitives\AbstractTool;
use Application\Registry\Tools;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Mcp\Server\Builder;

/**
 * Tools bootstrapper.
 *
 * Responsible for resolving tool instances from the DI container
 * and registering tool-related request handlers in the server.
 */
final class ToolsBootstrapper
{
    /**
     * Registers tool handlers in the server builder.
     *
     * Resolves all configured tools from the container, creates a tools collection,
     * and registers handlers responsible for listing and calling tools.
     * @param Builder $builder Server builder instance
     * @param Container $container Dependency injection container
     *
     * @return void
     *
     * @throws NotFoundException No entry found for the given name.
     * @throws DependencyException Error while resolving the entry.
     */
    public static function registerTools(Builder $builder, Container $container): void
    {
        $tools = self::getTools($container);

        $builder->addRequestHandlers([
            new ListToolsHandler($tools),
            new CallToolHandler($tools),
        ]);
    }

    /**
     * Resolves tool instances from the DI container.
     *
     * Iterates over the tool class registry and retrieves each tool
     * instance from the container.
     *
     * @param Container $container Dependency injection container.
     *
     * @return ToolsCollection Collection of resolved tools.
     *
     * @throws NotFoundException No entry found for the given name.
     * @throws DependencyException Error while resolving the entry.
     */
    private static function getTools(Container $container): ToolsCollection
    {
        $tools = new ToolsCollection([]);

        foreach (Tools::$tools as $tool) {
            /** @var AbstractTool $instance */
            $instance = $container->get($tool);

            $tools->push($instance);
        }

        return $tools;
    }
}
