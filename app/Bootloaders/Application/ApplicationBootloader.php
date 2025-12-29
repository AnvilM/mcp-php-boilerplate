<?php

declare(strict_types=1);

namespace Application\Bootloaders\Application;

use Application\Bootloaders\BootloaderInterface;
use Application\Bootloaders\Context;

final readonly class ApplicationBootloader implements BootloaderInterface
{

    /**
     * @inheritDoc
     */
    public function boot(Context $context): Context
    {
        // TODO: Implement boot() method.
    }
}