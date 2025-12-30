<?php

declare(strict_types=1);

namespace Application\Tools;

use Mcp\Capability\Attribute\McpTool;

final class ExampleTool
{
    #[McpTool("example_tool", "Just example tool")]
    public function handle(string $name): string
    {
        return "Hello $name";
    }
}
