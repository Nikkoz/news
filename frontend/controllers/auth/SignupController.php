<?php

namespace frontend\controllers\auth;

use common\auth\Identity;
use news\forms\auth\SignupForm;
use news\services\auth\SignupService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class SignupController extends Controller
{
    private $service;
    private $users;

    public function __construct(string $id, $module, SignupService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = $service;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['request'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionRequest()
    {
        $form = new SignupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->service->signup($form);

                if (Yii::$app->getUser()->login(new Identity($user))) {
                    return $this->goHome();
                }
            } catch (\RuntimeException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('signup', [
            'model' => $form,
        ]);
    }

    /*public function actionConfirm($token)
    {
        try{
            $this->service->confirm($token);
            Yii::$app->session->setFlash('success', 'Your email is confirmed.');
            return $this->redirect(['auth/auth/login']);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error',$e->getMessage());
        }

        return $this->goHome();
    }*/
}