<?php

namespace backend\controllers\posts;


use backend\forms\posts\RubricPositionSearch;
use news\entities\posts\rubric\templates\RubricPositions;
use news\forms\manage\posts\post\rubrics\PositionForm;
use news\services\manage\posts\rubrics\RubricPositionManageService;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class RubricPositionController
 * @package backend\controllers\posts
 *
 * @property RubricPositionManageService $service
 */
class RubricPositionController extends Controller
{
    private $service;

    public function __construct(string $id, $module, RubricPositionManageService $service, array $config = [])
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
     * Lists all RubricTemplates models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RubricPositionSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new PositionForm();

        if ($form->load(\Yii::$app->request->post())) {
            if($form->validate()) {
                try {
                    $position = $this->service->create($form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Rubric position created.'));
                    return $this->redirect(['/posts/rubric-position/index']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error adding rubric position.'));
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $position = $this->findModel($id);

        $form = new PositionForm($position);

        if ($form->load(\Yii::$app->request->post())) {
            if($form->validate()) {
                try {
                    $this->service->edit($position->id, $form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Rubric position updated.'));
                    return $this->redirect(['posts/rubric-position/index']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error updating rubric position.'));
            }
        }

        return $this->render('update', [
            'model' => $form,
            'template' => $position
        ]);
    }

    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);

            $this->redirect(Url::toRoute('rubric-position/index'));
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return RubricPositions|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id): ?RubricPositions
    {
        if (($model = RubricPositions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
}