<?php

namespace backend\controllers;

use news\entities\posts\News;
use news\services\manage\PicturesManageService;
use Yii;
use common\models\Pictures;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Class PicturesController
 * @package backend\controllers
 *
 * @property PicturesManageService $service
 */
class PicturesController extends Controller
{
    private $service;

    public function __construct(string $id, $module, PicturesManageService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = $service;
    }

    public function behaviors()
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
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);

            if(\Yii::$app->request->isAjax) {
                return true;
            } else {
                return $this->redirect(['index']);
            }
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    protected function findModel($id)
    {
        if (($model = Pictures::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('posts', 'The requested page does not exist.'));
    }
}
