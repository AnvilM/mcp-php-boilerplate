<?php /** @noinspection ALL */

declare(strict_types=1);

namespace Application\Tools;

use Mcp\Schema\ToolAnnotations;

abstract class AbstractTool
{

    protected ?string $name = null;

    protected ?string $description = null;

    protected ?ToolAnnotations $annotations = null;

    protected ?array $inputSchema = null;

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

    public function getAnnotations(): ?ToolAnnotations
    {
        return $this->annotations;
    }

    public function getInputSchema(): ?array
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
}