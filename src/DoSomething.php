<?php

namespace FrankDeJonge\CommandIdCorrelation;

use Ramsey\Uuid\UuidInterface;

class DoSomething implements Command
{
    public function __construct(private DummyId $id)
    {
    }

    public function dummyId(): DummyId
    {
        return $this->id;
    }
}
