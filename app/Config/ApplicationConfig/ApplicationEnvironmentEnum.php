<?php

declare(strict_types=1);

namespace Application\Config\ApplicationConfig;

/**
 * Application environment enumeration.
 *
 * Represents the possible runtime environments
 * in which the application can operate.
 */
enum ApplicationEnvironmentEnum
{
    /**
     * Production environment.
     */
    case Production;

    /**
     * Development environment.
     */
    case Development;

    /**
     * Testing environment.
     */
    case Testing;
}
