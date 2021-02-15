<?php

namespace App\Infrastructure\Event;

use App\Shared\Application\Event\EventInterface;
use App\Shared\Domain\ValueObject\DateTime;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Event
{
    public UuidInterface $id;
    public string $payload;
    public DateTime $recordedOn;
    public string $type;

    private function __construct(
        string $id,
        string $payload,
        DateTime $recordedOn,
        string $type
    ) {
        $this->id = Uuid::fromString($id);
        $this->payload = $payload;
        $this->recordedOn = $recordedOn;
        $this->type = $type;
    }

    public static function fromDomainEvent(EventInterface $event): Event
    {
        return new self(
            $event->id(),
            json_encode($event->serialize()),
            DateTime::now(),
            get_class($event)
        );
    }
}
