<?php

declare(strict_types=1);

namespace Application\Providers\ApplicationProviders;

use Application\Config\LoggerConfig\LoggerConfig;
use Application\Platform\Interfaces\ProviderInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

/**
 * Logger service provider.
 *
 * Registers a PSR-3 compatible logger instance in the DI container.
 */
final readonly class LoggerProvider implements ProviderInterface
{

    /**
     * Registers services in the container.
     *
     * Returns an associative array where the key is a class or interface name
     * and the value is the corresponding service instance.
     *
     * @return array<string, mixed> Map of service identifiers to instances
     */
    public static function register(): array
    {
        return [LoggerInterface::class => new Logger('app')
            ->pushHandler(new RotatingFileHandler(
                LoggerConfig::path(),
                0,
                LoggerConfig::level(),
                true,
                0777
            )->setFormatter(new LineFormatter(
                    null,
                    'Y-m-d H:i:s',
                    false,
                    true
                )
            ))];
    }
}