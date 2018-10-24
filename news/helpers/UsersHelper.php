<?php

namespace news\helpers;


use news\entities\user\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class UsersHelper
{
    public static function getRole(int $userId): string
    {
        return \implode(', ', ArrayHelper::map(\Yii::$app->authManager->getRolesByUser($userId), 'name', 'description'));
    }

    public static function getRoleList(): array
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }

    public static function statusList(): array
    {
        return [
            User::STATUS_ACTIVE => \Yii::t('app', 'Active'),
            User::STATUS_INACTIVE => \Yii::t('app', 'Inactive'),
        ];
    }

    public static function statusLabel(int $status, int $id): string
    {
        switch ($status) {
            case User::STATUS_ACTIVE:
                $class = 'label label-success';
                $action = 'deactivate';
                break;
            case User::STATUS_INACTIVE:
            default:
                $class = 'label label-default';
                $action = 'activate';
                break;
        }

        return Html::a(ArrayHelper::getValue(self::statusList(), $status), ["users/users/{$action}", 'id' => $id, 'backUrl' => \Yii::$app->request->url], ['class' => $class, 'data-publish' => '']);
    }

    public static function statusLabelNotChange(int $status): string
    {
        switch ($status) {
            case User::STATUS_ACTIVE:
                $class = 'label label-success';
                break;
            case User::STATUS_INACTIVE:
            default:
                $class = 'label label-default';
                break;
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), ['class' => $class]);
    }

    public static function attributeLabels(): array
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'username' => \Yii::t('app', 'Login'),
            'name' => \Yii::t('app', 'Name user'),
            'lastname' => \Yii::t('app', 'Last name'),
            'email' => \Yii::t('app', 'E-mail'),
            'role' => \Yii::t('app', 'Role'),
            'status' => \Yii::t('app', 'Status'),
            'last_auth' => \Yii::t('app', 'Last auth'),
            'password' => \Yii::t('app', 'Password'),
            'password_confirm' => \Yii::t('app', 'Password confirm'),
        ];
    }
}