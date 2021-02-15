<?php

namespace App\Auth\Domain\User\ValueObject;

use App\Auth\Domain\User\ValueObject\Email;

class UniqueEmail extends Email
{
    /**
     * Instantiate UniqueEmail from Email instance
     * @internal Should be called only from EmailFactory
     *
     * @param Email $email
     *
     * @return UniqueEmail
     */
    public static function fromEmail(Email $email): UniqueEmail
    {
        return parent::fromString($email->__toString());
    }
}
