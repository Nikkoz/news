<?php

namespace news\services\auth;

use news\entities\user\User;
use news\forms\auth\LoginForm;
use news\repositories\UserRepository;


/**
 * Class AuthService
 * @package news\services\auth
 *
 * @property UserRepository $repository
 */
class AuthService
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function auth(LoginForm $form): User
    {
        $user = $this->repository->findByUserNameOrEmail($form->username);

        if(!$user || !$user->isActive() || !$user->validatePassword($form->password)) {
            throw new \DomainException('Undefined user or password.');
        }

        $user->last_auth = time();
        $this->repository->save($user);

        return $user;
    }
}