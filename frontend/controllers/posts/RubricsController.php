<?php

namespace frontend\controllers\posts;


use frontend\controllers\AppController;
use news\readModels\posts\NewsReadRepository;
use news\readModels\posts\RubricsReadRepository;
use news\readModels\posts\SubscribeReadRepository;
use yii\caching\Cache;
use yii\caching\TagDependency;
use yii\web\Response;

/**
 * Class RubricsController
 * @package frontend\controllers\posts
 *
 * @property NewsReadRepository $newsRepository
 */
class RubricsController extends AppController
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

    public function actionIndex(string $rubric)
    {
        $this->view->params['pageParams'] = [
            'wrapper' => 'page_roubrick',
            'header' => 'header_roubrick header_show_burger',
            'type' => 'rubric',
        ];

        $rubric = $this->rubricsRepository->getByAlias($rubric);
        $dataProvider = $this->newsRepository->getAllByRubric($rubric->id, 17);
        $template = $this->rubricsRepository->getPosition($rubric->id);

        return $this->render('index', [
            'rubric' => $rubric,
            'dataProvider' => $dataProvider,
            'template' => $template ? $template->templateAssignment : (object)['file' => 'template1'],
        ]);
    }

    public function actionLoad(int $id, int $offset)
    {
        $limit = 6;

        $news = $this->newsRepository->getAllByRubric($id, 6, $offset);
        $count = $this->cache->getOrSet(['news_count', 'rubric' => $id], function () use ($id) {
            return $this->newsRepository->countInRubric($id);
        }, null, new TagDependency(['tags' => ['posts']]));

        \Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            'html' => $this->renderPartial('_load', [
                'news' => $news,
                'rubric' => $this->rubricsRepository->getAliasById($id)
            ]),
            'pagination' => [
                'offset' => $offset + $limit,
                'show' => $count > $offset + $limit
            ]
        ];
    }

    public function actionPost(string $rubric, string $post)
    {
        $this->view->params['pageParams'] = [
            'wrapper' => '',
            'header' => 'header_need_burger-js  header_need_scroll-js',
            'type' => 'post',
        ];

        $rubric = $this->rubricsRepository->getByAlias($rubric);

        return $this->render('index', [
            'rubric' => $rubric,
        ]);
    }
}