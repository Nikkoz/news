<?php

namespace news\jobs;


use news\entities\posts\News;
use news\entities\user\User;
use news\repositories\posts\NewsRepository;
use news\repositories\UserRepository;
use yii\mail\MailerInterface;

class DistributionNewsHandler
{
    private $repository;
    private $mailer;
    private $posts;

    public function __construct(UserRepository $repository, MailerInterface $mailer, NewsRepository $posts)
    {
        $this->repository = $repository;
        $this->mailer = $mailer;
        $this->posts = $posts;
    }

    public function handle(DistributionNews $news): void
    {
        // проверяем пользователя - подписан ли он и на что подписан
        // получаем посты на которые подписан пользователь
        // делаем рассылку
        //$this->sendDistribution();
    }

    private function sendDistribution(User $user, News $news): void
    {
        // отправляем рассылку пользователю
        //$this->mailer->send();
    }
}