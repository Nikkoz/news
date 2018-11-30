<?php

namespace news\entities\events;


use news\entities\Subscribe;

/**
 * Class SubscribeRequested
 * @package news\entities\events
 *
 * @property Subscribe $subscribe
 */
class SubscribeRequested
{
    public $subscribe;

    public function __construct(Subscribe $subscribe)
    {
        $this->subscribe = $subscribe;
    }
}