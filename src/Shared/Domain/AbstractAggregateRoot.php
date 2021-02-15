<?php

namespace App\Shared\Domain;

use Broadway\EventSourcing\EventSourcedAggregateRoot;

abstract class AbstractAggregateRoot extends EventSourcedAggregateRoot
{
    public $uncommittedEvents = [];

    /**
     * Handles event if capable.
     *
     * @param mixed $event
     */
    public function handle($event): void
    {
        $method = $this->getApplyMethod($event);

        if (!method_exists($this, $method)) {
            return;
        }

        $this->$method($event);
    }

    private function getApplyMethod($event): string
    {
        $classParts = explode('\\', get_class($event));

        return 'apply'.end($classParts);
    }

    protected function getChildEntities(): array
    {
        return [];
    }

    public function handleRecursively($event): void
    {
        $this->handle($event);

        foreach ($this->getChildEntities() as $entity) {
            $entity->registerAggregateRoot($this);
            $entity->handleRecursively($event);
        }
    }

    public function commitEvents(): array
    {
        $events = [];

        foreach ($this->getUncommittedEvents() as $event) {
            $this->handleRecursively($event);
            foreach ($this->getChildEntities() as $entity) {
                $events = $entity->commitEvents();
            }

            $events[] = $event;
        }

        return $events;
    }
}
