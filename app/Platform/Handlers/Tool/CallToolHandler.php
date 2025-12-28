<?php

declare(strict_types=1);

namespace Application\Platform\Handlers\Tool;

use Application\Platform\Collections\ToolCollection;
use Mcp\Schema\JsonRpc\Error;
use Mcp\Schema\JsonRpc\Request;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Request\CallToolRequest;
use Mcp\Server\Handler\Request\RequestHandlerInterface;
use Mcp\Server\Session\SessionInterface;

final readonly class CallToolRequestHandler implements RequestHandlerInterface
{
    public function __construct(private ToolCollection $tools)
    {
    }

    public function supports(Request $request): bool
    {
        return $request instanceof CallToolRequest;
    }

    public function handle(Request $request, SessionInterface $session): Response|Error
    {
        assert($request instanceof CallToolRequest);

        $tool = $this->tools->findByName($request->name);

        return $tool === null
            ? new Error($request->getId(), Error::METHOD_NOT_FOUND, "not found")
            : $tool($request, $session);


    }
}