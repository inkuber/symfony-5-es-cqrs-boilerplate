<?php
namespace App\Auth\Domain\User;

use App\Shared\Domain\ValueObject\EntityId;

class UserId extends EntityId
{
    public static function fromEntityId(EntityId $id) : UserId
    {
        return new self($id->id());
    }
}
