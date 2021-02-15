<?php

declare(strict_types=1);

namespace App\Auth\Domain\User\Specification;

use App\Auth\Domain\User\Exception\EmailAlreadyExistException;
use App\Auth\Domain\User\ValueObject\Email;

interface UniqueEmailSpecificationInterface
{
    /**
     * @throws EmailAlreadyExistException
     */
    public function isUnique(Email $email): bool;
}
