<?php

namespace backend\controllers\posts;


use backend\forms\posts\RubricTemplatesSearch;
use news\entities\posts\rubric\templates\RubricTemplates;
use news\forms\manage\posts\post\rubrics\TemplatesForm;
use news\services\manage\posts\rubrics\RubricTemplatesManageService;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class RubricTemplateController
 * @package backend\controllers\posts
 *
 * @property RubricTemplatesManageService $service
 */
class RubricTemplateController extends Controller
{
    private $service;

    public function __construct(string $id, $module, RubricTemplatesManageService $service, array $config = [])
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
        $searchModel = new RubricTemplatesSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new RubricTemplates model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new TemplatesForm();

        if ($form->load(\Yii::$app->request->post())) {
            if($form->validate()) {
                try {
                    $template = $this->service->create($form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Rubric template created.'));
                    return $this->redirect(['/posts/rubric-template/index']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error adding rubric template.'));
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing RubricTemplates model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $template = $this->findModel($id);

        $form = new TemplatesForm($template);

        if ($form->load(\Yii::$app->request->post())) {
            if($form->validate()) {
                try {
                    $this->service->edit($template->id, $form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Rubric template updated.'));
                    return $this->redirect(['posts/rubric-template/index']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error updating rubric template.'));
            }
        }

        return $this->render('update', [
            'model' => $form,
            'template' => $template
        ]);
    }

    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);

            $this->redirect(Url::toRoute('rubric-template/index'));
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    /**
     * Finds the Rubrics model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RubricTemplates the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RubricTemplates::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
}