<?php

declare(strict_types=1);

namespace Application\Platform\Handlers\Resource;

use Application\Platform\Collections\ResourcesCollection;
use Mcp\Schema\JsonRpc\Request;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Request\ListResourcesRequest;
use Mcp\Schema\Result\ListResourcesResult;
use Mcp\Server\Handler\Request\RequestHandlerInterface;
use Mcp\Server\Session\SessionInterface;
use function assert;

/**
 * Handler for listing all resources.
 *
 * @implements RequestHandlerInterface<ListResourcesResult>
 */
final readonly class ListResourcesHandler implements RequestHandlerInterface
{
    /**
     * @param ResourcesCollection $resources Collection of available resources.
     */
    public function __construct(private ResourcesCollection $resources)
    {
    }

    /**
     * Check if this handler supports the given request.
     *
     * @param Request $request The request to check.
     * @return bool True if the request is a ListResourcesRequest.
     */
    public function supports(Request $request): bool
    {
        return $request instanceof ListResourcesRequest;
    }

    /**
     * Handle the ListResourcesRequest and return the list of resources.
     *
     * @param ListResourcesRequest $request The request to handle.
     * @param SessionInterface $session The user session.
     * @return Response<ListResourcesResult> Response containing the list of resources.
     */
    public function handle(Request $request, SessionInterface $session): Response
    {
        assert($request instanceof ListResourcesRequest);

        return new Response(
            $request->getId(),
            new ListResourcesResult($this->resources->toSchemaResourceArray(), null)
        );
    }
}
