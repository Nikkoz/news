<?php

namespace news\services\auth\events;


use news\entities\User;

/**
 * Class UserSignUpRequested
 * @package news\services\auth\events
 *
 * @property User $user
 */
class UserSignUpRequested
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}