<?php

namespace frontend\widgets\posts;


use news\readModels\posts\NewsReadRepository;
use yii\base\Widget;

/**
 * Class MainNewsWidget
 * @package frontend\widgets\posts
 *
 * @property NewsReadRepository $repository
 */
class MainNewsWidget extends Widget
{
    private $repository;

    public function __construct(NewsReadRepository $repository, array $config = [])
    {
        parent::__construct($config);

        $this->repository = $repository;
    }

    public function run(): string
    {
        return $this->render('mainNews', [
            'news' => $this->repository->getChoiceNews(5),
        ]);
    }
}