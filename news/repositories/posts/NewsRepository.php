<?php
namespace news\repositories\posts;


use news\entities\posts\News;

class NewsRepository
{
    public function get($id): News
    {
        if(!$news = News::findOne($id)) {
            throw new \DomainException('News is not found.');
        }

        return $news;
    }

    public function getBy(array $conditions): array
    {
        if(!$articles = News::find()->andWhere($conditions)->all()) {
            throw new \DomainException('Articles are not found.');
        }

        return $articles;
    }

    public function save(News $news): void
    {
        if(!$news->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(News $news): void
    {
        if(!$news->delete()) {
            throw new \DomainException('Removing error.');
        }
    }
}