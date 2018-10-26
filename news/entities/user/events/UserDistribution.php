<?php

namespace news\entities\user\events;


use news\entities\user\User;

/**
 * Class UserDistribution
 * @package news\entities\user\events
 *
 * @property User $user
 */
class UserDistribution
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

}