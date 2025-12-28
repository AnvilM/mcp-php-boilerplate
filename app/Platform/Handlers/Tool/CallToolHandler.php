<?php

declare(strict_types=1);

namespace Application\Platform\Handlers\Tool;

use Application\Platform\Collections\ToolsCollection;
use Mcp\Schema\JsonRpc\Error;
use Mcp\Schema\JsonRpc\Request;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Request\CallToolRequest;
use Mcp\Schema\Result\CallToolResult;
use Mcp\Server\Handler\Request\RequestHandlerInterface;
use Mcp\Server\Session\SessionInterface;

/**
 * Handler for calling a specific tool.
 *
 * @implements RequestHandlerInterface<CallToolResult>
 */
final readonly class CallToolHandler implements RequestHandlerInterface
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
     * @return bool True if the request is a CallToolRequest.
     */
    public function supports(Request $request): bool
    {
        return $request instanceof CallToolRequest;
    }

    /**
     * Handle the CallToolRequest and return the result or an error.
     *
     * @param CallToolRequest $request The tool call request.
     * @param SessionInterface $session The user session.
     * @return Response<CallToolResult>|Error Response containing the tool result, or an error if tool not found.
     */
    public function handle(Request $request, SessionInterface $session): Response|Error
    {
        assert($request instanceof CallToolRequest);

        $tool = $this->tools->findByName($request->name);

        return $tool === null
            ? new Error($request->getId(), Error::METHOD_NOT_FOUND, "not found")
            : $tool($request, $session);
    }
}
