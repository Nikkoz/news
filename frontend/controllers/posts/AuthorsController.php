<?php

namespace frontend\controllers\posts;


use frontend\controllers\AppController;
use news\readModels\AuthorsReadRepository;
use news\readModels\posts\NewsReadRepository;
use news\readModels\posts\RubricsReadRepository;
use news\readModels\posts\SubscribeReadRepository;
use yii\caching\Cache;
use yii\caching\TagDependency;
use yii\web\Response;

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
        $this->view->params['pageParams']['type'] = 'authors';

        return $this->render('index', [
            'authors' => $this->authorRepository->getAuthors(),
        ]);
    }

    public function actionDetail(int $id): string
    {
        return $this->render('detail', [
            'author' => $this->authorRepository->getAuthor($id),
            'dataProvider' => $this->newsRepository->getByAuthor($id, 10)
        ]);
    }

    public function actionLoad(int $id, int $offset): array
    {
        $limit = 6;

        $news = $this->newsRepository->getByAuthor($id, $limit, $offset);
        $count = $this->cache->getOrSet(['news_count_author', 'author' => $id], function () use ($id) {
            return $this->newsRepository->countAuthorNews($id);
        }, null, new TagDependency(['tags' => ['posts']]));

        \Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            'html' => $this->renderPartial('_load', [
                'news' => $news,
            ]),
            'pagination' => [
                'offset' => $offset + $limit,
                'show' => $count > $offset + $limit,
                'count' => $count
            ]
        ];
    }
}