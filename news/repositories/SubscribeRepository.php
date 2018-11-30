<?php

namespace news\repositories;


use news\entities\Subscribe;

class SubscribeRepository
{
    public function get($id): Subscribe
    {
        if(!$news = Subscribe::findOne($id)) {
            throw new \DomainException('Subscribe is not found.');
        }

        return $news;
    }

    public function getByEmail(string $email): array
    {
        if(!$articles = Subscribe::find()->andWhere(['email' => $email])->all()) {
            throw new \DomainException('Subscribe is not found.');
        }

        return $articles;
    }

    public function save(Subscribe $news): void
    {
        if(!$news->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Subscribe $news): void
    {
        if(!$news->delete()) {
            throw new \DomainException('Removing error.');
        }
    }
}