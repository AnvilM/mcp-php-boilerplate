<?php

declare(strict_types=1);

use Application\Kernel;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Mcp\Server\Transport\StreamableHttpTransport;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;

require dirname(__DIR__) . '/vendor/autoload.php';

$psr17Factory = new Psr17Factory();

new SapiEmitter()->emit(
    Kernel::createServer()->run(
        new StreamableHttpTransport(
            new ServerRequestCreator(
                $psr17Factory,
                $psr17Factory,
                $psr17Factory,
                $psr17Factory,
            )->fromGlobals()
        )
    )
);