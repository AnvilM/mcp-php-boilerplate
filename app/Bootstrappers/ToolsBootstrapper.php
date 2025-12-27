<?php

declare(strict_types=1);

namespace Application\Bootstrappers;

use Application\Tools\AbstractTool;
use LogicException;
use Mcp\Server\Builder;

final class ToolsBootstrapper
{
    /** @var array<AbstractTool> * */
    private static array $tools = [

    ];

    public static function registerTools(Builder $builder): Builder
    {
        foreach (self::$tools as $tool) {

            self::assertToolIsCallable($tool);

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

    private static function assertToolIsCallable(AbstractTool $tool): void
    {
        if (!is_callable($tool)) {
            throw new LogicException("Tool " . get_class($tool) . " must be a callable");
        }
    }
}