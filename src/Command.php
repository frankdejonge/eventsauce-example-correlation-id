<?php

namespace FrankDeJonge\CommandIdCorrelation;

use Ramsey\Uuid\UuidInterface;

interface Command
{
    public function requestId(): UuidInterface;
    public function dummyId(): DummyId;
}
