<?php

declare(strict_types=1);

namespace Application\Platform\Handlers\Prompt;

use Application\Platform\Collections\PromptsCollection;
use Mcp\Schema\JsonRpc\Error;
use Mcp\Schema\JsonRpc\Request;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Request\GetPromptRequest;
use Mcp\Server\Handler\Request\RequestHandlerInterface;
use Mcp\Server\Session\SessionInterface;

final readonly class GetPromptHandler implements RequestHandlerInterface
{
    public function __construct(private PromptsCollection $prompts)
    {
    }

    public function supports(Request $request): bool
    {
        return $request instanceof GetPromptRequest;
    }

    public function handle(Request $request, SessionInterface $session): Response|Error
    {
        assert($request instanceof GetPromptRequest);

        $prompt = $this->prompts->findByName($request->name);

        return $prompt === null
            ? new Error($request->getId(), Error::METHOD_NOT_FOUND, "not found")
            : $prompt($request, $session);


    }
}