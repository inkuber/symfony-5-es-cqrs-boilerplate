<?php

declare(strict_types=1);

namespace App\Shared\Application\Event;

interface EventInterface
{
    public function id(): string;
    public function serialize() : array;
}
