<?php


namespace Jowy\Tests\Events;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class TestEvent
 * @package Jowy\Tests\Events
 */
class TestEvent extends Event
{
    /**
     * @var string
     */
    protected $nick;

    /**
     * @return string
     */
    public function getNick()
    {
        return $this->nick;
    }

    /**
     * @param string $nick
     */
    public function setNick($nick)
    {
        $this->nick = $nick;
    }
}

// EOF
