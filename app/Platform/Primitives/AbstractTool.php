<?php /** @noinspection ALL */

declare(strict_types=1);

namespace Application\Platform\Primitives;

use Mcp\Schema\Icon;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Request\CallToolRequest;
use Mcp\Schema\Result\CallToolResult;
use Mcp\Schema\Tool;
use Mcp\Schema\ToolAnnotations;
use Mcp\Server\Session\SessionInterface;

/**
 * Base tool class
 * @phpstan-import-type ToolInputSchema from Tool
 */
abstract class AbstractTool
{
    /**
     * Name of the tool.
     *
     * @var string
     */
    protected string $name;

    /**
     * Input schema of the tool.
     *
     * @var ToolInputSchema
     */
    protected array $inputSchema;

    /**
     * Optional description of the tool.
     *
     * @var ?string
     */
    protected ?string $description = null;

    /**
     * Optional icons associated with the tool.
     *
     * @var ?Icon[]
     */
    protected ?array $icons = null;

    /**
     * Optional metadata for the tool.
     *
     * @var ?array<string, mixed>
     */
    protected ?array $meta = null;

    /**
     * Get the name of the tool.
     *
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Get the description of the tool.
     *
     * @return ?string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Get the input schema of the tool.
     *
     * @return ToolInputSchema
     */
    public function getInputSchema(): array
    {
        return $this->inputSchema;
    }

    /**
     * Get the icons associated with the tool.
     *
     * @return ?Icon[]
     */
    public function getIcons(): ?array
    {
        return $this->icons;
    }

    /**
     * Get the metadata associated with the tool.
     *
     * @return ?array<string, mixed>
     */
    public function getMeta(): ?array
    {
        return $this->meta;
    }

    /**
     * Handle tool invocation with the provided request and session.
     *
     * @param CallToolRequest $request The tool call request.
     * @param SessionInterface $session The user session.
     * @return Response<CallToolResult> Response containing the result of the tool call.
     */
    public abstract function __invoke(CallToolRequest $request, SessionInterface $session): Response;

    /**
     * Map the current object to a schema Tool object.
     *
     * @return Tool
     */
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

    /**
     * Get tool annotations.
     *
     * @return ?ToolAnnotations
     */
    public function getAnnotations(): ?ToolAnnotations
    {
        return null;
    }

}
