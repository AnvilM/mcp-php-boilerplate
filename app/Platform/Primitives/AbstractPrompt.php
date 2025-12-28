<?php

declare(strict_types=1);

namespace Application\Platform\Primitives;

use Mcp\Schema\JsonRpc\Error;
use Mcp\Schema\JsonRpc\Response;
use Mcp\Schema\Prompt;
use Mcp\Schema\Request\GetPromptRequest;
use Mcp\Server\Session\SessionInterface;

abstract class AbstractPrompt
{
    protected string $name;

    protected ?string $description = null;

    protected ?array $arguments = null;

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

    public function getArguments(): ?array
    {
        return $this->arguments;
    }

    public function getIcons(): ?array
    {
        return $this->icons;
    }

    public function getMeta(): ?array
    {
        return $this->meta;
    }

    public abstract function __invoke(GetPromptRequest $request, SessionInterface $session): Response|Error;


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