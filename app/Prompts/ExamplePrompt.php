<?php

declare(strict_types=1);

namespace Application\Prompts;

use Mcp\Capability\Attribute\McpPrompt;
use Mcp\Schema\Content\PromptMessage;
use Mcp\Schema\Content\TextContent;
use Mcp\Schema\Enum\Role;

final class ExamplePrompt
{
    #[McpPrompt("example_prompt")]
    public function handle(): PromptMessage
    {
        return new PromptMessage(
            Role::User,
            new TextContent("example prompt message"),
        );
    }
}