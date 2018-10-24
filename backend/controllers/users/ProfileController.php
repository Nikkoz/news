<?php

namespace backend\controllers\users;


use news\entities\user\User;
use news\forms\manage\users\UserForm;
use news\services\manage\UserManageService;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class ProfileController
 * @package backend\controllers\users
 *
 * @property UserManageService $service
 */
class ProfileController extends Controller
{
    private $service;

    public function __construct(string $id, $module, UserManageService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = $service;
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionIndex(int $id)
    {
        $user = $this->findModel($id);

        $form = new UserForm($user);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($user->id, $form);
                return $this->redirect(Url::toRoute(['users/profile', 'id' => $user->id]));
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('index', [
            'model' => $form,
            'user' => $user,
        ]);
    }

    /**
     * @param int $id
     * @return null|\news\entities\user\User
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): ?User
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}