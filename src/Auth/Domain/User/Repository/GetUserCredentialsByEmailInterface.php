<?php

declare(strict_types=1);

namespace App\Auth\Domain\User\Repository;

use App\Auth\Domain\User\ValueObject\Email;

interface GetUserCredentialsByEmailInterface
{
    /**
     * @return array{
     *   0: App\Auth\Domain\User\UserId,
     *   1: App\Auth\Domain\User\ValueObject\Email,
     *   2: \App\Domain\User\ValueObject\Auth\HashedPassword
     * }
     */
    public function getCredentialsByEmail(Email $email): array;
}
