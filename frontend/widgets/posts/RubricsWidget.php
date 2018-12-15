<?php

namespace frontend\widgets\posts;


use news\readModels\posts\NewsReadRepository;
use yii\base\Widget;

/**
 * Class RubricsWidget
 * @package frontend\widgets\posts
 *
 * @property NewsReadRepository $repository
 */
class RubricsWidget extends Widget
{
    public $sort = [
        'discussing' => 'Обсуждают',
        'reading' => 'Читают',
        'choice' => 'Выбор редакции'
    ];
    private $repository;

    public function __construct(NewsReadRepository $repository, array $config = [])
    {
        parent::__construct($config);

        $this->repository = $repository;
    }

    public function run(): string
    {
        $posts = [];

        foreach ($this->sort as $type => $title) {
            $posts[$type] = [
                'items' => $this->repository->getNewsBy(5, [$type => 1], 0),
                'title' => $title
            ];
        }
        return $this->render('newsBlock', [
            'posts' => $posts,
        ]);
    }
}