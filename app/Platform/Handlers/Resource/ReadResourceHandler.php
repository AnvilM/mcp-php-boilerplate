<?php

declare(strict_types=1);

namespace Application\Platform\Handlers\Resource;

use Application\Platform\Collections\ResourcesCollection;
use Mcp\Schema\JsonRpc\Error;
use Mcp\Schema\JsonRpc\Request;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Request\ReadResourceRequest;
use Mcp\Schema\Result\ReadResourceResult;
use Mcp\Server\Handler\Request\RequestHandlerInterface;
use Mcp\Server\Session\SessionInterface;

/**
 * Handler for reading a single resource by its URI.
 *
 * @implements RequestHandlerInterface<ReadResourceResult>
 */
final readonly class ReadResourceHandler implements RequestHandlerInterface
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
     * @return bool True if the request is a ReadResourceRequest.
     */
    public function supports(Request $request): bool
    {
        return $request instanceof ReadResourceRequest;
    }

    /**
     * Handle the ReadResourceRequest and return the resource or an error.
     *
     * @param ReadResourceRequest $request The request to handle.
     * @param SessionInterface $session The user session.
     * @return Response<ReadResourceResult>|Error Response containing the resource or an error if not found.
     */
    public function handle(Request $request, SessionInterface $session): Response|Error
    {
        assert($request instanceof ReadResourceRequest);

        $resource = $this->resources->findByUri($request->uri);

        return $resource === null
            ? new Error($request->getId(), Error::METHOD_NOT_FOUND, "not found")
            : $resource($request, $session);
    }
}
