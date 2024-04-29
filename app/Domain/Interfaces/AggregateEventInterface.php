<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

use App\Domain\Entities\AbstractAggregate;

interface AggregateEventInterface
{
    public function getOldAggregate(): AbstractAggregate;
    public function getNewAggregate(): AbstractAggregate;
}