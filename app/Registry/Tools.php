<?php

declare(strict_types=1);

namespace Application\Registry;

use Application\Platform\Primitives\AbstractTool;
use Application\Tools\ExampleTool;

final class Tools
{
    /** @var array<class-string<AbstractTool>> */
    public static array $tools = [
        ExampleTool::class
    ];
}