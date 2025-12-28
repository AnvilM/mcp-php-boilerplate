<?php

declare(strict_types=1);

namespace Application\Bootstrappers;

use Application\Config\ApplicationConfig\ApplicationConfig;
use DI\Container;
use Mcp\Schema\ServerCapabilities;
use Mcp\Server\Builder;
use Mcp\Server\Session\FileSessionStore;
use Psr\Log\LoggerInterface;

final readonly class ServerBootstrapper
{
    public static function bootstrap(Builder $builder, Container $container): void
    {
        $builder->setServerInfo(
            ApplicationConfig::appName(),
            ApplicationConfig::appDescription()
        )->setCapabilities(
            new ServerCapabilities()
        )->setSession(
            new FileSessionStore(
                ApplicationConfig::baseDir() . '/sessions'
            )
        )->setLogger(
            $container->get(LoggerInterface::class)
        );
    }
}