<?php

declare(strict_types=1);

namespace App\Auth\Application\Command\User\SignUp;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Auth\Domain\User\Factory\EmailFactoryInterface;
use App\Auth\Domain\User\User;
use App\Auth\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\Shared\Exception\DateTimeException;
use App\Auth\Domain\User\ValueObject\Auth\Credentials;
use App\Auth\Application\Command\User\SignUp\SignUpCommand;

final class SignUpHandler implements CommandHandlerInterface
{
    private UserRepositoryInterface $userRepository;

    private EmailFactoryInterface $emailFactory;

    public function __construct(
        UserRepositoryInterface $userRepository,
        EmailFactoryInterface $emailFactory
    ) {
        $this->userRepository = $userRepository;
        $this->emailFactory = $emailFactory;
    }

    /**
     * @throws DateTimeException
     */
    public function __invoke(SignUpCommand $command): void
    {
        $credentials = new Credentials(
            $this->emailFactory->uniqueEmail($command->email),
            $command->password
        );

        $user = User::create($command->id, $credentials);

        $this->userRepository->store($user);
    }
}
