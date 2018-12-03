<?php

namespace news\readModels\posts;


use news\entities\posts\News;
use news\entities\posts\rubric\RubricAssignments;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

class NewsReadRepository
{
    public function count(): int
    {
        return News::find()->active()->count();
    }

    public function getHotPost(): ?ActiveRecord
    {
        return News::find()->active()->with('rubricAssignments', 'hotPictureFile')->where(['=', 'hot', 1])->limit(1)->orderBy(['updated_at' => SORT_DESC])->one();
    }

    public function countInRubric(int $rubricId): int
    {
        return News::find()->active()->rubric($rubricId)->count();
    }

    public function getPostsInNews(array $conditions, int $limit): array
    {
        return News::find()->active()->news()->with('rubricAssignments')->andWhere($conditions)->orderBy(['created_at' => SORT_DESC])->limit($limit)->all();
    }

    public function getAnalyticByRubric(int $rubricId): ?ActiveRecord
    {
        return News::find()->analytic()->with('rectanglePictureFile')->rubric($rubricId)->orderBy(['created_at' => SORT_DESC])->limit(1)->one();
    }

    public function getByRubric(int $rubricId, int $limit): array
    {
        return News::find()->active()->with('rectanglePictureFile')->rubric($rubricId)->andWhere(['analytic' => 0])->limit($limit)->orderBy(['created_at' => SORT_DESC])->all();
    }

    /**
     * @param int $rubricId
     * @param int $limit
     * @param int|null $offset
     * @return array|ActiveDataProvider|ActiveRecord[]
     */
    public function getAllByRubric(int $rubricId, int $limit, int $offset = null)
    {
        $query = News::find()->alias('n')->active('n')
                             ->with('rectanglePictureFile', 'squarePictureFile', 'tagAssignments')
                             ->rubric($rubricId);

        if ($offset) {
            return $query->offset($offset)->limit($limit)->orderBy(['created_at' => SORT_DESC])->all();
        }

        return $this->getProvider($query, $limit, $offset ? true : false);
    }

    public function getAll(int $limit, int $offset = null)
    {
        $query = News::find()->alias('n')->active('n')
                             ->with('rectanglePictureFile', 'squarePictureFile', 'tagAssignments');

        if ($offset) {
            return $query->offset($offset)->limit($limit)->orderBy(['created_at' => SORT_DESC])->all();
        }

        return $this->getProvider($query, $limit, $offset ? true : false);
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

    private function getProvider(ActiveQuery $query, $limit = null, $pagination = false): ActiveDataProvider
    {
        $limit = $limit ?: 15;

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC],
                'attributes' => [
                    'created_at' => [
                        'asc' => ['n.created_at' => SORT_ASC],
                        'desc' => ['n.created_at' => SORT_DESC],
                    ],
                ],
            ],
            'pagination' => !$pagination ? [
                'pageSize' => $limit,
                'pageSizeLimit' => [$limit, 100],
            ] : false,
        ]);
    }
}