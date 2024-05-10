<?php

declare(strict_types=1);

namespace App\Domain\Events;

use App\Domain\Entities\AbstractAggregate;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class AbstractAggregateEvent
{
    use Dispatchable;
    use SerializesModels;

    abstract public function getOldAggregate(): AbstractAggregate;
    abstract public function getNewAggregate(): AbstractAggregate;
}