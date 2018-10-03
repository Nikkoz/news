<?php

namespace backend\controllers\posts;

use news\forms\manage\posts\post\SlidersForm;
use news\services\manage\posts\SlidersManageService;
use yii\helpers\Json;
use yii\web\Controller;
use news\entities\posts\slider\Sliders;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SlidersController implements the CRUD actions for News model.
 */
class SlidersController extends Controller
{
    private $service;

    public function __construct(string $id, $module, SlidersManageService $service, array $config = [])
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

    public function actionForm($number)
    {
        if(\Yii::$app->request->isAjax) {
            return $this->renderPartial('_form', [
                'model' => new SlidersForm(),
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
     * @return Sliders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sliders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('posts', 'The requested page does not exist.'));
    }

    protected function picturesDeleted($pictures)
    {
        if(!empty($pictures)) {
            foreach ($pictures as $picture) {
                // удаляем файл
                $dir = \Yii::getAlias('@images') . '/posts/';
                if(file_exists($dir . $picture->name)) {
                    unlink($dir . $picture->name);
                }

                $picture->delete();
            }
        }
    }
}