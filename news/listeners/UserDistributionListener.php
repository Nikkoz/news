<?php

namespace news\listeners;


use news\entities\user\events\UserDistribution;
use news\job\DistributionNews;
use news\repositories\UserRepository;
use yii\queue\redis\Queue;

class UserDistributionListener
{
    private $queue;

    public function __construct(UserRepository $repository, Queue $queue)
    {
        $this->queue = $queue;
    }

    public function handle(UserDistribution $event): void
    {
        if($event->user->isActive()) {
            $this->queue->push(new DistributionNews($event->user));
        }
    }
}