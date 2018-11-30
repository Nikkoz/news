<?php

namespace news\readModels\posts;


use news\entities\Subscribe;

class SubscribeReadRepository
{
    public function count(): int
    {
        return Subscribe::find()->count();
    }
}