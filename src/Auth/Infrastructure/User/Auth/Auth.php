<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\User\Auth;

use App\Auth\Domain\User\UserId;
use App\Auth\Domain\User\ValueObject\Auth\HashedPassword;
use App\Auth\Domain\User\ValueObject\Email;
use Symfony\Component\Security\Core\Encoder\EncoderAwareInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class Auth implements UserInterface, EncoderAwareInterface
{
    private Email $email;

    private HashedPassword $hashedPassword;

    private UserId $id;

    private function __construct(UserId $id, Email $email, HashedPassword $hashedPassword)
    {
        $this->id = $id;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
    }

    public static function create(UserId $id, Email $email, HashedPassword $hashedPassword): self
    {
        return new self($id, $email, $hashedPassword);
    }

    public function getUsername(): string
    {
        return $this->email->__toString();
    }

    public function getPassword(): string
    {
        return $this->hashedPassword->__toString();
    }

    public function getRoles(): array
    {
        return [
            'ROLE_USER',
        ];
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
        // noop
    }

    public function getEncoderName(): string
    {
        return 'bcrypt';
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->email->__toString();
    }
}
