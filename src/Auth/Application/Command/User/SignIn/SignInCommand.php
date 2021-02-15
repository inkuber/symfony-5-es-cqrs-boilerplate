<?php

declare(strict_types=1);

namespace App\Auth\Application\Command\User\SignIn;

use App\Shared\Application\Command\CommandInterface;
use App\Auth\Domain\User\ValueObject\Email;
use Assert\AssertionFailedException;

final class SignInCommand implements CommandInterface
{
    /** @psalm-readonly */
    public Email $email;

    /** @psalm-readonly */
    public string $plainPassword;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(string $email, string $plainPassword)
    {
        $this->email = Email::fromString($email);
        $this->plainPassword = $plainPassword;
    }
}
