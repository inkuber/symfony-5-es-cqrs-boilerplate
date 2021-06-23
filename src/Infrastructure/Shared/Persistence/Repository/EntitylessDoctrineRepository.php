<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Persistence\Repository;

class EntitylessDoctrineRepository extends DoctrineRepository
{
    protected function setEntityManager(): void
    {
    }
}
