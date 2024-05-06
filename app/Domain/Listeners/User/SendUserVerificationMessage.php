<?php

declare(strict_types=1);

namespace App\Domain\Listeners\User;

use App\Domain\Interfaces\AggregateEventInterface;

class SendUserVerificationMessage
{
    public function handle(AggregateEventInterface $event): void
    {
        info('test', ['123']);
    }
}
