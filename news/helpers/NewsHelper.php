<?php

namespace news\helpers;


use news\entities\posts\News;
use news\entities\posts\slider\Sliders;
use news\entities\posts\video\Videos;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

final class NewsHelper
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

    public static function getSlider(int $id): ?Sliders
    {
        return Sliders::find()->andWhere(['=', 'id', $id])->limit(1)->one();
    }

    public static function getTizer(int $id): string
    {
        return News::find()->select('title')->andWhere(['=', 'id', $id])->limit(1)->column()[0];
    }

    public static function getVideo(int $id): ?Videos
    {
        return Videos::find()->andWhere(['=', 'id', $id])->limit(1)->one();
    }

    public static function getTags(News $post): array
    {
        $tags = [];

        foreach ($post->tagAssignments as $tagAssignment) {
            $tags[] = $tagAssignment->tag_id;
        }

        return $tags;
    }

    public static function url(News $news, string $rubric = null): string
    {
        if ($news->analytic) {
            return Url::toRoute(['posts/post/analytic', 'alias' => $news->alias]);
        } else {
            if (!$rubric) {
                $rubric = $news->rubricAssignments[0]->rubric->slug;
            }

            return Url::toRoute(['posts/post/index', 'rubric' => $rubric, 'post' => $news->alias]);
        }
    }

    public static function countByAuthor(int $authorId): int
    {
        return News::find()->active()->andWhere(['=', 'created_by', $authorId])->count();
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
            'news' => \Yii::t('app', 'To news'),
            'discussing' => \Yii::t('app', 'Discussing'),
            'reading' => \Yii::t('app', 'Reading'),
            'choice' => \Yii::t('app', 'Choice'),
            'analytic' => \Yii::t('app', 'Analytic'),
            'rubrics' => \Yii::t('app', 'Rubrics'),
            'created_at' => \Yii::t('app', 'Created at'),
            'color' => \Yii::t('app', 'Background color'),
        ];
    }
}