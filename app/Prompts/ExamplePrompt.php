<?php

declare(strict_types=1);

namespace Application\Prompts;

use Application\Platform\Primitives\AbstractPrompt;
use Mcp\Schema\JsonRpc\Error;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Request\GetPromptRequest;
use Mcp\Server\Session\SessionInterface;

final readonly class ExamplePrompt extends AbstractPrompt
{

    public function __invoke(GetPromptRequest $request, SessionInterface $session): Response|Error
    {
        // TODO: Implement __invoke() method.
    }
}