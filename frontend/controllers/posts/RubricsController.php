<?php

namespace frontend\controllers\posts;


use frontend\controllers\AppController;
use news\helpers\NewsHelper;
use news\helpers\rubrics\RubricsHelper;
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

    /**
     * @param string $rubric
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex(string $rubric)
    {
        $this->view->params['pageParams'] = [
            'wrapper' => 'page_roubrick',
            'header' => 'header_roubrick header_show_burger',
            'type' => 'rubric',
        ];

        $template = 'template_news';
        $rubric = $this->rubricsRepository->getByAlias($rubric);

        if ($rubric->slug === 'novosti') {
            $dataProvider = $this->newsRepository->getAll(17);
        } else {
            $dataProvider = $this->newsRepository->getAllByRubric($rubric->id, 17);
            $template = $this->rubricsRepository->getPosition($rubric->id)->templateAssignment->file;
        }

        return $this->render('index', [
            'rubric' => $rubric,
            'dataProvider' => $dataProvider,
            'template' => $template,
        ]);
    }

    public function actionLoad(int $id, int $offset)
    {
        $limit = 6;
        $isNews = RubricsHelper::isNews($id);

        if (!$isNews) {
            $news = $this->newsRepository->getAllByRubric($id, $limit, $offset);
            $count = $this->cache->getOrSet(['news_count_rubric', 'rubric' => $id], function () use ($id) {
                return $this->newsRepository->countInRubric($id);
            }, null, new TagDependency(['tags' => ['posts']]));
        } else {
            $news = $this->newsRepository->getAll($limit, $offset);
            $count = $this->cache->getOrSet(['news_count'], function () use ($id) {
                return $this->newsRepository->count();
            }, null, new TagDependency(['tags' => ['posts']]));
        }

        \Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            'html' => $this->renderPartial('_load', [
                'news' => $news,
                'rubric' => !$isNews ? $this->rubricsRepository->getAliasById($id) : '',
                'isNews' => $isNews,
            ]),
            'pagination' => [
                'offset' => $offset + $limit,
                'show' => $count > $offset + $limit,
                'count' => $count
            ]
        ];
    }

    /**
     * @param string $rubric
     * @param string $post
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionPost(string $rubric, string $post)
    {
        $this->view->params['pageParams'] = [
            'wrapper' => '',
            'header' => 'header_need_burger-js  header_need_scroll-js',
            'type' => 'post',
        ];

        $rubric = $this->rubricsRepository->getByAlias($rubric);
        $post = $this->newsRepository->getByAlias($post);

        $tagIDs = NewsHelper::getTags($post);

        $posts = $this->newsRepository->getByTags(6, $tagIDs);

        return $this->render('post', [
            'rubric' => $rubric,
            'post' => $post,
            'posts' => $posts
        ]);
    }
}