<?php
namespace App\Shared\Domain\ValueObject;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class EntityId
{
    private UuidInterface $id;

    protected function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public static function generate()
    {
        return new static(Uuid::uuid4());
    }

    public static function fromString(string $id)
    {
        return new static(Uuid::fromString($id));
    }

    public static function fromUuid(UuidInterface $uuid)
    {
        return new static($uuid);
    }

    public static function fromBytes($bytes)
    {
        return new static(Uuid::fromBytes($bytes));
    }

    public function id()
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->id->toString();
    }

    public function getBytes()
    {
        return $this->id->getBytes();
    }
}
