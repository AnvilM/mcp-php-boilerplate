<?php

declare(strict_types=1);

namespace Application\Tools;

use Mcp\Capability\Attribute\McpTool;
use Psr\Log\LoggerInterface;

final class ExampleTool
{
    public function __construct(LoggerInterface $logger)
    {
        $logger->error('Example tool');
    }

    #[McpTool("example_tool", "Just example tool")]
    public function handle(string $name): string
    {
        return "Hello $name";
    }
}