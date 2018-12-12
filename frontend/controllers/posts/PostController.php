<?php

namespace frontend\controllers\posts;


use frontend\controllers\AppController;
use news\helpers\NewsHelper;
use news\readModels\posts\NewsReadRepository;
use news\readModels\posts\RubricsReadRepository;
use news\readModels\posts\SubscribeReadRepository;
use news\readModels\posts\TagsReadRepository;
use yii\caching\Cache;
use yii\caching\TagDependency;
use yii\web\Response;

/**
 * Class PostsController
 * @package frontend\controllers\posts
 *
 * @property NewsReadRepository $newsRepository
 * @property TagsReadRepository $tagsRepository
 */
class PostController extends AppController
{
    public $layout = 'inner/rubric';

    private $newsRepository;
    private $tagsRepository;

    public function __construct(
        string $id,
        $module,
        Cache $cache,
        RubricsReadRepository $rubricsRepository,
        SubscribeReadRepository $subscribeRepository,
        NewsReadRepository $newsRepository,
        TagsReadRepository $tagsRepository,
        array $config = []
    )
    {
        parent::__construct($id, $module, $cache, $rubricsRepository, $subscribeRepository, $config);

        $this->newsRepository = $newsRepository;
        $this->tagsRepository = $tagsRepository;
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

    public function actionTag(string $tag): string
    {
        $this->view->params['pageParams'] = [
            'wrapper' => 'page_roubrick',
            'header' => 'header_roubrick header_show_burger',
            'type' => 'rubric',
        ];

        $tagId = $this->tagsRepository->getIdByTag($tag);
        $dataProvider = $this->newsRepository->getByTags(7, [$tagId]);

        return $this->render('tag', [
            'dataProvider' => $dataProvider,
            'tag' => $tag,
            'tagId' => $tagId,
        ]);
    }

    /**
     * @param int $id
     * @param int $offset
     * @return array
     */
    public function actionLoad(int $id, int $offset): array
    {
        $limit = 6;

        $news = $this->newsRepository->getAll($limit, $offset);
        $count = $this->cache->getOrSet(['news_count_tag', 'tag' => $id], function () use ($id) {
            return $this->newsRepository->countNewsWithTag($id);
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