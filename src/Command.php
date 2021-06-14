<?php

namespace FrankDeJonge\CommandIdCorrelation;

use Ramsey\Uuid\UuidInterface;

interface Command
{
    public function dummyId(): DummyId;
}
