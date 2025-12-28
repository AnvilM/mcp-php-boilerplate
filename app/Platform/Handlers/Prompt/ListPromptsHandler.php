<?php

declare(strict_types=1);

namespace Application\Platform\Handlers\Prompt;

use Application\Platform\Collections\PromptsCollection;
use Mcp\Schema\JsonRpc\Error;
use Mcp\Schema\JsonRpc\Request;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Request\ListPromptsRequest;
use Mcp\Schema\Result\ListPromptsResult;
use Mcp\Server\Handler\Request\RequestHandlerInterface;
use Mcp\Server\Session\SessionInterface;
use function assert;

final readonly class ListPromptsHandler implements RequestHandlerInterface
{
    public function __construct(private PromptsCollection $prompts)
    {
    }

    public function supports(Request $request): bool
    {
        return $request instanceof ListPromptsRequest;
    }

    public function handle(Request $request, SessionInterface $session): Response|Error
    {
        assert($request instanceof ListPromptsRequest);

        return new Response($request->getId(), new ListPromptsResult($this->prompts->toSchemaPromptArray(), null));
    }

}