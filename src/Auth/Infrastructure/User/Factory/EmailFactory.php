<?php

namespace App\Auth\Infrastructure\User\Factory;

use App\Auth\Domain\User\Exception\EmailAlreadyExistException;
use App\Auth\Domain\User\Factory\EmailFactoryInterface;
use App\Auth\Domain\User\Repository\CheckUserByEmailInterface;
use Doctrine\ORM\NonUniqueResultException;
use App\Auth\Domain\User\ValueObject\Email;
use App\Auth\Domain\User\ValueObject\UniqueEmail;

class EmailFactory implements EmailFactoryInterface
{
    private CheckUserByEmailInterface $checkUserByEmail;

    public function __construct(CheckUserByEmailInterface $checkUserByEmail)
    {
        $this->checkUserByEmail = $checkUserByEmail;
    }

    /**
     * @throw App\Domain\User\Exception\EmailAlreadyExistException
     */
    public function uniqueEmail(Email $email): UniqueEmail
    {
        try {
            if ($this->checkUserByEmail->existsEmail($email)) {
                throw new EmailAlreadyExistException();
            }

            return UniqueEmail::fromEmail($email);
        } catch (NonUniqueResultException $e) {
            throw new EmailAlreadyExistException();
        }
    }
}
