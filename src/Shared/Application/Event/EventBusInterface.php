<?php

declare(strict_types=1);

namespace App\Shared\Application\Event;

interface EventBusInterface
{
    public function fire(EventInterface $command): void;
}
