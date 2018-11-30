<?php

namespace frontend\widgets\posts;


use news\readModels\posts\NewsReadRepository;
use yii\base\Widget;

/**
 * Class ArticlesCarousel
 * @package frontend\widgets\posts
 *
 * @property NewsReadRepository $repository
 */
class ArticleCarouselWidget extends Widget
{
    private $repository;

    public function __construct(NewsReadRepository $repository, array $config = [])
    {
        parent::__construct($config);

        $this->repository = $repository;
    }

    public function run(): string
    {
        return $this->render('articlesCarousel', [
            'news' => $this->repository->lastNews(15),
        ]);
    }
}