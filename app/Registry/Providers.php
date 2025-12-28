<?php

declare(strict_types=1);

namespace Application\Registry;

use Application\Platform\Interfaces\ProviderInterface;
use Application\Providers\ApplicationProviders\LoggerProvider;

final class Providers
{
    /** @var array<class-string<ProviderInterface>> */
    public static array $providers = [

    ];

    /** @var array<class-string<ProviderInterface>> */
    public static array $appProviders = [
        LoggerProvider::class
    ];
}