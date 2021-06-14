<?php

namespace FrankDeJonge\CommandIdCorrelation;

use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageConsumer;
use Ramsey\Uuid\Uuid;

class CorrelationTrackingConsumer implements MessageConsumer
{
    public function __construct(private CorrelationIdTracker $tracker, private MessageConsumer $consumer)
    {
    }

    public function handle(Message $message): void
    {
        if ($id = $message->header('correlation-id')) {
            $id = Uuid::fromString($id);
            $this->tracker->track($id);
        }

        try {
            $this->consumer->handle($message);
        } finally {
            $this->tracker->untrack($id);
        }
    }
}
