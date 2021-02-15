<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Types;

use App\Auth\Domain\User\UserId;
use App\Infrastructure\Types\EntityIdType;

final class UserIdType extends EntityIdType
{
    protected const TYPE = 'user_id';

    public function fromBytes($value)
    {
        return UserId::fromBytes($value);
    }
}
