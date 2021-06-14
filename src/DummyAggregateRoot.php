<?php

namespace FrankDeJonge\CommandIdCorrelation;

use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;

class DummyAggregateRoot implements AggregateRoot
{
    use AggregateRootBehaviour;

    public function performAnotherAction(): void
    {
        $this->recordThat(new AnotherActionWasPerformed());
    }

    private function applyAnotherActionWasPerformed(AnotherActionWasPerformed $event): void
    {
        // ignored
    }
}
