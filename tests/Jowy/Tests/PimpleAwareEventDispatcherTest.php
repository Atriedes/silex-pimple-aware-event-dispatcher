<?php


namespace Jowy\Tests;

use Jowy\Tests\Events\TestEvent;
use Jowy\Tests\Listeners\TestListener;
use Jowy\Tests\Subscribers\TestSubscriber;
use Pimple\Container;
use Silex\Provider\PimpleAwareEventDispatcherServiceProvider;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class PimpleAwareEventDispatcherTest
 * @package Jowy\Tests
 */
class PimpleAwareEventDispatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Container
     */
    private $app;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->app = new Container();
        $this->app->register(new PimpleAwareEventDispatcherServiceProvider());
    }

    /**
     * test if return correct instance
     */
    public function testInstance()
    {
        $this->assertInstanceOf(EventDispatcher::class, $this->app["dispatcher"]);
    }

    /**
     * test object listener
     */
    public function testListener()
    {
        $listener = new TestListener();
        $this->app["dispatcher"]->addListener("test.action", [$listener, "onTestAction"]);

        $event = $this->app["dispatcher"]->dispatch("test.action", new TestEvent());

        $this->assertEquals($event->getNick(), "jowy");
    }

    /**
     * test closure listener
     */
    public function testClosureListener()
    {
        $this->app["dispatcher"]->addListener("test.action", function (Event $event) {
            if (! $event instanceof TestEvent) {
                throw new \RuntimeException("invalid event");
            }

            $event->setNick("jowy");
        });

        $event = $this->app["dispatcher"]->dispatch("test.action", new TestEvent());

        $this->assertEquals($event->getNick(), "jowy");
    }

    /**
     * test listener in container
     */
    public function testContainerListener()
    {
        $this->app["test.listener"] = function () {
            return new TestListener();
        };

        $this->app["dispatcher"]->addListenerService("test.action", ["test.listener", "onTestAction"]);

        $event = $this->app["dispatcher"]->dispatch("test.action", new TestEvent());

        $this->assertEquals($event->getNick(), "jowy");
    }

    /**
     * test remove listener in container
     */
    public function testContainerRemoveListener()
    {
        $this->app["test.listener"] = function () {
            return new TestListener();
        };

        $this->app["dispatcher"]->addListenerService("test.action", ["test.listener", "onTestAction"]);

        $this->assertTrue($this->app["dispatcher"]->hasListeners("test.action"));

        $this->app["dispatcher"]->removeListener("test.action", [$this->app["test.listener"], "onTestAction"]);

        $this->assertFalse($this->app["dispatcher"]->hasListeners("test.action"));
    }

    /**
     * test remove closure listener
     */
    public function testClosureRemoveListener()
    {
        $closure = function (Event $event) {
            if (! $event instanceof TestEvent) {
                throw new \RuntimeException("invalid event");
            }

            $event->setNick("jowy");
        };

        $this->app["dispatcher"]->addListener("test.action", [$closure, "onTestAction"]);

        $this->assertTrue($this->app["dispatcher"]->hasListeners("test.action"));

        $this->app["dispatcher"]->removeListener("test.action", [$closure, "onTestAction"]);

        $this->assertFalse($this->app["dispatcher"]->hasListeners("test.action"));
    }

    /**
     * test subscriber in container
     */
    public function testContainerSubscriber()
    {
        $this->app["test.subscriber"] = function () {
            return new TestSubscriber();
        };

        $this->app["dispatcher"]->addSubscriberService("test.subscriber", TestSubscriber::class);

        $event = $this->app["dispatcher"]->dispatch("test.event", new TestEvent());

        $this->assertEquals($event->getNick(), "jowy");
    }
}

// EOF
