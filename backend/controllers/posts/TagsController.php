<?php

namespace backend\controllers\posts;


use backend\forms\posts\TagsSearch;
use news\entities\posts\tags\Tags;
use news\forms\manage\posts\post\TagsForm;
use news\forms\manage\posts\TagForm;
use news\services\manage\posts\TagsManageService;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class TagsController
 * @package backend\controllers\posts
 *
 * @property TagsManageService $service
 */
class TagsController extends Controller
{
    private $service;

    public function __construct(string $id, $module, TagsManageService $service, array $config = [])
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

    public function actionIndex()
    {
        $searchModel = new TagsSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new TagForm();

        if ($form->load(\Yii::$app->request->post())) {
            if($form->validate()) {
                try {
                    $tag = $this->service->create($form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Tag created.'));
                    return $this->redirect(['/posts/tags/index']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error adding tag.'));
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
        $tag = $this->findModel($id);

        $form = new TagForm($tag);

        if ($form->load(\Yii::$app->request->post())) {
            if($form->validate()) {
                try {
                    $this->service->edit($tag->id, $form);

                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Tag updated.'));
                    return $this->redirect(['posts/tags/index']);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Error updating tag.'));
            }
        }

        return $this->render('update', [
            'model' => $form,
            'tag' => $tag
        ]);
    }

    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);

            $this->redirect(Url::toRoute('/tags'));
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return Tags|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Tags::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
}