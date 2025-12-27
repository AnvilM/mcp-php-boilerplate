<?php

declare(strict_types=1);

namespace Application\Bootstrappers;

use Application\Prompts\AbstractPrompt;
use Mcp\Server\Builder;

final class PromptsBootstrapper
{
    /** @var array<AbstractPrompt> * */
    private static array $prompts = [

    ];

    public static function registerPrompts(Builder $builder): Builder
    {
        foreach (self::$prompts as $prompt) {
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
}