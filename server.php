<?php

declare(strict_types=1);

use Application\Kernel;
use Mcp\Server\Transport\StdioTransport;

require __DIR__ . '/vendor/autoload.php';

$server = Kernel::createServer()->run(
    new StdioTransport()
);
