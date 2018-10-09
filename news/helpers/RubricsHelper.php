<?php

namespace news\helpers;


use news\entities\posts\queries\RubricQuery;
use news\entities\posts\rubric\Rubrics;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class RubricsHelper
{
    public static function statusList(): array
    {
        return [
            Rubrics::STATUS_INACTIVE => \Yii::t('app', 'Inactive'),
            Rubrics::STATUS_ACTIVE => \Yii::t('app', 'Active')
        ];
    }

    public static function statusName(int $status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel(int $status, int $id): string
    {
        switch ($status) {
            case Rubrics::STATUS_ACTIVE:
                $class = 'label label-success';
                $action = 'deactivate';
                break;
            case Rubrics::STATUS_INACTIVE:
            default:
                $class = 'label label-default';
                $action = 'activate';
                break;
        }

        return Html::a(ArrayHelper::getValue(self::statusList(), $status), ["posts/rubrics/{$action}", 'id' => $id, 'backUrl' => \Yii::$app->request->url], ['class' => $class, 'data-publish' => '']);
    }

    public static function rubricList(): array
    {
        return ArrayHelper::map(self::getRubrics()->all(), 'id', 'name');
    }

    public static function rubricsLabels(array $ids): string
    {
        $labels = [];

        $rubrics = self::getRubrics()->indexBy('id')->asArray()->all();

        foreach ($ids as $id) {
            $labels[] = Html::tag('span', Html::encode($rubrics[$id]['name']), [
                'class' => 'label label-color',
                'style' => "background-color: {$rubrics[$id]['color']}",
            ]);
        }

        return \implode(' ', $labels);
    }

    private static function getRubrics(): RubricQuery
    {
        return Rubrics::find()->active();
    }
}