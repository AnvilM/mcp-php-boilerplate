<?php

declare(strict_types=1);

namespace Application\Tools;

use Application\Platform\Primitives\AbstractTool;
use Mcp\Schema\Content\TextContent;
use Mcp\Schema\JsonRpc\Error;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Request\CallToolRequest;
use Mcp\Schema\Result\CallToolResult;
use Mcp\Server\Session\SessionInterface;

final class ExampleTool extends AbstractTool
{
    protected string $name = 'example_tool';

    protected ?string $description = "Example tool that returns 'Hello {name}!'.";

    protected array $inputSchema = [
        'type' => 'object',
        'properties' => [
            'name' => ['type' => 'string']
        ],
        'required' => ['name']
    ];

    public function __invoke(CallToolRequest $request, SessionInterface $session): Response|Error
    {
        return new Response(
            $request->getId(),
            new CallToolResult([
                new TextContent("Hello " . $request->arguments['name'] . "!"),
            ])
        );
    }


}