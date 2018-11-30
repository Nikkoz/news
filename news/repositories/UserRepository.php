<?php

namespace news\repositories;


use news\dispatchers\EventDispatcher;
use news\entities\user\User;

/**
 * Class UserRepository
 * @package news\repositories
 *
 * @property EventDispatcher $dispatcher
 */
class UserRepository
{
    private $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function getByEmail(string $email): User
    {
        return $this->getBy(['email' => $email]);
    }

    public function getById(int $id): User
    {
        return $this->getBy(['id' => $id]);
    }

    public function existsByPasswordResetToken(string $token): bool
    {
        return (bool)User::findByPasswordResetToken($token);
    }

    public function getByPasswordResetToken(string $token): User
    {
        return $this->getBy(['password_reset_token' => $token]);
    }

    public function save(User $user): void
    {
        if (!$user->save()) {
            throw new \RuntimeException('Saving error.');
        }

        $this->dispatcher->dispatchAll($user->releaseEvents());
    }

    /**
     * @param \news\entities\user\User $user
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(User $user): void
    {
        if (!$user->delete()) {
            throw new \RuntimeException('Removing error.');
        }

        $this->dispatcher->dispatchAll($user->releaseEvents());
    }

    private function getBy(array $conditions): User
    {
        if (!$user = User::find()->andWhere($conditions)->limit(1)->one()) {
            throw new \DomainException('User is not found');
        }

        return $user;
    }

    public function findByUserNameOrEmail(string $value): User
    {
        return $this->getBy(['or', ['email' => $value], ['username' => $value]]);
    }

    /*public function getByEmailConfirmToken($token): User
    {
        return $this->getBy(['email_confirm_token' => $token]);
    }*/
}