<?php

declare(strict_types=1);

namespace Application\Resources;

use Application\Platform\Primitives\AbstractResource;
use Mcp\Schema\Content\TextResourceContents;
use Mcp\Schema\JsonRpc\Error;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Request\ReadResourceRequest;
use Mcp\Schema\Result\ReadResourceResult;
use Mcp\Server\Session\SessionInterface;

final class ExampleResource extends AbstractResource
{

    protected string $name = "example_resource";

    protected string $uri = "example://example";

    protected ?string $mimeType = "text/plain";

    public function __invoke(ReadResourceRequest $request, SessionInterface $session): Response|Error
    {
        return new Response(
            $request->getId(),
            new ReadResourceResult([
                new TextResourceContents($this->uri, $this->mimeType, "Example resource"),
            ]));
    }

}