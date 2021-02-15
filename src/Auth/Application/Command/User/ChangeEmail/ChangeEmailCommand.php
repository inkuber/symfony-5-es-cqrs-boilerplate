<?php

declare(strict_types=1);

namespace App\Auth\Application\Command\User\ChangeEmail;

use App\Auth\Domain\User\UserId;
use App\Shared\Application\Command\CommandInterface;
use App\Auth\Domain\User\ValueObject\Email;
use Assert\AssertionFailedException;

final class ChangeEmailCommand implements CommandInterface
{
    /** @psalm-readonly */
    public UserId $userId;

    /** @psalm-readonly */
    public Email $email;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(string $userId, string $email)
    {
        $this->userId = UserId::fromString($userId);
        $this->email = Email::fromString($email);
    }
}
