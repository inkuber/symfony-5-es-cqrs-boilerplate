<?php
namespace App\Infrastructure\Event\Repository;

use App\Shared\Application\Event\EventInterface;
use App\Infrastructure\Event\Event;
use App\Infrastructure\Shared\Persistence\Repository\ProjectionMysqlRepository;

class EventMysqlRepository extends ProjectionMysqlRepository
{
    protected function setEntityManager(): void
    {
        /** @var EntityRepository $objectRepository */
        $objectRepository = $this->entityManager->getRepository(Event::class);
        $this->repository = $objectRepository;
    }

    public function store(EventInterface $event)
    {
        $this->save(Event::fromDomainEvent($event));
    }
}
