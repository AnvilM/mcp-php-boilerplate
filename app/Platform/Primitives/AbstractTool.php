<?php /** @noinspection ALL */

declare(strict_types=1);

namespace Application\Platform\Primitives;

use Mcp\Schema\JsonRpc\Error;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Request\CallToolRequest;
use Mcp\Schema\Tool;
use Mcp\Schema\ToolAnnotations;
use Mcp\Server\Session\SessionInterface;

abstract class AbstractTool
{

    protected string $name;

    protected array $inputSchema;

    protected ?string $description = null;

    protected ?array $icons = null;

    protected ?array $meta = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getInputSchema(): array
    {
        return $this->inputSchema;
    }

    public function getIcons(): ?array
    {
        return $this->icons;
    }

    public function getMeta(): ?array
    {
        return $this->meta;
    }

    public abstract function __invoke(CallToolRequest $request, SessionInterface $session): Response|Error;

    public function toSchemaTool(): Tool
    {
        return new Tool(
            $this->name,
            $this->inputSchema,
            $this->description,
            $this->getAnnotations(),
            $this->icons,
            $this->meta
        );
    }

    public function getAnnotations(): ?ToolAnnotations
    {
        return null;
    }
}
