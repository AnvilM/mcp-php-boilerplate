<?php

declare(strict_types=1);

namespace Application\Platform\Handlers\Resource;

use Application\Platform\Collections\ResourcesCollection;
use Mcp\Schema\JsonRpc\Error;
use Mcp\Schema\JsonRpc\Request;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Request\ReadResourceRequest;
use Mcp\Server\Handler\Request\RequestHandlerInterface;
use Mcp\Server\Session\SessionInterface;

final readonly class ReadResourceHandler implements RequestHandlerInterface
{
    public function __construct(private ResourcesCollection $resources)
    {
    }

    public function supports(Request $request): bool
    {
        return $request instanceof ReadResourceRequest;
    }

    public function handle(Request $request, SessionInterface $session): Response|Error
    {
        assert($request instanceof ReadResourceRequest);

        $resource = $this->resources->findByUri($request->uri);

        return $resource === null
            ? new Error($request->getId(), Error::METHOD_NOT_FOUND, "not found")
            : $resource($request, $session);


    }
}