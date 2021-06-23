<?php
declare(strict_types=1);

namespace App\Infrastructure\Event\Event;

use App\Shared\Application\Event\EventHandlerInterface;
use App\Shared\Application\Event\EventInterface;
use App\Infrastructure\Event\Repository\EventDoctrineRepository;

class OnEvent implements EventHandlerInterface
{
    private EventDoctrineRepository $repository;

    public function __construct(
        EventDoctrineRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function __invoke(EventInterface $event): void
    {
        $this->repository->store($event);
    }
}
