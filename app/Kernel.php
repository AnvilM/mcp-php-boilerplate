<?php

declare(strict_types=1);

namespace Application;

use Application\Bootstrappers\ContainerBootstrapper;
use Application\Bootstrappers\PromptsBootstrapper;
use Application\Bootstrappers\ProvidersBootstrapper;
use Application\Bootstrappers\ResourcesBootstrapper;
use Application\Bootstrappers\ToolsBootstrapper;
use Mcp\Server;

final readonly class Kernel
{
    public static function createServer(): Server
    {
        $container = ContainerBootstrapper::createContainer(
            ProvidersBootstrapper::getProviders()
        );

        $builder = Server::builder()
            ->setServerInfo("Example Server", "1.0.0", "Example MCP PHP Server")
            ->setContainer($container);

        ToolsBootstrapper::registerTools($builder);

        ResourcesBootstrapper::registerResources($builder);

        PromptsBootstrapper::registerPrompts($builder);
        
        return $builder->build();
    }
}