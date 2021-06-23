<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\User\Repository;

use App\Auth\Domain\User\Repository\UserRepositoryInterface;
use App\Auth\Domain\User\User;
use App\Auth\Domain\User\UserId;
use App\Infrastructure\Shared\Persistence\Repository\WriteDoctrineRepository;

final class UserWriteDoctrineRepository extends WriteDoctrineRepository implements
    UserRepositoryInterface
{
    protected function setEntityManager(): void
    {
        /** @var EntityRepository $objectRepository */
        $objectRepository = $this->entityManager->getRepository(User::class);
        $this->repository = $objectRepository;
    }

    public function store(User $user): void
    {
        $this->save($user);
    }

    public function get(UserId $id): User
    {
        /** @var User $user */
        $user = $this->oneById($id);

        return $user;
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
}
