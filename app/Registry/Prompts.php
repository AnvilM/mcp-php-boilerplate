<?php

declare(strict_types=1);

namespace Application\Registry;

use Application\Platform\Primitives\AbstractPrompt;
use Application\Prompts\ExamplePrompt;

final class Prompts
{
    /** @var array<class-string<AbstractPrompt>> */
    public static array $prompts = [
        ExamplePrompt::class
    ];
}