<?php

declare(strict_types=1);

namespace App\Auth\Domain\User\Event;

use App\Auth\Domain\User\UserId;
use App\Shared\Application\Event\EventInterface;
use App\Auth\Domain\User\ValueObject\UniqueEmail;
use App\Shared\Domain\ValueObject\DateTime;
use Broadway\Serializer\Serializable;
use Ramsey\Uuid\Uuid;

final class UserEmailChanged implements EventInterface, Serializable
{
    private string $id;
    private UserId $userId;
    private UniqueEmail $email;
    private DateTime $updatedAt;

    public function __construct(UserId $userId, UniqueEmail $email, DateTime $updatedAt, $id = null)
    {
        $this->id = $id ?? Uuid::uuid4()->toString();
        $this->userId = $userId;
        $this->email = $email;
        $this->updatedAt = $updatedAt;
    }

    public static function deserialize(array $data): self
    {
        return new self(
            UserId::fromString($data['user_id']),
            UniqueEmail::fromString($data['email']),
            DateTime::fromString($data['updated_at']),
            $data['id'],
        );
    }

    public function serialize(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId->__toString(),
            'email' => $this->email->__toString(),
            'updated_at' => $this->updatedAt->__toString(),
        ];
    }

    public function id(): string
    {
        return $this->id;
    }
}
