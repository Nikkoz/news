<?php

namespace news\helpers;


use news\entities\posts\News;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class NewsHelper
{
    public static function statusList(): array
    {
        return [
            News::STATUS_DRAFT => \Yii::t('app', 'Draft'),
            News::STATUS_ACTIVE => \Yii::t('app', 'Active')
        ];
    }

    public static function statusName(int $status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel(int $status, int $id): string
    {
        switch ($status) {
            case News::STATUS_ACTIVE:
                $class = 'label label-success';
                $action = 'deactivate';
                break;
            case News::STATUS_DRAFT:
            default:
                $class = 'label label-default';
                $action = 'activate';
                break;
        }

        return Html::a(ArrayHelper::getValue(self::statusList(), $status), ["posts/news/{$action}", 'id' => $id, 'backUrl' => \Yii::$app->request->url], ['class' => $class, 'data-publish' => '']);
    }

    public static function attributeLabels(): array
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'title' => \Yii::t('app', 'Title'),
            'preview_text' => \Yii::t('app', 'Preview text'),
            'status' => \Yii::t('app', 'Status'),
            'sort' => \Yii::t('app', 'Sort'),
            'analytics' => \Yii::t('app', 'Analytics'),
            'hot' => \Yii::t('app', 'Hot'),
            'discussing' => \Yii::t('app', 'Discussing'),
            'reading' => \Yii::t('app', 'Reading'),
            'choice' => \Yii::t('app', 'Choice'),
            'analytic' => \Yii::t('app', 'Analytic'),
            'rubrics' => \Yii::t('app', 'Rubrics'),
        ];
    }
}