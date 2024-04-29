<?php

declare(strict_types=1);

namespace App\Domain\Events\User;

use App\Domain\Entities\User\User;
use App\Domain\Interfaces\AggregateEventInterface;

class UserCreated implements AggregateEventInterface
{
    public function __construct(
        private readonly User $user,
    ) {
    }

    public function getOldAggregate(): User
    {
        return $this->user;
    }

    public function getNewAggregate(): User
    {
        return $this->user;
    }
}
