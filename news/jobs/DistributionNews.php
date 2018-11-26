<?php

namespace news\jobs;


use news\entities\user\User;

class DistributionNews extends Job
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}