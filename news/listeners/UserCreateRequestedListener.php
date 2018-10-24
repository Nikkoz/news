<?php

namespace news\listeners;


use news\entities\user\events\UserCreateRequested;
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
        $sent = $this->mailer->compose(
            ['html' => 'user/create/confirm-html', 'text' => 'user/create/confirm-text'],
            ['user' => $event->user]
        )->setTo($event->user->email)
        ->setSubject('Create user confirm')
        ->send();

        if(!$sent) {
            throw new \RuntimeException('Email sending error.');
        }
    }
}