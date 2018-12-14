<?php

namespace frontend\controllers;


use news\forms\SubscribeForm;
use news\readModels\posts\RubricsReadRepository;
use news\readModels\posts\SubscribeReadRepository;
use yii\caching\Cache;
use yii\caching\TagDependency;
use yii\web\Controller;

/**
 * Class AppController
 * @package frontend\controllers
 *
 * @property Cache $cache
 * @property RubricsReadRepository $rubricsRepository
 * @property SubscribeReadRepository $subscribeRepository
 */
class AppController extends Controller
{
    protected $cache;
    protected $rubricsRepository;
    protected $subscribeRepository;

    public function __construct(
        string $id,
        $module,
        Cache $cache,
        RubricsReadRepository $rubricsRepository,
        SubscribeReadRepository $subscribeRepository,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);

        $this->cache = $cache;
        $this->rubricsRepository = $rubricsRepository;
        $this->subscribeRepository = $subscribeRepository;
    }

    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        $this->view->params['subscribeForm'] = new SubscribeForm();
        $this->view->params['rubrics'] = $this->cache->getOrSet(['rubrics_list'], function () {
            return $this->rubricsRepository->getAll()->getModels();
        }, null, new TagDependency(['tags' => ['rubrics']]));

        $this->view->params['subscribers'] = $this->cache->getOrSet(['subscribers_list'], function () {
            return $this->subscribeRepository->count();
        }, null, new TagDependency(['tags' => ['subscribers']]));

        $this->view->params['pageParams'] = [
            'wrapper' => '',
            'header' => '',
            'type' => '',
        ];

        return parent::beforeAction($action);
    }
}