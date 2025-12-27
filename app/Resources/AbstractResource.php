<?php

declare(strict_types=1);

namespace Application\Resources;

use Mcp\Schema\ToolAnnotations;

abstract class AbstractResource
{

    protected string $uri = "";

    protected ?string $name = null;

    protected ?string $description = null;

    protected ?string $mimeType = null;

    protected ?int $size = null;

    protected ?ToolAnnotations $annotations = null;

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

    public function getAnnotations(): ?ToolAnnotations
    {
        return $this->annotations;
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