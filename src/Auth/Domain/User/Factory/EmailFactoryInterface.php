<?php

namespace App\Auth\Domain\User\Factory;

use App\Auth\Domain\User\ValueObject\Email;
use App\Auth\Domain\User\ValueObject\UniqueEmail;

interface EmailFactoryInterface
{
    public function uniqueEmail(Email $email): UniqueEmail;
}
