<?php


namespace Jowy\Tests\Subscribers;

use Jowy\Tests\Events\TestEvent;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TestSubscriber implements EventSubscriberInterface
{
    public function onTestEvent(Event $event)
    {
        if (! $event instanceof TestEvent) {
            throw new \RuntimeException("invalid event");
        }

        $event->setNick("jowy");
    }

    public static function getSubscribedEvents()
    {
        return [
            "test.event" => [
                [
                    "onTestEvent",
                    0
                ]
            ]
        ];
    }
}

// EOF
