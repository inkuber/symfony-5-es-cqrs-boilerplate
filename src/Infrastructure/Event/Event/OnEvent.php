<?php
declare(strict_types=1);

namespace App\Infrastructure\Event\Event;

use App\Shared\Application\Event\EventHandlerInterface;
use App\Shared\Application\Event\EventInterface;
use App\Infrastructure\Event\Repository\EventMysqlRepository;

class OnEvent implements EventHandlerInterface
{
    private EventMysqlRepository $repository;

    public function __construct(
        EventMysqlRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function __invoke(EventInterface $event): void
    {
        $this->repository->store($event);
    }
}
