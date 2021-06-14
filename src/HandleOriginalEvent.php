<?php

namespace FrankDeJonge\CommandIdCorrelation;

use EventSauce\EventSourcing\AggregateRootRepository;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageConsumer;

class HandleOriginalEvent implements MessageConsumer
{
    public function __construct(private AggregateRootRepository $repository)
    {
    }

    public function handle(Message $message): void
    {
        $event = $message->event();

        if ( ! $event instanceof OriginalEvent) {
            return;
        }

        /** @var DummyAggregateRoot $dummy */
        $dummy = $this->repository->retrieve($message->aggregateRootId());
        $dummy->performAnotherAction();
        $this->repository->persist($dummy);
    }
}
