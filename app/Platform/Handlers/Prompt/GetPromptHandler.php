<?php

declare(strict_types=1);

namespace Application\Platform\Handlers\Prompt;

use Application\Platform\Collections\PromptsCollection;
use Mcp\Schema\JsonRpc\Error;
use Mcp\Schema\JsonRpc\Request;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Request\GetPromptRequest;
use Mcp\Schema\Result\GetPromptResult;
use Mcp\Server\Handler\Request\RequestHandlerInterface;
use Mcp\Server\Session\SessionInterface;

/**
 * Handler for retrieving a single prompt by name.
 *
 * @implements RequestHandlerInterface<GetPromptResult>
 */
final readonly class GetPromptHandler implements RequestHandlerInterface
{
    /**
     * @param PromptsCollection $prompts Collection of available prompts.
     */
    public function __construct(private PromptsCollection $prompts)
    {
    }

    /**
     * Check if this handler supports the given request.
     *
     * @param Request $request The request to check.
     * @return bool True if the request is a GetPromptRequest.
     */
    public function supports(Request $request): bool
    {
        return $request instanceof GetPromptRequest;
    }

    /**
     * Handle the GetPromptRequest and return the prompt or an error.
     *
     * @param GetPromptRequest $request The request to handle.
     * @param SessionInterface $session The user session.
     * @return Response<GetPromptResult>|Error Response containing the prompt or an error if not found.
     */
    public function handle(Request $request, SessionInterface $session): Response|Error
    {
        assert($request instanceof GetPromptRequest);

        $prompt = $this->prompts->findByName($request->name);

        return $prompt === null
            ? new Error($request->getId(), Error::METHOD_NOT_FOUND, "not found")
            : $prompt($request, $session);
    }
}
