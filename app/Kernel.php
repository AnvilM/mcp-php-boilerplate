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

        $container = ContainerBootstrapper::registerContainer($builder, ProvidersBootstrapper::getProviders());

        ServerBootstrapper::bootstrap($builder, $container);

        ToolsBootstrapper::registerTools($builder, $container);

        ResourcesBootstrapper::registerResources($builder, $container);

        PromptsBootstrapper::registerPrompts($builder, $container);

        return $builder->build();
    }
}