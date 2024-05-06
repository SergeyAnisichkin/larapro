<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\Interfaces\AggregateEventInterface;

abstract class AbstractAggregate
{
    protected readonly string $uuid;
    protected int $id;
    protected array $events;

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function addEvent(AggregateEventInterface $event): void
    {
        $this->events[] = $event;
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    public function dispatchEvents(): void
    {
        foreach ($this->events as $event) {
            dispatch($event);
        }
    }
}