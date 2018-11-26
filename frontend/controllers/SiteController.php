<?php
namespace frontend\controllers;

use news\readModels\posts\NewsReadRepository;
use news\readModels\posts\RubricsReadRepository;
use yii\web\Controller;

/**
 * Class SiteController
 * @package frontend\controllers
 *
 * @property RubricsReadRepository $rubricsRepository
 * @property NewsReadRepository $newsRepository
 */
class SiteController extends Controller
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
