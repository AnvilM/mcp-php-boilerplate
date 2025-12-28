<?php /** @noinspection ALL */

declare(strict_types=1);

namespace Application\Platform\Primitives;

use Mcp\Schema\JsonRpc\Error;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Request\ReadResourceRequest;
use Mcp\Schema\Resource;
use Mcp\Schema\ToolAnnotations;
use Mcp\Server\Session\SessionInterface;

abstract class AbstractResource
{

    protected string $uri = "";

    protected string $name = "";

    protected ?string $description = null;

    protected ?string $mimeType = null;

    protected ?int $size = null;

    protected ?array $icons = null;

    protected ?array $meta = null;

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function getIcons(): ?array
    {
        return $this->icons;
    }

    public function getMeta(): ?array
    {
        return $this->meta;
    }

    public abstract function __invoke(ReadResourceRequest $request, SessionInterface $session): Response|Error;

    public function toSchemaResource(): Resource
    {
        return new Resource(
            $this->uri,
            $this->name,
            $this->description,
            $this->mimeType,
            $this->getAnnotations(),
            $this->size,
            $this->icons,
            $this->meta
        );
    }

    public function getAnnotations(): ?ToolAnnotations
    {
        return null;
    }


}