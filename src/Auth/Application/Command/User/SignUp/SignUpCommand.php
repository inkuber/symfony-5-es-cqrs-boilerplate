<?php

declare(strict_types=1);

namespace App\Auth\Application\Command\User\SignUp;

use App\Auth\Domain\User\UserId;
use App\Shared\Application\Command\CommandInterface;
use App\Auth\Domain\User\ValueObject\Auth\HashedPassword;
use App\Auth\Domain\User\ValueObject\Email;
use Assert\AssertionFailedException;

final class SignUpCommand implements CommandInterface
{
    /** @psalm-readonly */
    public UserId $id;

    /** @psalm-readonly */
    public Email $email;

    /** @psalm-readonly */
    public HashedPassword $password;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(string $id, string $email, string $plainPassword)
    {
        $this->id = UserId::fromString($id);
        $this->email = Email::fromString($email);
        $this->password = HashedPassword::encode($plainPassword);
    }
}
