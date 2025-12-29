<?php

declare(strict_types=1);

namespace Application\Resources;

use Mcp\Capability\Attribute\McpResource;

final class ExampleResource
{
    #[McpResource("example://example", "example_resource", "Just example resource", "text/plain")]
    public function handle(): string
    {
        return "example resource";
    }

}