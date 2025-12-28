<?php

declare(strict_types=1);

namespace Application\Platform\Collections;

use Application\Platform\Primitives\AbstractTool;
use InvalidArgumentException;

final class ToolCollection
{
    /** @var array<AbstractTool> */
    private array $tools = [];

    /** @param array<AbstractTool> $tools */
    public function __construct(array $tools)
    {
        foreach ($tools as $tool) {
            if (!($tool instanceof AbstractTool)) throw new InvalidArgumentException("Only AbstractTool allowed");
            $this->tools[] = $tool;
        }
    }

    public function push(AbstractTool $tool): void
    {
        $this->tools[] = $tool;
    }

    public function toSchemaToolArray(): array
    {
        return array_map(
            static fn(AbstractTool $tool) => $tool->toSchemaTool(),
            $this->tools
        );
    }

    public function findByName(string $name): ?AbstractTool
    {
        return array_find($this->tools, fn($tool) => $tool->getName() === $name);

    }
}