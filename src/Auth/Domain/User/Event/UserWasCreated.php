<?php

declare(strict_types=1);

namespace App\Auth\Domain\User\Event;

use App\Auth\Domain\User\UserId;
use App\Shared\Application\Event\EventInterface;
use App\Auth\Domain\User\ValueObject\UniqueEmail;
use App\Shared\Domain\ValueObject\DateTime;
use Broadway\Serializer\Serializable;

final class UserWasCreated implements EventInterface, Serializable
{
    private UserId $id;
    private UniqueEmail $email;
    private DateTime $createdAt;

    public function __construct(UserId $id, UniqueEmail $email, DateTime $createdAt)
    {
        $this->id = $id;
        $this->email = $email;
        $this->createdAt = $createdAt;
    }

    public static function deserialize(array $data): self
    {
        return new self(
            UserId::fromString($data['id']),
            UniqueEmail::fromString($data['email']),
            DateTime::fromString($data['created_at'])
        );
    }

    public function serialize(): array
    {
        return [
            'id' => $this->id->__toString(),
            'email' => $this->email->__toString(),
            'created_at' => $this->createdAt->__toString(),
        ];
    }

    public function id(): string
    {
        return $this->id->__toString();
    }
}
