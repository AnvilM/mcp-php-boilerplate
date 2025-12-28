<?php

declare(strict_types=1);

namespace Application\Platform\Handlers\Prompt;

use Application\Platform\Collections\PromptsCollection;
use Mcp\Schema\JsonRpc\Request;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Request\ListPromptsRequest;
use Mcp\Schema\Result\ListPromptsResult;
use Mcp\Server\Handler\Request\RequestHandlerInterface;
use Mcp\Server\Session\SessionInterface;
use function assert;

/**
 * Handler for listing all prompts.
 *
 * @implements RequestHandlerInterface<ListPromptsResult>
 */
final readonly class ListPromptsHandler implements RequestHandlerInterface
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
     * @return bool True if the request is a ListPromptsRequest.
     */
    public function supports(Request $request): bool
    {
        return $request instanceof ListPromptsRequest;
    }

    /**
     * Handle the ListPromptsRequest and return the list of prompts.
     *
     * @param ListPromptsRequest $request The request to handle.
     * @param SessionInterface $session The user session.
     * @return Response<ListPromptsResult> Response containing the list of prompts.
     */
    public function handle(Request $request, SessionInterface $session): Response
    {
        assert($request instanceof ListPromptsRequest);

        return new Response(
            $request->getId(),
            new ListPromptsResult($this->prompts->toSchemaPromptArray(), null)
        );
    }
}
