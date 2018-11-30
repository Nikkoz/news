<?php

namespace frontend\controllers\posts;


use frontend\controllers\AppController;
use news\readModels\posts\RubricsReadRepository;
use news\readModels\posts\SubscribeReadRepository;
use yii\caching\Cache;

/**
 * Class RubricsController
 * @package frontend\controllers\posts
 *
 * @property Cache $cache
 * @property RubricsReadRepository $rubricsRepository
 */
class RubricsController extends AppController
{
    public function __construct(
        string $id,
        $module,
        Cache $cache,
        RubricsReadRepository $rubricsRepository,
        SubscribeReadRepository $subscribeRepository,
        array $config = []
    )
    {
        parent::__construct($id, $module, $cache, $rubricsRepository, $subscribeRepository, $config);
    }

    public function actionIndex(string $rubric)
    {
        $this->layout = 'inner/rubric';
        $this->view->params['page_class'] = [
            'wrapper' => 'page_roubrick',
            'header' => 'header_roubrick header_show_burger'
        ];

        $rubric = $this->rubricsRepository->getByAlias($rubric);


        return $this->render('index', [
            'rubric' => $rubric,
        ]);
    }

    public function actionPost(string $rubric, string $post)
    {
        $this->layout = 'inner/rubric';

        $this->view->params['page_class'] = [
            'wrapper' => '',
            'header' => 'header_need_burger-js  header_need_scroll-js'
        ];
    }
}