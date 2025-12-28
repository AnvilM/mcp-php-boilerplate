<?php

declare(strict_types=1);

namespace Application\Platform\Collections;

use Application\Platform\Primitives\AbstractPrompt;
use InvalidArgumentException;

final class PromptCollection
{
    /** @var array<AbstractPrompt> */
    private array $prompts = [];

    /** @param array<AbstractPrompt> $prompts */
    public function __construct(array $prompts)
    {
        foreach ($prompts as $prompt) {
            if (!($prompt instanceof AbstractPrompt)) throw new InvalidArgumentException("Only AbstractPrompt allowed");
            $this->prompts[] = $prompt;
        }
    }

    public function push(AbstractPrompt $prompt): void
    {
        $this->prompts[] = $prompt;
    }

    public function toSchemaPromptArray(): array
    {
        return array_map(
            static fn(AbstractPrompt $prompt) => $prompt->toSchemaPrompt(),
            $this->prompts
        );
    }

    public function findByName(string $name): ?AbstractPrompt
    {
        return array_find($this->prompts, fn($prompt) => $prompt->getName() === $name);

    }
}