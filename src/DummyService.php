<?php

namespace FrankDeJonge\CommandIdCorrelation;

use EventSauce\EventSourcing\AggregateRootRepository;

class DummyService implements CommandHandler
{
    public function __construct(private AggregateRootRepository $repository)
    {
    }

    public function handle(Command $command): void
    {
        /** @var DummyAggregateRoot $dummy */
        $dummy = $this->repository->retrieve($command->dummyId());

        try {
            if ($command instanceof DoSomething) {
                $dummy->performAnotherAction();
            }
        } finally {
            $this->repository->persist($dummy);
        }
    }
}
