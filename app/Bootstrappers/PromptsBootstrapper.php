<?php

declare(strict_types=1);

namespace Application\Bootstrappers;

use Application\Prompts\AbstractPrompt;
use LogicException;
use Mcp\Server\Builder;

final class PromptsBootstrapper
{
    /** @var array<AbstractPrompt> * */
    private static array $prompts = [

    ];

    public static function registerPrompts(Builder $builder): Builder
    {
        foreach (self::$prompts as $prompt) {
            
            self::assertPromptIsCallable($prompt);

            $builder->addPrompt(
                $prompt,
                $prompt->getName(),
                $prompt->getDescription(),
                $prompt->getIcons(),
                $prompt->getMeta()
            );
        }

        return $builder;
    }

    private static function assertPromptIsCallable(AbstractPrompt $prompt): void
    {
        if (!is_callable($prompt)) {
            throw new LogicException("Prompt " . get_class($prompt) . " must be a callable");
        }
    }
}