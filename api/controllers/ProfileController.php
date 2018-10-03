<?php

namespace api\controllers;


use filsh\yii2\oauth2server\filters\ErrorToExceptionFilter;
use news\entities\User;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;

class ProfileController extends Controller
{
    public function actionIndex()
    {
        \Yii::$app->request->enableCsrfCookie;
        return $this->serializeUser($this->findModel());
    }

    public function verbs(): array
    {
        return [
            'index' => ['GET'],
        ];
    }

    private function findModel(): User
    {
        return User::findOne(\Yii::$app->user->id);
    }

    private function serializeUser(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->username,
            'email' => $user->email,
        ];
    }
}