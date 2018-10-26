<?php

namespace news\job;


use yii\queue\JobInterface;

abstract class Job implements JobInterface
{
    public function execute($queue)
    {
        $listener = $this->resolveHandler();
        $listener($this, $queue);
    }

    /**
     * @return callable
     * @throws \yii\base\InvalidConfigException
     */
    private function resolveHandler(): callable
    {
        return [\Yii::createObject(static::class . 'Handler'), 'handle'];
    }
}