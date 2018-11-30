<?php

namespace news\listeners;


use news\entities\events\SubscribeRequested;
use yii\mail\MailerInterface;

/**
 * Class SubscribeListener
 * @package news\listeners
 *
 * @property MailerInterface $mailer
 */
class SubscribeRequestedListener
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function handle(SubscribeRequested $event): void
    {
        /*if($event->subscribe->email) {

        }*/

        $f = fopen(__FILE__.'.txt','a');
        fwrite($f, print_r($event,1));
        fclose($f);
    }

    /*protected function sendEmailNotification(string $email): void
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
    }*/
}