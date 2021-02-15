<?php

declare(strict_types=1);

namespace App\Auth\Domain\User\Repository;

use App\Auth\Domain\User\ValueObject\Email;
use App\Auth\Domain\User\User;

interface GetUserByEmailInterface
{
    /**
     * @return App\Domain\User\User
     */
    public function oneByEmail(Email $email): User;
}
