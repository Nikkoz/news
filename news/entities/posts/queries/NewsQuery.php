<?php

namespace news\entities\posts\queries;


use news\entities\posts\News;
use news\entities\posts\rubric\RubricAssignments;
use yii\db\ActiveQuery;

class NewsQuery extends ActiveQuery
{
    public function active($alias = null): self
    {
        return $this->andWhere([($alias ? $alias . '.' : '') . 'status' => News::STATUS_ACTIVE]);
    }

    public function news(): self
    {
        return $this->andWhere(['news' => 1]);
    }

    public function analytic(): self
    {
        return $this->active()->andWhere(['analytic' => 1]);
    }

    public function rubric(int $rubricId): self
    {
        return $this->innerJoin(RubricAssignments::tableName(), '`id` = `news_id`')->andWhere(['rubric_id' => $rubricId]);
    }

    public function choice(): self
    {
        return $this->andWhere(['=', 'choice', 1]);
    }
}