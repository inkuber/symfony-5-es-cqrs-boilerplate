<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Persistence\Repository;

class EntitylessMysqlRepository extends MysqlRepository
{
    protected function setEntityManager(): void
    {
    }
}
