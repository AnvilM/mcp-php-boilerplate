<?php

declare(strict_types=1);

namespace Application\Config\LoggerConfig;

use Application\Config\ApplicationConfig\ApplicationConfig;
use Application\Config\ApplicationConfig\ApplicationEnvironmentEnum;
use Monolog\Level;

/**
 * Logger configuration.
 *
 * Provides logger-related configuration values
 * based on the current application environment.
 */
final readonly class LoggerConfig
{
    /**
     * Returns the log file path.
     *
     * @return string Absolute path to the log file
     */
    public static function path(): string
    {
        return ApplicationConfig::baseDir() . '/logs/app.log';
    }

    /**
     * Returns the logging level based on the application environment.
     *
     * Production uses a less verbose level,
     * while non-production environments use debug level.
     *
     * @return Level Monolog logging level
     */
    public static function level(): Level
    {
        return ApplicationConfig::appEnv() === ApplicationEnvironmentEnum::Production
            ? Level::Info
            : Level::Debug;
    }
}
