<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Persistence\Repository;

use Doctrine\ORM\EntityManagerInterface;

abstract class ProjectionMysqlRepository extends MysqlRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }

    /**
     * @param mixed $model
     */
    public function save($model): void
    {
        // persist
        $this->entityManager->persist($model);
        $this->apply();
    }

    public function apply(): void
    {
        $this->entityManager->flush();
    }
}
