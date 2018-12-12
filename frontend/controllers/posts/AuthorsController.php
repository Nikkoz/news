<?php

namespace frontend\controllers\posts;


use frontend\controllers\AppController;
use news\readModels\AuthorsReadRepository;
use news\readModels\posts\NewsReadRepository;
use news\readModels\posts\RubricsReadRepository;
use news\readModels\posts\SubscribeReadRepository;
use yii\caching\Cache;

/**
 * Class AuthorsController
 * @package frontend\controllers\posts
 *
 * @property NewsReadRepository $newsRepository
 * @property AuthorsReadRepository $authorRepository
 */
class AuthorsController extends AppController
{
    public $layout = 'inner/rubric';

    private $newsRepository;
    private $authorRepository;

    public function __construct(
        string $id,
        $module,
        Cache $cache,
        RubricsReadRepository $rubricsRepository,
        SubscribeReadRepository $subscribeRepository,
        NewsReadRepository $newsRepository,
        AuthorsReadRepository $authorRepository,
        array $config = []
    )
    {
        parent::__construct($id, $module, $cache, $rubricsRepository, $subscribeRepository, $config);

        $this->newsRepository = $newsRepository;
        $this->authorRepository = $authorRepository;
    }

    public function actionIndex(): string
    {
        $this->view->params['pageParams'] = [
            'wrapper' => 'page_roubrick',
            'header' => 'header_roubrick header_show_burger',
            'type' => 'rubric',
        ];

        $authors = $this->authorRepository->getAuthors();

        return $this->render('index', [
            'authors' => $authors,
        ]);
    }
}