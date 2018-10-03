<?php

namespace news\services\auth;

use news\entities\User;
use news\forms\auth\LoginForm;
use news\repositories\UserRepository;


class AuthService
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function auth(LoginForm $form): User
    {
        $user = $this->users->findByUserNameOrEmail($form->username);

        if(!$user || !$user->isActive() || !$user->validatePassword($form->password)) {
            throw new \DomainException('Undefined user or password.');
        }

        return $user;
    }
}