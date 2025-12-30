<?php

declare(strict_types=1);

namespace Application\Config\ApplicationConfig;

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
        return match ($_ENV["APP_ENV"]) {
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
        return (bool)$_ENV["APP_DEBUG"];
    }

    /**
     * Returns the application name.
     *
     * @return string Application name
     */
    public static function appName(): string
    {
        return (string)$_ENV["APP_NAME"];
    }

    /**
     * Returns the application description.
     *
     * @return string Application description
     */
    public static function appDescription(): string
    {
        return (string)$_ENV["APP_DESCRIPTION"];
    }
}
