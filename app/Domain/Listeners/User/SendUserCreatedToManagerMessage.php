<?php

declare(strict_types=1);

namespace App\Domain\Listeners\User;

use App\Domain\Events\AbstractAggregateEvent;

class SendUserCreatedToManagerMessage
{
    public function handle(AbstractAggregateEvent $event): void
    {
    }
}
