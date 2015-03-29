## Silex Pimple Aware Event Dispatcher

Replace silex default event dispatcher with pimple aware event dispatcher

### Requirements

* PHP >= 5.5
* Pimple >= 3.0

### Installation

`composer require jowy/silex-pimple-aware-event-dispatcher`

### Usage

~~~php

$app = new Application();

$app->register(new PimpleAwareEventDispatcherServiceProvider());

// register listener in DIC
$app["key"] = function () {
            return new TestListener();
        };

// register service locator id and method 
$app["dispatcher"]->addListenerService("some.event", ["key", "method"]);

// dispatch event
$app["dispatcher"]->dispatch("some.event", new Event());

~~~

### License

MIT, see LICENSE