<?php

declare(strict_types=1);

namespace App\Auth\Domain\User\Event;

use App\Auth\Domain\User\UserId;
use App\Shared\Application\Event\EventInterface;
use App\Shared\Domain\ValueObject\DateTime;
use Broadway\Serializer\Serializable;
use Ramsey\Uuid\Uuid;

final class UserSignedIn implements EventInterface, Serializable
{
    private string $id;
    private UserId $userId;
    private DateTime $signedAt;


    public function __construct(UserId $userId, DateTime $signedAt, string $id = null)
    {
        $this->id = $id ?? Uuid::uuid4()->toString();
        $this->userId = $userId;
        $this->signedAt = $signedAt;
    }

    public static function deserialize(array $data): self
    {
        return new self(
            UserId::fromString($data['user_id']),
            DateTime::fromString($data['signed_at']),
            $data['id']
        );
    }

    public function serialize(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId->__toString(),
            'signed_at' => $this->signedAt->__toString(),
        ];
    }

    public function id(): string
    {
        return $this->id;
    }
}
