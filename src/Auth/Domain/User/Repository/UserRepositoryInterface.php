<?php

declare(strict_types=1);

namespace App\Auth\Domain\User\Repository;

use App\Auth\Domain\User\User;
use App\Auth\Domain\User\UserId;

interface UserRepositoryInterface
{
    public function get(UserId $id): User;

    public function store(User $user): void;
}
