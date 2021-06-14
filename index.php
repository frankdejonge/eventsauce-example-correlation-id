<?php

use EventSauce\EventSourcing\EventSourcedAggregateRootRepository;
use EventSauce\EventSourcing\Header;
use EventSauce\EventSourcing\InMemoryMessageRepository;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDispatcher;
use EventSauce\EventSourcing\UnableToDispatchMessages;
use FrankDeJonge\CommandIdCorrelation\CorrelatingMessageDecorator;
use FrankDeJonge\CommandIdCorrelation\CorrelationIdTracker;
use FrankDeJonge\CommandIdCorrelation\CorrelationTrackingConsumer;
use FrankDeJonge\CommandIdCorrelation\DummyAggregateRoot;
use FrankDeJonge\CommandIdCorrelation\DummyAggregateRootId;
use FrankDeJonge\CommandIdCorrelation\HandleOriginalEvent;
use FrankDeJonge\CommandIdCorrelation\OriginalEvent;
use Ramsey\Uuid\Uuid;

include_once __DIR__ . '/vendor/autoload.php';

/**
 * This is an object that holds state, in a DI this should be shared.
 */
$correlationIdTracker = new CorrelationIdTracker();
/**
 * Message dispatcher that allows you to see what is dispatched.
 */
$messageDispatcher = new class() implements MessageDispatcher {
    public array $messages = [];
    public function dispatch(Message ...$messages): void
    {
        array_push($this->messages, ...$messages);
    }
};
$messageRepository = new InMemoryMessageRepository();

/**
 * A decorator that ensures the correlation ID is forwarded to the next event.
 */
$decorator = new CorrelatingMessageDecorator($correlationIdTracker);
$aggregateRootRepository = new EventSourcedAggregateRootRepository(DummyAggregateRoot::class, $messageRepository, $messageDispatcher, $decorator);

$actualConsumer = new HandleOriginalEvent($aggregateRootRepository);
$consumer = new CorrelationTrackingConsumer($correlationIdTracker, $actualConsumer);

$consumer->handle(new Message(new OriginalEvent(), ['correlation-id' => $id = Uuid::uuid4()->toString(), Header::AGGREGATE_ROOT_ID => new DummyAggregateRootId('something')]));

var_dump($id);
var_dump($messageDispatcher->messages);
