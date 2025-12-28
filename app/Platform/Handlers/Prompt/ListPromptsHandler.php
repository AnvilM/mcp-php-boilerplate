<?php

declare(strict_types=1);

namespace Application\Platform\Handlers\Tool;

use Application\Platform\Collections\ToolCollection;
use Mcp\Schema\JsonRpc\Error;
use Mcp\Schema\JsonRpc\Request;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Request\ListToolsRequest;
use Mcp\Schema\Result\ListToolsResult;
use Mcp\Server\Handler\Request\RequestHandlerInterface;
use Mcp\Server\Session\SessionInterface;
use function assert;

final readonly class ListToolsHandler implements RequestHandlerInterface
{
    public function __construct(private ToolCollection $tools)
    {
    }

    public function supports(Request $request): bool
    {
        return $request instanceof ListToolsRequest;
    }

    public function handle(Request $request, SessionInterface $session): Response|Error
    {
        assert($request instanceof ListToolsRequest);

        return new Response($request->getId(), new ListToolsResult($this->tools->toSchemaToolArray(), null));
    }

}