<?php

declare(strict_types=1);

namespace Application\Bootstrappers\ToolsBootstrapper;

use DI\Container;
use Mcp\Server\Builder;

final class ToolsBootstrapper
{

    public static function registerTools(Builder $builder, Container $container): Builder
    {
        foreach (new ToolsRegistry($container)->tools as $tool) {
            $builder->addTool(
                $tool,
                $tool->getName(),
                $tool->getDescription(),
                $tool->getAnnotations(),
                $tool->getInputSchema(),
                $tool->getIcons(),
                $tool->getMeta()
            );
        }

        return $builder;
    }


}