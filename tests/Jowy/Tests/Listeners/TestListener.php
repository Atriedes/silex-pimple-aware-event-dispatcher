<?php


namespace Jowy\Tests\Listeners;

use Jowy\Tests\Events\TestEvent;
use Symfony\Component\EventDispatcher\Event;

class TestListener
{
    public function onTestAction(Event $event)
    {
        if (! $event instanceof TestEvent) {
            throw new \RuntimeException("invalid event");
        }

        $event->setNick("jowy");
    }
}

// EOF
