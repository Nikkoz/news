<?php

namespace frontend\controllers\posts;


use frontend\controllers\AppController;
use news\readModels\posts\NewsReadRepository;
use news\readModels\posts\RubricsReadRepository;
use news\readModels\posts\SubscribeReadRepository;
use yii\caching\TagDependency;
use yii\redis\Cache;
use yii\web\Response;

/**
 * Class SearchController
 * @package frontend\controllers\posts
 *
 * @property NewsReadRepository $newsRepository
 */
class SearchController extends AppController
{
    public $layout = 'inner/rubric';

    private $newsRepository;

    public function __construct(
        string $id,
        $module,
        Cache $cache,
        RubricsReadRepository $rubricsRepository,
        SubscribeReadRepository $subscribeRepository,
        NewsReadRepository $newsRepository,
        array $config = []
    )
    {
        parent::__construct($id, $module, $cache, $rubricsRepository, $subscribeRepository, $config);

        $this->newsRepository = $newsRepository;
    }

    public function actionIndex(): string
    {
        $q = \Yii::$app->request->get('q' );

        $dataProvider = $this->newsRepository->getNewsBy(10, ['LIKE', 'title', $q]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'phrase' => $q
        ]);
    }

    public function actionLoad(string $q, int $offset): array
    {
        $limit = 6;

        $news = $this->newsRepository->getNewsBy($limit, ['LIKE', 'title', $q], $offset);
        $count = $this->cache->getOrSet(['news_count_search', 'phrase' => $q], function () use ($q) {
            return $this->newsRepository->countNewsSearch($q);
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