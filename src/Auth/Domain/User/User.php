<?php

declare(strict_types=1);

namespace App\Auth\Domain\User;

use App\Shared\Domain\AbstractAggregateRoot;
use App\Shared\Domain\Exception\DateTimeException;
use App\Shared\Domain\ValueObject\DateTime;
use App\Auth\Domain\User\Event\UserEmailChanged;
use App\Auth\Domain\User\Event\UserSignedIn;
use App\Auth\Domain\User\Event\UserWasCreated;
use App\Auth\Domain\User\Exception\InvalidCredentialsException;
use App\Auth\Domain\User\ValueObject\Auth\Credentials;
use App\Auth\Domain\User\ValueObject\UniqueEmail;
use Broadway\Domain\AggregateRoot;

/**
 * @psalm-suppress MissingConstructor
 */
class User extends AbstractAggregateRoot implements AggregateRoot
{
    private UserId $id;

    private Credentials $credentials;

    private ?DateTime $createdAt;

    private ?DateTime $updatedAt;

    protected function __construct(
        UserId $id,
        Credentials $credentials,
        DateTime $createdAt = null,
        DateTime $updatedAt = null
    ) {
        $this->id = $id;
        $this->credentials  = $credentials;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * Behavior
     */

    /**
     * @throws DateTimeException
     */
    public static function create(
        UserId $id,
        Credentials $credentials
    ): self {
        $user = new self($id, $credentials, DateTime::now());

        $user->apply(new UserWasCreated($user->id, $user->credentials->email, $user->createdAt));

        return $user;
    }

    /**
     * @throws DateTimeException
     */
    public function changeEmail(
        UniqueEmail $email
    ): void {
        $this->apply(new UserEmailChanged($this->id, $email, $this->updatedAt));
    }

    /**
     * @throws InvalidCredentialsException
     */
    public function signIn(string $plainPassword): void
    {
        if (!$this->credentials->password->match($plainPassword)) {
            throw new InvalidCredentialsException('Invalid credentials entered.');
        }

        $this->apply(new UserSignedIn($this->id, DateTime::now()));
    }

    /**
     * Events
     */
    public function applyUserEmailChanged(UserEmailChanged $event):void
    {
        $this->credentials->email = $event->email();
    }

    /**
     * Getters and setters
     */

    public function id() : UserId
    {
        return $this->id;
    }

    public function credentials() : Credentials
    {
        return $this->credentials;
    }

    /**
     * Utility
     */

    public function getAggregateRootId(): string
    {
        return $this->id->__toString();
    }

    public function __toString()
    {
        return $this->id->__toString();
    }

    public function getChildEntities() : array
    {
        return [
        ];
    }
}
