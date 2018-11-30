<?php

namespace news\readModels\posts;


use news\entities\posts\News;
use news\entities\posts\rubric\RubricAssignments;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

class NewsReadRepository
{
    public function getHotPost(): ?ActiveRecord
    {
        return News::find()->active()->with('rubricAssignments', 'hotPictureFile')->where(['=', 'hot', 1])->limit(1)->orderBy(['updated_at' => SORT_DESC])->one();
    }

    public function getPostsInNews(array $conditions, int $limit): array
    {
        return News::find()->active()->news()->with('rubricAssignments')->andWhere($conditions)->orderBy(['created_at' => SORT_DESC])->limit($limit)->all();
    }

    public function getAnalyticByRubric(int $rubricId): ?ActiveRecord
    {
        return News::find()->analytic()->with('rectanglePictureFile')->rubric($rubricId)->orderBy(['created_at' => SORT_DESC])->limit(1)->one();
    }

    public function getNewsByRubric(int $rubricId, int $limit): array
    {
        return News::find()->active()->with('rectanglePictureFile')->rubric($rubricId)->andWhere(['analytic' => 0])->limit($limit)->orderBy(['created_at' => SORT_DESC])->all();
    }

    public function lastNews(int $limit): array
    {
        return News::find()->active()->with('rubricAssignments', 'squarePictureFile')->limit($limit)->orderBy(['created_at' => SORT_DESC])->all();
    }

    public function getByAlias(string $alias): ?News
    {
        $news = News::find()->active()->andWhere(['=', 'alias', $alias])->limit(1)->one();

        if(!$news) {
            throw new NotFoundHttpException('Article is not found.');
        }

        return $news;
    }

    public function getNewsBy(int $limit, array $conditions): array
    {
        return News::find()->active()->andWhere($conditions)->limit($limit)->orderBy(['created_at' => SORT_DESC])->all();
    }
}