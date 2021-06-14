<?php

namespace FrankDeJonge\CommandIdCorrelation;

use Ramsey\Uuid\UuidInterface;

class DoSomething implements Command
{
    public function __construct(private DummyId $id, private UuidInterface $requestId)
    {
    }

    public function dummyId(): DummyId
    {
        return $this->id;
    }

    public function requestId(): UuidInterface
    {
        return $this->requestId;
    }
}
