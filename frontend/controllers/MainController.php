<?php

namespace frontend\controllers;


use news\entities\posts\News;
use news\entities\posts\rubric\Rubrics;
use news\entities\posts\rubric\templates\RubricPositions;
use news\forms\SubscribeForm;
use news\readModels\posts\NewsReadRepository;
use news\readModels\posts\RubricsReadRepository;
use news\services\manage\SubscribeManageService;
use yii\caching\Cache;
use yii\caching\TagDependency;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class MainController
 * @package frontend\controllers
 *
 * @property RubricsReadRepository $rubricsRepository
 * @property NewsReadRepository $newsRepository
 * @property Cache $cache
 * @property SubscribeManageService $subscribeService
 */
class MainController extends Controller
{
    private $rubricsRepository;
    private $newsRepository;
    private $cache;
    private $subscribeService;

    public function __construct(
        string $id,
        $module,
        RubricsReadRepository $rubricsRepository,
        NewsReadRepository $newsRepository,
        SubscribeManageService $subscribeService,
        Cache $cache,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);

        $this->rubricsRepository = $rubricsRepository;
        $this->newsRepository = $newsRepository;
        $this->cache = $cache;
        $this->subscribeService = $subscribeService;
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $this->view->params['subscribeForm'] = new SubscribeForm();
        $this->view->params['rubrics'] = $this->cache->getOrSet(['rubrics'], function () {
            return $this->rubricsRepository->getAll()->getModels();
        }, null, new TagDependency(['tags' => ['rubrics']]));

        /** @var News $hot */
        $hot = $this->newsRepository->getHotPost();
        $mainNews = $this->newsRepository->getPostsInNews(['<>', 'id', $hot ? $hot->id : ''], $hot ? 4 : 6);


        $positions = $this->cache->getOrSet(['positions'], function() {
            return $this->rubricsRepository->getPositions();
        }, null, new TagDependency(['tags' => ['positions', 'rubrics']]));

        if($hot) {
            $this->layout = 'hot';
        } else {
            $this->layout = 'home';
        }

        $rubrics = [];

        foreach ($positions as $position) {
            /** @var RubricPositions $position */
            $rubric = $position->rubricAssignment;
            $template = $position->templateAssignment;

            $rubrics[] = (object)[
                'name' => $rubric->name,
                'alias' => $rubric->slug,
                'color' => $rubric->color,
                'analytic' => $this->newsRepository->getAnalyticByRubric($rubric->id),
                'template' => $template->file,
                'news' => $this->newsRepository->getNewsByRubric($rubric->id, $template->count_news),
            ];
        }

        $reading = $this->newsRepository->getNewsBy(5, ['reading' => 1]);
        $discussing = $this->newsRepository->getNewsBy(5, ['discussing' => 1]);
        $choice = $this->newsRepository->getNewsBy(5, ['choice' => 1]);

        return $this->render('index',\array_merge([
            'hot' => $hot,
            'news' => $mainNews,
            'positions' => $positions,
            'rubrics' => $rubrics
        ], compact('reading', 'discussing', 'choice')));
    }

    public function actionSubscribe()
    {
        $form = new SubscribeForm();

        if ($form->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;

            $subscribe = $this->subscribeService->create($form);

            return ['success' => 'Y'];
        }
    }

    public function actionSubscribeValidate()
    {
        $form = new SubscribeForm();

        if ($form->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($form);
        }
    }
}