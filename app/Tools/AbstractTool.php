<?php

declare(strict_types=1);

namespace Application\Tools;

use Mcp\Schema\ToolAnnotations;

abstract class AbstractTool
{

    
    public function getName(): ?string
    {
        return null;
    }
    
    public function getDescription(): ?string
    {
        return null;
    }
    
    public function getAnnotations(): ?ToolAnnotations
    {
        return null;
    }
    
    public function getInputSchema(): ?array
    {
        return null;
    }


    public function getIcons(): ?array
    {
        return null;
    }


    public function getMeta(): ?array
    {
        return null;
    }
}