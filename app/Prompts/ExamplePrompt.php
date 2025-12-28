<?php

declare(strict_types=1);

namespace Application\Prompts;

use Application\Platform\Primitives\AbstractPrompt;
use Mcp\Schema\Content\PromptMessage;
use Mcp\Schema\Content\TextContent;
use Mcp\Schema\Enum\Role;
use Mcp\Schema\JsonRpc\Error;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Request\GetPromptRequest;
use Mcp\Schema\Result\GetPromptResult;
use Mcp\Server\Session\SessionInterface;

final class ExamplePrompt extends AbstractPrompt
{
    protected string $name = "example_prompt";

    public function __invoke(GetPromptRequest $request, SessionInterface $session): Response|Error
    {
        return new Response(
            $request->getId(),
            new GetPromptResult([
                new PromptMessage(
                    Role::User,
                    new TextContent("example_message")
                )
            ])
        );
    }
}