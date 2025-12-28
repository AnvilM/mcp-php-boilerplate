<?php

declare(strict_types=1);

namespace Application\Platform\Primitives;

use Mcp\Schema\Icon;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Prompt;
use Mcp\Schema\PromptArgument;
use Mcp\Schema\Request\GetPromptRequest;
use Mcp\Schema\Result\GetPromptResult;
use Mcp\Server\Session\SessionInterface;

/**
 * Base prompt class
 */
abstract class AbstractPrompt
{
    /**
     * Name of the prompt.
     *
     * @var string
     */
    protected string $name;

    /**
     * Optional description of the prompt.
     *
     * @var ?string
     */
    protected ?string $description = null;

    /**
     * Optional arguments for the prompt.
     *
     * @var ?PromptArgument[]
     */
    protected ?array $arguments = null;

    /**
     * Optional icons associated with the prompt.
     *
     * @var ?Icon[]
     */
    protected ?array $icons = null;

    /**
     * Optional metadata for the prompt.
     *
     * @var ?array<string, mixed>
     */
    protected ?array $meta = null;

    /**
     * Get the name of the prompt.
     *
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Get the description of the prompt.
     *
     * @return ?string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Get the arguments of the prompt.
     *
     * @return ?PromptArgument[]
     */
    public function getArguments(): ?array
    {
        return $this->arguments;
    }

    /**
     * Get the icons associated with the prompt.
     *
     * @return ?Icon[]
     */
    public function getIcons(): ?array
    {
        return $this->icons;
    }

    /**
     * Get metadata associated with the prompt.
     *
     * @return ?array<string, mixed>
     */
    public function getMeta(): ?array
    {
        return $this->meta;
    }

    /**
     * Handle prompt retrieval with the provided request and session.
     *
     * @param GetPromptRequest $request The prompt request.
     * @param SessionInterface $session The user session.
     * @return Response<GetPromptResult> Response containing the prompt result.
     */
    public abstract function __invoke(GetPromptRequest $request, SessionInterface $session): Response;

    /**
     * Map the current object to a schema Prompt object.
     *
     * @return Prompt
     */
    public function toSchemaPrompt(): Prompt
    {
        return new Prompt(
            $this->name,
            $this->description,
            $this->arguments,
            $this->icons,
            $this->meta
        );
    }
}