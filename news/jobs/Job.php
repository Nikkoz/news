<?php

namespace news\jobs;


use yii\queue\JobInterface;

abstract class Job implements JobInterface
{
    /**
     * @param \yii\queue\Queue $queue
     * @return mixed|void
     * @throws \yii\base\InvalidConfigException
     */
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