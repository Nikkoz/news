<?php

namespace backend\controllers\posts;

use news\forms\manage\posts\post\VideosForm;
use news\services\manage\posts\VideosManageService;
use yii\helpers\Json;
use yii\web\Controller;
use common\models\posts\Videos;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use common\models\Pictures;


/**
 * VideosController implements the CRUD actions for News model.
 */
class VideosController extends Controller
{
    private $service;

    public function __construct(string $id, $module, VideosManageService $service, array $config = [])
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

    public function actionList()
    {
        if(\Yii::$app->request->isAjax) {
            $videos = Videos::find()->where(['in', 'id', \Yii::$app->request->get('videos')])->all();

            if(!empty($videos)) {
                return Json::encode([
                    'success' => 'Y',
                    'list' => $this->renderPartial('_videoList', [
                        'model' => $videos,
                    ]),
                ]);
            }

            return Json::encode(['success' => 'N']);
        }
    }

    public function actionForm($number)
    {
        if(\Yii::$app->request->isAjax) {
            return $this->renderPartial('_form', [
                'model' => new VideosForm(),
                'number' => $number,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->service->remove($id);

        return Json::encode(['success' => 'Y', 'id' => $id]);
    }

    /**
     * Finds the Sliders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Videos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Videos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('posts', 'The requested page does not exist.'));
    }

    protected function picturesDeleted($picture)
    {
        if(!empty($picture)) {
            $dir = \Yii::getAlias('@images') . '/posts/';
            if(file_exists($dir . $picture->name)) {
                unlink($dir . $picture->name);
            }

            $picture->delete();
        }
    }
}