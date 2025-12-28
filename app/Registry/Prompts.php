<?php

declare(strict_types=1);

namespace Application\Registry;

use Application\Platform\Primitives\AbstractPrompt;
use Application\Prompts\ExamplePrompt;

/**
 * Registry of available prompts.
 *
 * This class holds a static list of prompt classes
 * that extend AbstractPrompt.
 */
final class Prompts
{
    /**
     * List of prompt classes.
     *
     * @var array<class-string<AbstractPrompt>> Array of class names extending AbstractPrompt
     */
    public static array $prompts = [
        ExamplePrompt::class
    ];
}