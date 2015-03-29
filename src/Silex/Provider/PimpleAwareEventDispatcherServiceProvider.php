<?php


namespace Silex\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\PimpleAwareEventDispatcher;

/**
 * Class PimpleAwareEventDispatcherServiceProvider
 * @package Silex\Provider
 */
class PimpleAwareEventDispatcherServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $container
     */
    public function register(Container $container)
    {
        // override current dispatcher to ours
        $container["dispatcher"] = function () use ($container) {
            return new PimpleAwareEventDispatcher($container);
        };
    }
}

// EOF
