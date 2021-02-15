<?php

declare(strict_types=1);

namespace App\Auth\Application\Command\User\SignIn;

use App\Auth\Domain\User\UserId;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Auth\Domain\User\Exception\InvalidCredentialsException;
use App\Auth\Domain\User\Repository\CheckUserByEmailInterface;
use App\Auth\Domain\User\Repository\UserRepositoryInterface;
use App\Auth\Domain\User\ValueObject\Email;
use App\Auth\Application\Command\User\SignIn\SignInCommand;

final class SignInHandler implements CommandHandlerInterface
{
    private UserRepositoryInterface $userStore;

    private CheckUserByEmailInterface $userCollection;

    public function __construct(UserRepositoryInterface $userStore, CheckUserByEmailInterface $userCollection)
    {
        $this->userStore = $userStore;
        $this->userCollection = $userCollection;
    }

    public function __invoke(SignInCommand $command): void
    {
        $id = $this->uuidFromEmail($command->email);

        $user = $this->userStore->get($id);

        $user->signIn($command->plainPassword);

        $this->userStore->store($user);
    }

    private function uuidFromEmail(Email $email): UserId
    {
        $id = $this->userCollection->existsEmail($email);

        if (null === $id) {
            throw new InvalidCredentialsException();
        }

        return $id;
    }
}
