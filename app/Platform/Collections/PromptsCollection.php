<?php

declare(strict_types=1);

namespace Application\Platform\Collections;

use Application\Platform\Primitives\AbstractPrompt;
use InvalidArgumentException;
use Mcp\Schema\Prompt;

/**
 * Collection of prompts.
 */
final class PromptsCollection
{
    /**
     * Array of prompts.
     *
     * @var AbstractPrompt[]
     */
    private array $prompts = [];

    /**
     * Initializes the collection with an array of prompts.
     *
     * @param AbstractPrompt[] $prompts Array of AbstractPrompt instances
     * @throws InvalidArgumentException If any element is not an AbstractPrompt
     */
    public function __construct(array $prompts)
    {
        foreach ($prompts as $prompt) {
            if (!($prompt instanceof AbstractPrompt)) {
                throw new InvalidArgumentException('Only AbstractPrompt allowed');
            }
            $this->prompts[] = $prompt;
        }
    }

    /**
     * Adds a prompt to the collection.
     *
     * @param AbstractPrompt $prompt Prompt instance to add
     * @return void
     */
    public function push(AbstractPrompt $prompt): void
    {
        $this->prompts[] = $prompt;
    }

    /**
     * Converts the collection to an array of prompt schemas.
     *
     * @return Prompt[] Array of Prompt schema objects
     */
    public function toSchemaPromptArray(): array
    {
        return array_map(
            static fn(AbstractPrompt $prompt): Prompt => $prompt->toSchemaPrompt(),
            $this->prompts
        );
    }

    /**
     * Finds a prompt by its name.
     *
     * @param string $name Name of the prompt
     * @return AbstractPrompt|null The prompt if found, or null
     */
    public function findByName(string $name): ?AbstractPrompt
    {
        /** @var AbstractPrompt|null $result */
        $result = array_find($this->prompts, fn(AbstractPrompt $prompt) => $prompt->getName() === $name);

        return $result;
    }

    /**
     * Returns all prompts in the collection.
     *
     * @return AbstractPrompt[] Array of all prompts
     */
    public function all(): array
    {
        return $this->prompts;
    }
}
