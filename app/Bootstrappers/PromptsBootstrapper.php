<?php

declare(strict_types=1);

namespace Application\Bootstrappers;

use Application\Platform\Collections\PromptsCollection;
use Application\Platform\Handlers\Prompt\GetPromptHandler;
use Application\Platform\Handlers\Prompt\ListPromptsHandler;
use Application\Registry\Prompts;
use DI\Container;
use Mcp\Server\Builder;

final class PromptsBootstrapper
{
    public static function registerPrompts(Builder $builder, Container $container): void
    {
        $prompts = self::getPrompts($container);

        $builder->addRequestHandlers([
            new ListPromptsHandler($prompts),
            new GetPromptHandler($prompts)
        ]);
    }

    private static function getPrompts(Container $container): PromptsCollection
    {
        $prompts = new PromptsCollection([]);

        foreach (Prompts::$prompts as $prompt) {
            $prompts->push($container->get($prompt));
        }

        return $prompts;
    }
}