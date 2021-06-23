<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\User\Repository;

use App\Auth\Domain\User\Repository\CheckUserByEmailInterface;
use App\Auth\Domain\User\Repository\GetUserCredentialsByEmailInterface;
use App\Auth\Domain\User\Repository\GetUserByEmailInterface;
use App\Auth\Domain\User\UserId;
use App\Auth\Domain\User\ValueObject\Email;
use App\Infrastructure\Shared\Persistence\ReadModel\Exception\NotFoundException;
use App\Infrastructure\Shared\Persistence\Repository\ReadDoctrineRepository;
use App\Auth\Domain\User\User;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;

final class UserDoctrineReadRepository extends ReadDoctrineRepository implements
    CheckUserByEmailInterface,
    GetUserCredentialsByEmailInterface,
    GetUserByEmailInterface
{
    protected function setEntityManager(): void
    {
        /** @var EntityRepository $objectRepository */
        $objectRepository = $this->entityManager->getRepository(User::class);
        $this->repository = $objectRepository;
    }

    private function getUserByEmailQueryBuilder(Email $email): QueryBuilder
    {
        return $this->repository
            ->createQueryBuilder('user')
            ->where('user.credentials.email = :email')
            ->setParameter('email', $email->__toString());
    }

    /**
     * @throws NotFoundException
     * @throws NonUniqueResultException
     */
    public function oneById(UserId $id): User
    {
        $qb = $this->repository
            ->createQueryBuilder('user')
            ->where('user.id = :id')
            ->setParameter('id', $id->getBytes())
        ;

        return $this->oneOrException($qb);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function existsEmail(Email $email): ?UserId
    {
        $userId = $this->getUserByEmailQueryBuilder($email)
            ->select('user.id')
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY)
        ;

        return $userId['id'] ?? null;
    }

    /**
     * @throws NotFoundException
     * @throws NonUniqueResultException
     */
    public function oneByEmail(Email $email): User
    {
        return $this->oneOrException(
            $this->getUserByEmailQueryBuilder($email)
        );
    }

    /**
     * @throws NotFoundException
     * @throws NonUniqueResultException
     */
    public function oneByEmailAsArray(Email $email): array
    {
        return $this->oneOrException(
            $this->getUserByEmailQueryBuilder($email)
            ->select(
                '
                user.id,
                user.credentials.email,
                user.createdAt,
                user.updatedAt'
            ),
            AbstractQuery::HYDRATE_ARRAY
        );
    }

    /**
     * @throws NotFoundException
     * @throws NonUniqueResultException
     *
     * @return array{
     *   0: App\Auth\Domain\User\UserId,
     *   1: App\Auth\Domain\User\ValueObject\Email,
     *   2: \App\Domain\User\ValueObject\Auth\HashedPassword
     * }
     */
    public function getCredentialsByEmail(Email $email): array
    {
        $qb = $this->repository
            ->createQueryBuilder('user')
            ->where('user.credentials.email = :email')
            ->setParameter('email', $email->__toString());

        $user = $this->oneOrException($qb, AbstractQuery::HYDRATE_ARRAY);

        return [
            $user['id'],
            $user['credentials.email'],
            $user['credentials.password'],
        ];
    }
}
