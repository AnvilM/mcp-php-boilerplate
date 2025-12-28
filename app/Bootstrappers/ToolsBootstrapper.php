<?php

declare(strict_types=1);

namespace Application\Bootstrappers;

use Application\Platform\Collections\ToolsCollection;
use Application\Platform\Handlers\Tool\CallToolHandler;
use Application\Platform\Handlers\Tool\ListToolsHandler;
use Application\Registry\Tools;
use DI\Container;
use Mcp\Server\Builder;

final class ToolsBootstrapper
{

    public static function registerTools(Builder $builder, Container $container): void
    {
        $tools = self::getTools($container);

        $builder->addRequestHandlers([
            new ListToolsHandler($tools),
            new CallToolHandler($tools)
        ]);
    }

    private static function getTools(Container $container): ToolsCollection
    {
        $tools = new ToolsCollection([]);

        foreach (Tools::$tools as $tool) {
            $tools->push($container->get($tool));
        }

        return $tools;
    }


}