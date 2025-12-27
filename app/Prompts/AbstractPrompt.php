<?php

declare(strict_types=1);

namespace Application\Prompts;

abstract class AbstractPrompt
{
    protected ?string $name = null;

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

    public function getIcons(): ?array
    {
        return $this->icons;
    }

    public function getMeta(): ?array
    {
        return $this->meta;
    }
}