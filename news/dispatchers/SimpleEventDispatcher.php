<?php

namespace news\dispatchers;


use yii\di\Container;

/**
 * Class SimpleEventDispatcher
 * @package news\dispatchers
 *
 * @property array $listeners
 * @property Container $container
 */
class SimpleEventDispatcher implements EventDispatcher
{
    private $listeners;
    private $container;

    public function __construct(Container $container, array $listeners)
    {
        $this->listeners = $listeners;
        $this->container = $container;
    }

    public function dispatch($event): void
    {
        $eventName = get_class($event);

        if (array_key_exists($eventName, $this->listeners)) {
            foreach ($this->listeners[$eventName] as $listenerClass) {
                $listener = $this->resolveListener($listenerClass);
                $listener($event);
            }
        }
    }

    public function dispatchAll(array $events): void
    {
        foreach ($events as $event) {
            $this->dispatch($event);
        }
    }
    private function resolveListener($listenerClass): callable
    {
        return [$this->container->get($listenerClass), 'handle'];
    }
}