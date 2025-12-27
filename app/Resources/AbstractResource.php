<?php

declare(strict_types=1);

namespace Application\Resources;

use Mcp\Schema\ToolAnnotations;

abstract class AbstractResource
{
    public function getUri(): string
    {
        return "";
    }
    
    public function getName(): ?string
    {
        return null;
    }
    
    public function getDescription(): ?string
    {
        return null;
    }
    
    public function getMimeType(): ?string
    {
        return null;
    }
    
    public function getSize(): ?int
    {
        return null;
    }
    
    public function getAnnotations(): ?ToolAnnotations
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