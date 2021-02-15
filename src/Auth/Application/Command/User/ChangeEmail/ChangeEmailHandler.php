<?php

declare(strict_types=1);

namespace App\Auth\Application\Command\User\ChangeEmail;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Auth\Domain\User\Repository\UserRepositoryInterface;
use App\Auth\Domain\User\Specification\UniqueEmailSpecificationInterface;
use App\Auth\Application\Command\User\ChangeEmail\ChangeEmailCommand;

final class ChangeEmailHandler implements CommandHandlerInterface
{
    private UserRepositoryInterface $userRepository;

    private UniqueEmailSpecificationInterface $uniqueEmailSpecification;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UniqueEmailSpecificationInterface $uniqueEmailSpecification
    ) {
        $this->userRepository = $userRepository;
        $this->uniqueEmailSpecification = $uniqueEmailSpecification;
    }

    public function __invoke(ChangeEmailCommand $command): void
    {
        $user = $this->userRepository->get($command->userId);

        $user->changeEmail($command->email, $this->uniqueEmailSpecification);

        $this->userRepository->store($user);
    }
}
