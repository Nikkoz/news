<?php
namespace frontend\controllers;

use news\readModels\posts\NewsReadRepository;
use news\readModels\posts\RubricsReadRepository;
use news\readModels\posts\SubscribeReadRepository;
use yii\caching\Cache;
use yii\web\Controller;

/**
 * Class SiteController
 * @package frontend\controllers
 *
 * @property RubricsReadRepository $rubricsRepository
 * @property NewsReadRepository $newsRepository
 */
class SiteController extends AppController
{
    private $newsRepository;

    public function __construct(
        string $id, $module,
        Cache $cache,
        RubricsReadRepository $rubricsRepository,
        NewsReadRepository $newsRepository,
        SubscribeReadRepository $subscribeRepository,
        array $config = []
    )
    {
        parent::__construct($id, $module, $cache, $rubricsRepository, $subscribeRepository, $config);

        $this->newsRepository = $newsRepository;
    }

    public function actions(): array
    {
        return \array_merge(parent::actions(), [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ]
        ]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionError()
    {
        echo 'error';
    }
}
