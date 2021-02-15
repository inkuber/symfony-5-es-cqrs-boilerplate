<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Persistence\Repository;

use App\Shared\Application\Event\EventBusInterface;
use Doctrine\ORM\EntityManagerInterface;

abstract class WriteMysqlRepository extends MysqlRepository
{
    private EventBusInterface $eventBus;

    public function __construct(EntityManagerInterface $entityManager, EventBusInterface $eventBus)
    {
        parent::__construct($entityManager);

        $this->eventBus = $eventBus;
    }

    /**
     * @param mixed $model
     */
    public function save($model): void
    {
        // change internal state of aggreate before save
        $events = $model->commitEvents();

        // persist
        $this->entityManager->persist($model);
        $this->apply();

        // allow other aggregates change their states after save
        $this->fireEvents($events);
    }

    public function apply(): void
    {
        $this->entityManager->flush();
    }

    protected function commitEvents($model, $events)
    {
        foreach ($events as $event) {
            $model->handle($event);
        }
    }

    protected function fireEvents($events)
    {
        foreach ($events as $event) {
            $this->eventBus->fire($event->getPayload());
        }
    }
}
