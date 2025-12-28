<?php

declare(strict_types=1);

namespace Application\Platform\Collections;

use Application\Platform\Primitives\AbstractTool;
use InvalidArgumentException;
use Mcp\Schema\Tool;

/**
 * Collection of tools.
 */
final class ToolsCollection
{
    /**
     * Array of tools.
     *
     * @var AbstractTool[]
     */
    private array $tools = [];

    /**
     * Initializes the collection with an array of tools.
     *
     * @param AbstractTool[] $tools Array of AbstractTool instances
     * @throws InvalidArgumentException If any element is not an AbstractTool
     */
    public function __construct(array $tools)
    {
        foreach ($tools as $tool) {
            if (!($tool instanceof AbstractTool)) {
                throw new InvalidArgumentException('Only AbstractTool allowed');
            }
            $this->tools[] = $tool;
        }
    }

    /**
     * Adds a tool to the collection.
     *
     * @param AbstractTool $tool Tool instance to add
     * @return void
     */
    public function push(AbstractTool $tool): void
    {
        $this->tools[] = $tool;
    }

    /**
     * Converts the collection to an array of tool schemas.
     *
     * @return Tool[] Array of tool schemas
     */
    public function toSchemaToolArray(): array
    {
        return array_map(
            static fn(AbstractTool $tool): Tool => $tool->toSchemaTool(),
            $this->tools
        );
    }

    /**
     * Finds a tool by its name.
     *
     * @param string $name Name of the tool
     * @return AbstractTool|null The tool if found, or null
     */
    public function findByName(string $name): ?AbstractTool
    {
        /** @var AbstractTool|null $result */
        $result = array_find($this->tools, fn(AbstractTool $tool) => $tool->getName() === $name);

        return $result;
    }

    /**
     * Returns all tools in the collection.
     *
     * @return AbstractTool[] Array of all tools
     */
    public function all(): array
    {
        return $this->tools;
    }
}
