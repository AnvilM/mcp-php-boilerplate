<?php

declare(strict_types=1);

namespace Application;

use Application\Bootstrappers\ContainerBootstrapper;
use Application\Bootstrappers\PromptsBootstrapper;
use Application\Bootstrappers\ProvidersBootstrapper;
use Application\Bootstrappers\ResourcesBootstrapper;
use Application\Bootstrappers\ServerBootstrapper;
use Application\Bootstrappers\ToolsBootstrapper;
use Mcp\Server;

final readonly class Kernel
{
    public static function createServer(): Server
    {
        $builder = Server::builder();

        ServerBootstrapper::bootstrap($builder);

        ContainerBootstrapper::registerContainer($builder, ProvidersBootstrapper::getProviders());

        ToolsBootstrapper::registerTools($builder);

        ResourcesBootstrapper::registerResources($builder);

        PromptsBootstrapper::registerPrompts($builder);

        return $builder->build();
    }
}