<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\User\Auth;

use App\Auth\Domain\User\ValueObject\Email;
use App\Infrastructure\Shared\Persistence\ReadModel\Exception\NotFoundException;
use App\Auth\Infrastructure\User\Repository\UserMysqlReadRepository;
use Assert\AssertionFailedException;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use App\Auth\Infrastructure\User\Auth\Auth;

final class AuthProvider implements UserProviderInterface
{
    private UserMysqlReadRepository $userReadModelRepository;

    public function __construct(UserMysqlReadRepository $userReadModelRepository)
    {
        $this->userReadModelRepository = $userReadModelRepository;
    }

    /**
     * @throws NotFoundException
     * @throws AssertionFailedException
     * @throws NonUniqueResultException
     *
     * @return Auth|UserInterface
     */
    public function loadUserByUsername(string $email)
    {
        [$id, $email, $hashedPassword] = $this->userReadModelRepository->getCredentialsByEmail(
            Email::fromString($email)
        );

        return Auth::create($id, $email, $hashedPassword);
    }

    /**
     * @throws NotFoundException
     * @throws AssertionFailedException
     * @throws NonUniqueResultException
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass(string $class): bool
    {
        return Auth::class === $class;
    }
}
