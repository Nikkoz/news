<?php

namespace news\entities\user\events;


use news\entities\user\User;

/**
 * Class UserSignUpRequested
 * @package news\services\auth\events
 *
 * @property \news\entities\user\User $user
 */
class UserCreateRequested
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}