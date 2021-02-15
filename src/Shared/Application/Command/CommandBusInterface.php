<?php

declare(strict_types=1);

namespace App\Shared\Application\Command;

use App\Shared\Application\Command\CommandInterface;

interface CommandBusInterface
{
    public function handle(CommandInterface $command): void;
}
