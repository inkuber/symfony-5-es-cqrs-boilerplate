<?php

declare(strict_types=1);

namespace App\Auth\Application\Query\User\FindByEmail;

use App\Auth\Domain\User\User;
use App\Shared\Application\Query\Item;
use App\Shared\Application\Query\QueryHandlerInterface;
use App\Infrastructure\Shared\Persistence\ReadModel\Exception\NotFoundException;
use App\Auth\Infrastructure\User\Repository\UserMysqlReadRepository;
use Doctrine\ORM\NonUniqueResultException;

final class FindByEmailHandler implements QueryHandlerInterface
{
    private UserMysqlReadRepository $repository;

    public function __construct(UserMysqlReadRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws NotFoundException
     * @throws NonUniqueResultException
     */
    public function __invoke(FindByEmailQuery $query): Item
    {
        $user = $this->repository->oneByEmailAsArray($query->email);

        return Item::fromPayload($user['id']->__toString(), User::class, $user);
    }
}
