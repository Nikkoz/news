<?php

namespace frontend\controllers;


use news\entities\posts\News;
use news\entities\posts\rubric\Rubrics;
use news\entities\posts\rubric\templates\RubricPositions;
use news\readModels\posts\NewsReadRepository;
use news\readModels\posts\RubricsReadRepository;
use yii\web\Controller;

/**
 * Class MainController
 * @package frontend\controllers
 *
 * @property RubricsReadRepository $rubricsRepository
 * @property NewsReadRepository $newsRepository
 */
class MainController extends Controller
{
    private $rubricsRepository;
    private $newsRepository;

    public function __construct(
        string $id,
        $module,
        RubricsReadRepository $rubricsRepository,
        NewsReadRepository $newsRepository,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);

        $this->rubricsRepository = $rubricsRepository;
        $this->newsRepository = $newsRepository;
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
        $this->view->params['rubrics'] = $this->rubricsRepository->getAll()->getModels();

        /** @var News $hot */
        $hot = $this->newsRepository->getHotPost();
        $mainNews = $this->newsRepository->getPostsInNews(['<>', 'id', $hot ? $hot->id : ''], $hot ? 4 : 6);
        $positions = $this->rubricsRepository->getPositions();

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
}