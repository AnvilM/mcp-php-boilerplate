<?php

declare(strict_types=1);

namespace Application\Bootstrappers;

use Application\Tools\AbstractTool;
use Mcp\Server\Builder;

final class ToolsBootstrapper
{
    /** @var array<AbstractTool> **/
    private static array $tools = [
        
    ];
    
    public static function registerTools(Builder $builder): Builder {
        foreach (self::$tools as $tool) {
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