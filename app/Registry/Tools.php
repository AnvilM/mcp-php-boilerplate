<?php

declare(strict_types=1);

namespace Application\Tools;

use Application\Platform\Primitives\Tools\AbstractTool;
use Application\Tools\Tools\SumTool;

final class ToolsRegistry
{
    /** @var array<class-string<AbstractTool>> */
    public static array $toolsRegistry = [
        SumTool::class
    ];
}