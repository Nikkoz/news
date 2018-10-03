<?php

namespace backend\controllers\posts;

use news\forms\manage\posts\RubricForm;
use news\services\manage\posts\RubricsManageService;
use Yii;
use news\entities\posts\rubric\Rubrics;
use backend\forms\posts\RubricsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RubricsController implements the CRUD actions for Rubrics model.
 */
class RubricsController extends Controller
{
    private $service;

    public function __construct(string $id, $module, array $config = [], RubricsManageService $service)
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
     * Lists all Rubrics models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RubricsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Rubrics model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new RubricForm();

        if ($form->load(Yii::$app->request->post())) {
            if($form->validate()) {
                try {
                    $rubric = $this->service->create($form);

                    Yii::$app->session->setFlash('success', Yii::t('app', 'Rubrics created.'));
                    return $this->redirect(['/posts/rubrics/index']);
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Error adding rubric.'));
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing Rubrics model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $rubric = $this->findModel($id);

        $form = new RubricForm($rubric);

        if ($form->load(Yii::$app->request->post())) {
            if($form->validate()) {
                try {
                    $this->service->edit($rubric->id, $form);

                    Yii::$app->session->setFlash('success', Yii::t('app', 'Rubrics updated.'));
                    return $this->redirect(['posts/rubrics/index']);
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Error updating rubric.'));
            }
        }

        return $this->render('update', [
            'model' => $form,
            'rubric' => $rubric
        ]);
    }

    /**
     * Deletes an existing Rubrics model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Rubrics model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rubrics the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rubrics::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
