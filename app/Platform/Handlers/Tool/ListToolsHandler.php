<?php

declare(strict_types=1);

namespace Application\Platform\Handlers\Tool;

use Application\Platform\Collections\ToolsCollection;
use Mcp\Schema\JsonRpc\Request;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Request\ListToolsRequest;
use Mcp\Schema\Result\ListToolsResult;
use Mcp\Server\Handler\Request\RequestHandlerInterface;
use Mcp\Server\Session\SessionInterface;
use function assert;

/**
 * Handler for listing tools.
 *
 * @implements RequestHandlerInterface<ListToolsResult>
 */
final readonly class ListToolsHandler implements RequestHandlerInterface
{
    /**
     * @param ToolsCollection $tools Collection of available tools.
     */
    public function __construct(private ToolsCollection $tools)
    {
    }

    /**
     * Determine if this handler supports the given request.
     *
     * @param Request $request The request to check.
     * @return bool True if the request is a ListToolsRequest.
     */
    public function supports(Request $request): bool
    {
        return $request instanceof ListToolsRequest;
    }

    /**
     * Handle the ListToolsRequest and return the result.
     *
     * @param ListToolsRequest $request The request to handle.
     * @param SessionInterface $session The user session.
     * @return Response<ListToolsResult> Response containing the list of tools.
     */
    public function handle(Request $request, SessionInterface $session): Response
    {
        assert($request instanceof ListToolsRequest);

        return new Response(
            $request->getId(),
            new ListToolsResult($this->tools->toSchemaToolArray(), null)
        );
    }
}