<?php /** @noinspection ALL */

declare(strict_types=1);

namespace Application\Platform\Primitives;

use Mcp\Schema\Annotations;
use Mcp\Schema\Icon;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Request\ReadResourceRequest;
use Mcp\Schema\Resource;
use Mcp\Schema\Result\ReadResourceResult;
use Mcp\Server\Session\SessionInterface;

/**
 * Base resource class
 */
abstract class AbstractResource
{

    /**
     * Resource URI.
     *
     * @var string
     */
    protected string $uri = "";

    /**
     * Resource name.
     *
     * @var string
     */
    protected string $name = "";

    /**
     * Optional resource description.
     *
     * @var ?string
     */
    protected ?string $description = null;

    /**
     * Optional MIME type of the resource.
     *
     * @var ?string
     */
    protected ?string $mimeType = null;

    /**
     * Optional size of the resource in bytes.
     *
     * @var ?int
     */
    protected ?int $size = null;

    /**
     * Optional array of icons associated with the resource.
     *
     * @var ?Icon[]
     */
    protected ?array $icons = null;

    /**
     * Optional metadata for the resource.
     *
     * @var ?array<string, mixed>
     */
    protected ?array $meta = null;

    /**
     * Get the URI of the resource.
     *
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Get the name of the resource.
     *
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Get the description of the resource.
     *
     * @return ?string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Get the MIME type of the resource.
     *
     * @return ?string
     */
    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    /**
     * Get the size of the resource in bytes.
     *
     * @return ?int
     */
    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * Get the icons associated with the resource.
     *
     * @return ?Icon[]
     */
    public function getIcons(): ?array
    {
        return $this->icons;
    }

    /**
     * Get metadata associated with the resource.
     *
     * @return ?array<string, mixed>
     */
    public function getMeta(): ?array
    {
        return $this->meta;
    }

    /**
     * Read the resource using the provided request and session.
     *
     * @param ReadResourceRequest $request The request to read the resource.
     * @param SessionInterface $session The user session.
     * @return Response<ReadResourceResult> Response containing the read result.
     */
    public abstract function __invoke(ReadResourceRequest $request, SessionInterface $session): Response;

    /**
     * Convert the current object to a Resource schema object.
     *
     * @return Resource
     */
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

    /**
     * Get tool annotations for the resource.
     *
     * @return ?Annotations
     */
    public function getAnnotations(): ?Annotations
    {
        return null;
    }


}