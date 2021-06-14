<?php

namespace FrankDeJonge\CommandIdCorrelation;

use EventSauce\EventSourcing\AggregateRootRepository;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageConsumer;

class HandleOriginalEvent implements MessageConsumer
{
    public function __construct(private DummyService $service)
    {
    }

    public function handle(Message $message): void
    {
        $event = $message->event();

        if ( ! $event instanceof OriginalEvent) {
            return;
        }

        $this->service->handle(new DoSomething($message->aggregateRootId()));
    }
}
