<?php

declare(strict_types=1);

namespace App\Auth\Domain\User\ValueObject\Auth;

use App\Auth\Domain\User\ValueObject\UniqueEmail;

class Credentials
{
    public UniqueEmail $email;

    public HashedPassword $password;

    public function __construct(UniqueEmail $email, HashedPassword $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
}
