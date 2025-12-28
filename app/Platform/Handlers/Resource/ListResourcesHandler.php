<?php

declare(strict_types=1);

namespace Application\Platform\Handlers\Resource;

use Application\Platform\Collections\ResourcesCollection;
use Mcp\Schema\JsonRpc\Error;
use Mcp\Schema\JsonRpc\Request;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Request\ListResourcesRequest;
use Mcp\Schema\Result\ListResourcesResult;
use Mcp\Server\Handler\Request\RequestHandlerInterface;
use Mcp\Server\Session\SessionInterface;
use function assert;

final readonly class ListResourcesHandler implements RequestHandlerInterface
{
    public function __construct(private ResourcesCollection $resources)
    {
    }

    public function supports(Request $request): bool
    {
        return $request instanceof ListResourcesRequest;
    }

    public function handle(Request $request, SessionInterface $session): Response|Error
    {
        assert($request instanceof ListResourcesRequest);

        return new Response($request->getId(), new ListResourcesResult($this->resources->toSchemaResourceArray(), null));
    }

}