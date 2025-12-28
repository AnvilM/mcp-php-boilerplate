<?php

declare(strict_types=1);

namespace Application\Registry;

use Application\Platform\Primitives\AbstractTool;
use Application\Tools\ExampleTool;

/**
 * Registry of available tools.
 *
 * This class holds a static list of tool classes.
 */
final class Tools
{
    /**
     * List of tool classes.
     *
     * @var array<class-string<AbstractTool>> Array of tool class names
     */
    public static array $tools = [
        ExampleTool::class
    ];
}
