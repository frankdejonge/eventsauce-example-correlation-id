<?php

namespace FrankDeJonge\CommandIdCorrelation;

use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDecorator;

class CorrelatingMessageDecorator implements MessageDecorator
{
    public function __construct(private CorrelationIdTracker $tracker)
    {
    }

    public function decorate(Message $message): Message
    {
        if ($id = $this->tracker->currentId()) {
            return $message->withHeader('correlation-id', $id->toString());
        }

        return $message;
    }
}
