<?php

namespace backend\controllers;


use backend\forms\SubscribeSearch;
use news\entities\Subscribe;
use news\forms\manage\SubscribeForm;
use news\services\manage\SubscribeManageService;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class SubscribeController
 * @package backend\controllers
 *
 * @property SubscribeManageService $service
 */
class SubscribeController extends Controller
{
    private $service;

    public function __construct(string $id, $module, SubscribeManageService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = $service;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Subscribe models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SubscribeSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Subscribe model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new SubscribeForm();

        if ($form->load(\Yii::$app->request->post())) {
            if($form->validate()) {
                try {
                    $subscribe = $this->service->create($form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Subscribe created.'));
                    return $this->redirect(['/subscribe/index']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error adding subscribe.'));
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing Subscribe model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $subscribe = $this->findModel($id);

        $form = new SubscribeForm($subscribe);

        if ($form->load(\Yii::$app->request->post())) {
            if($form->validate()) {
                try {
                    $this->service->edit($subscribe->id, $form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Subscribe updated.'));
                    return $this->redirect(['subscribe/index']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error updating subscribe.'));
            }
        }

        return $this->render('update', [
            'model' => $form,
            'rubric' => $subscribe
        ]);
    }

    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);

            $this->redirect(Url::toRoute('subscribe/index'));
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    /**
     * Finds the Rubrics model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Subscribe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subscribe::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
}