<?php

declare(strict_types=1);

namespace Application\Prompts;

use Mcp\Schema\ToolAnnotations;

abstract class AbstractPrompt
{

    
    public function getName(): ?string
    {
        return null;
    }
    
    public function getDescription(): ?string
    {
        return null;
    }
    


    public function getIcons(): array
    {
        return [];
    }


    public function getMeta(): array
    {
        return [];
    }
}