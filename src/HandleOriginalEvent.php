<?php

namespace FrankDeJonge\CommandIdCorrelation;

use EventSauce\EventSourcing\AggregateRootRepository;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageConsumer;
use Ramsey\Uuid\Uuid;

class HandleOriginalEvent implements MessageConsumer
{
    public function __construct(private CommandHandler $commandHandler)
    {
    }

    public function handle(Message $message): void
    {
        $event = $message->event();

        if ( ! $event instanceof OriginalEvent) {
            return;
        }

        $this->commandHandler->handle(new DoSomething($message->aggregateRootId(), Uuid::fromString($message->header('correlation-id'))));
    }
}
