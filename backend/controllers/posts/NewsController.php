<?php

namespace backend\controllers\posts;

use backend\forms\posts\NewsSearch;
use news\entities\posts\News;
use news\entities\posts\slider\Sliders;
use news\entities\posts\video\Videos;
use news\forms\manage\posts\post\NewsCreateForm;
use news\forms\manage\posts\post\NewsEditForm;
use news\forms\manage\posts\post\SlidersForm;
use news\forms\manage\posts\post\VideosForm;
use news\services\manage\posts\NewsManageService;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Response;

/**
 * Class NewsController
 * @package backend\controllers
 *
 * @property NewsManageService $service
 */
class NewsController extends Controller
{
    /**
     * @var NewsManageService
     */
    private $service;

    /**
     * NewsController constructor.
     * @param string $id
     * @param $module
     * @param NewsManageService $service
     * @param array $config
     */
    public function __construct(string $id, $module, NewsManageService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = $service;
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'remove-picture' => ['POST'],
                    'remove-slider-picture' => ['POST'],
                    'remove-video-picture' => ['POST'],
                    'remove-slider' => ['POST'],
                    'remove-video' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new NewsCreateForm();

        if(\Yii::$app->request->isPost) {
            $form->sliders = $form->setSliders(count(\Yii::$app->request->post('SlidersForm')));
            $form->videos = $form->setVideos(count(\Yii::$app->request->post('VideosForm')));
        }

        if ($form->load(\Yii::$app->request->post())) {
            $form->detail_text = $this->service->setDetailText(\Yii::$app->request->post());

            if($form->validate()) {
                try {
                    $news = $this->service->create($form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Article created.'));
                    return $this->redirect(['news/index']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error adding article.'));
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $post = $this->findModel($id);

        $form = new NewsEditForm($post);

        if(\Yii::$app->request->isPost) {
            $form->sliders = $form->setSliders(\Yii::$app->request->post('SlidersForm'));
            $form->videos = $form->setVideos(\Yii::$app->request->post('VideosForm'));
        }

        if($form->load(Yii::$app->request->post())) {
            $form->detail_text = $this->service->setDetailText(\Yii::$app->request->post());

            if($form->validate()) {
                try {
                    $this->service->edit($id, $form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Article updated.'));
                    return $this->redirect(['news/index']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error',\Yii::t('app','Error updating article.'));
            }
        }

        return $this->render('update', [
            'model' => $form,
        ]);
    }

    public function actionActivate(int $id): Response
    {
        $backUrl = \Yii::$app->request->get('backUrl');

        try {
            $this->service->activate($id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect([$backUrl]);
    }

    public function actionDeactivate(int $id): Response
    {
        $backUrl = \Yii::$app->request->get('backUrl');

        try {
            $this->service->deactivate($id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect([$backUrl]);
    }

    public function actionList(): string
    {
        if(\Yii::$app->request->isAjax) {
            $current = \Yii::$app->request->get('current') ?: null;

            $news = $this->service->getAllArticlesWithoutCurrent($current);

            return Json::encode([
                'success' => 'Y',
                'test'=>$current,
                'list' => $this->renderPartial('_list', [
                    'model' => $news,
                ]),
            ]);
        }
    }

    public function actionRemovePicture(string $column, int $id): bool
    {
        if(\Yii::$app->request->isAjax) {
            try {
                $this->service->removePicture($id, $column);

                return true;
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
            }
        }
    }

    public function actionRemoveSliderPicture(int $id, int $picture): bool
    {
        if(\Yii::$app->request->isAjax) {
            try {
                $this->service->removeSliderPicture($id, $picture);

                return true;
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
            }
        }
    }

    public function actionRemoveVideoPicture(int $id, int $picture): bool
    {
        if(\Yii::$app->request->isAjax) {
            try {
                $this->service->removeVideoPicture($id, $picture);

                return true;
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
            }
        }
    }

    public function actionRemoveSlider(int $id): bool
    {
        if(\Yii::$app->request->isAjax) {
            try {
                $this->service->removeSlider($id);

                return true;
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
            }
        }
    }

    public function actionRemoveVideo(int $id): bool
    {
        if(\Yii::$app->request->isAjax) {
            try {
                $this->service->removeVideo($id);

                return true;
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
            }
        }
    }

    /**
     * @param int $id
     * @return bool|string
     * @throws NotFoundHttpException
     */
    public function actionUpdateSlider(int $id)
    {
        $load = [];

        if(\Yii::$app->request->isAjax) {
            $slider = $this->findSliderModel($id);
            $form = new SlidersForm($slider);

            foreach (\Yii::$app->request->post('SlidersForm') as $i => $slider) {
                if($slider['id'] == $id) {
                    $load = \Yii::$app->request->post('SlidersForm')[$i];
                    break;
                }
            }

            if($form->load($load, '') && $form->validate()) {
                try {
                    $this->service->updateSlider($id, $form);
                    return true;
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    return \Yii::t('app','Error updating slider.');
                }
            }
        }
    }

    /**
     * @param int $id
     * @return bool|string
     * @throws NotFoundHttpException
     */
    public function actionUpdateVideo(int $id)
    {
        $load = [];

        if(\Yii::$app->request->isAjax) {
            $slider = $this->findVideoModel($id);
            $form = new VideosForm($slider);

            foreach (\Yii::$app->request->post('VideosForm') as $i => $video) {
                if($video['id'] == $id) {
                    $load = \Yii::$app->request->post('VideosForm')[$i];
                    break;
                }
            }

            if($form->load($load, '') && $form->validate()) {
                try {
                    $this->service->updateVideo($id, $form);
                    return true;
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    return \Yii::t('app','Error updating video.');
                }
            }
        }
    }

    /**
     * @param int $id
     */
    public function actionDelete(int $id)
    {
        try {
            $this->service->remove($id);

            $this->redirect(Url::toRoute('news/index'));
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the Slider model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sliders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findSliderModel(int $id)
    {
        if (($model = Sliders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the Videos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Videos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findVideoModel(int $id)
    {
        if (($model = Videos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}