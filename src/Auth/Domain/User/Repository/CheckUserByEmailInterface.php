<?php

declare(strict_types=1);

namespace App\Auth\Domain\User\Repository;

use App\Auth\Domain\User\UserId;
use App\Auth\Domain\User\ValueObject\Email;

interface CheckUserByEmailInterface
{
    public function existsEmail(Email $email): ?UserId;
}
