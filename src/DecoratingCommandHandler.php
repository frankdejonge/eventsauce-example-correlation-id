<?php

namespace FrankDeJonge\CommandIdCorrelation;

class DecoratingCommandHandler implements CommandHandler
{
    public function __construct(private CorrelationIdTracker $tracker, private CommandHandler $handler)
    {
    }

    public function handle(Command $command): void
    {
        $requestId = $command->requestId();
        $this->tracker->track($requestId);

        try {
            $this->handler->handle($command);
        } finally {
            $this->tracker->untrack($requestId);
        }
    }
}
