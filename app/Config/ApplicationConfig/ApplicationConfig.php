<?php

declare(strict_types=1);

namespace Application\Config\ApplicationConfig;

use function Env\env;

/**
 * Application configuration.
 *
 * Provides access to application-level configuration values
 * resolved from environment variables.
 */
final readonly class ApplicationConfig
{
    /**
     * Returns the base directory of the application.
     *
     * @return string Absolute path to the application root directory
     */
    public static function baseDir(): string
    {
        return dirname(__DIR__, 3);
    }

    /**
     * Returns the current application environment.
     *
     * The environment is resolved from the APP_ENV environment variable.
     *
     * @return ApplicationEnvironmentEnum Current application environment
     */
    public static function appEnv(): ApplicationEnvironmentEnum
    {
        return match (env('APP_ENV')) {
            'production' => ApplicationEnvironmentEnum::Production,
            'testing' => ApplicationEnvironmentEnum::Testing,
            default => ApplicationEnvironmentEnum::Development,
        };
    }

    /**
     * Indicates whether application debug mode is enabled.
     *
     * @return bool True if debug mode is enabled, otherwise false
     */
    public static function appDebug(): bool
    {
        return (bool)env('APP_DEBUG');
    }

    /**
     * Returns the application name.
     *
     * @return string Application name
     */
    public static function appName(): string
    {
        return (string)env('APP_NAME');
    }

    /**
     * Returns the application description.
     *
     * @return string Application description
     */
    public static function appDescription(): string
    {
        return (string)env('APP_DESCRIPTION');
    }
}
