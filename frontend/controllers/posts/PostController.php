<?php

namespace frontend\controllers\posts;


use frontend\controllers\AppController;
use news\helpers\NewsHelper;
use news\readModels\posts\NewsReadRepository;
use news\readModels\posts\RubricsReadRepository;
use news\readModels\posts\SubscribeReadRepository;
use yii\caching\Cache;

/**
 * Class PostsController
 * @package frontend\controllers\posts
 *
 * @property NewsReadRepository $newsRepository
 */
class PostController extends AppController
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
     * @param string $post
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex(string $rubric, string $post): string
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

        return $this->render('index', [
            'rubric' => $rubric,
            'post' => $post,
            'posts' => $posts
        ]);
    }

    /**
     * @param string $alias
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionAnalytic(string $alias): string
    {
        $this->view->params['pageParams'] = [
            'wrapper' => '',
            'header' => 'header_need_burger-js  header_need_scroll-js header_need_trasparent-js header_transparent',
            'type' => 'analytic',
        ];

        $post = $this->newsRepository->getByAlias($alias);

        $tagIDs = NewsHelper::getTags($post);
        $posts = $this->newsRepository->getByTags(6, $tagIDs);

        return $this->render('analytic', [
            'post' => $post,
            'posts' => $posts
        ]);
    }
}