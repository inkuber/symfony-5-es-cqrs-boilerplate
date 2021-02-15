<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\User\Repository;

use App\Auth\Domain\User\Repository\UserRepositoryInterface;
use App\Auth\Domain\User\User;
use App\Auth\Domain\User\UserId;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;

/**
 * To use this implementation add binding to services.yml
 *
 * services:
 *   _defaults:
 *     bind:
 *       $userRepository: '@App\Infrastructure\User\Repository\UserWriteEventRepository'
 */
final class UserWriteEventRepository extends EventSourcingRepository implements UserRepositoryInterface
{
    public function __construct(
        EventStore $eventSourcingStore,
        EventBus $eventSourcingBus,
        array $eventStreamDecorators = []
    ) {
        parent::__construct(
            $eventSourcingStore,
            $eventSourcingBus,
            User::class,
            new PublicConstructorAggregateFactory(),
            $eventStreamDecorators
        );
    }

    public function store(User $user): void
    {
        $this->save($user);
    }

    public function get(UserId $id): User
    {
        /** @var User $user */
        $user = $this->load($id->__toString());

        return $user;
    }
}
