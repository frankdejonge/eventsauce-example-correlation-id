<?php

namespace FrankDeJonge\CommandIdCorrelation;

use LogicException;
use Ramsey\Uuid\UuidInterface;

use function array_pop;
use function array_unshift;
use function end;
use function reset;
use function var_dump;

class CorrelationIdTracker
{
    private array $correlationIds = [];

    public function track(UuidInterface $id): void
    {
        $this->correlationIds[] = $id;
    }

    public function untrack(UuidInterface $id): void
    {
        $lastId = array_pop($this->correlationIds);

        if ( ! $lastId instanceof UuidInterface || !$lastId->equals($id)) {
            throw new LogicException('Current ID does not match '. $id->toString());
        }
    }

    public function currentId(): ?UuidInterface
    {
        return end($this->correlationIds) ?: null;
    }
}
