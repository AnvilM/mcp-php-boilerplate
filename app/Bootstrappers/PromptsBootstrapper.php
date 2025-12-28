<?php

declare(strict_types=1);

namespace Application\Bootstrappers;

use Application\Platform\Collections\PromptsCollection;
use Application\Platform\Handlers\Prompt\GetPromptHandler;
use Application\Platform\Handlers\Prompt\ListPromptsHandler;
use Application\Registry\Prompts;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Mcp\Server\Builder;

/**
 * Prompts bootstrapper.
 *
 * Responsible for resolving prompt instances from the DI container
 * and registering prompt-related request handlers.
 */
final class PromptsBootstrapper
{
    /**
     * Registers prompt handlers in the server builder.
     *
     * @param Builder $builder Server builder instance
     * @param Container $container Dependency injection container
     *
     * @return void
     *
     * @throws NotFoundException   No entry found for the given identifier
     * @throws DependencyException Error while resolving a container entry
     */
    public static function registerPrompts(Builder $builder, Container $container): void
    {
        $prompts = self::getPrompts($container);

        $builder->addRequestHandlers([
            new ListPromptsHandler($prompts),
            new GetPromptHandler($prompts),
        ]);
    }

    /**
     * Resolves prompt instances from the DI container.
     *
     * @param Container $container Dependency injection container
     *
     * @return PromptsCollection Collection of resolved prompts
     *
     * @throws NotFoundException   No entry found for the given identifier
     * @throws DependencyException Error while resolving a container entry
     */
    private static function getPrompts(Container $container): PromptsCollection
    {
        $prompts = new PromptsCollection([]);

        foreach (Prompts::$prompts as $prompt) {
            $prompts->push($container->get($prompt));
        }

        return $prompts;
    }
}
