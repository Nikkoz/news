<?php

namespace news\listeners;


use news\entities\user\events\UserCreateRequested;
use news\entities\user\User;
use yii\mail\MailerInterface;

/**
 * Class UserCreateRequestedListener
 * @package news\listeners
 *
 * @property MailerInterface $mailer
 */
class UserCreateRequestedListener
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function handle(UserCreateRequested $event): void
    {
        if($event->user->isActive()) {
            $roles = \Yii::$app->authManager->getRolesByUser($event->user->id);

            if(isset($roles['author'])) {
                $this->sendEmailNotification($event->user);
            }
        }
    }

    protected function sendEmailNotification(User $user): void
    {
        $sent = $this->mailer->compose(
            ['html' => 'user/create/confirm-html', 'text' => 'user/create/confirm-text'],
            ['user' => $user]
        )->setTo($user->email)
        ->setSubject('Create user confirm')
        ->send();

        if(!$sent) {
            throw new \RuntimeException('Email sending error.');
        }
    }
}