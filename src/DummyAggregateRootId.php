<?php

namespace FrankDeJonge\CommandIdCorrelation;

use EventSauce\EventSourcing\AggregateRootId;

class DummyAggregateRootId implements AggregateRootId
{
    public function __construct(private string $id)
    {
    }

    public function toString(): string
    {
        return $this->id;
    }

    public static function fromString(string $aggregateRootId): AggregateRootId
    {
        return new static($aggregateRootId);
    }
}
