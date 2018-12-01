<?php

namespace news\readModels\posts;


use news\entities\posts\rubric\Rubrics;
use news\entities\posts\rubric\templates\RubricPositions;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

class RubricsReadRepository
{
    public function count(): int
    {
        return Rubrics::find()->active()->count();
    }

    public function getByAlias(string $alias): ?Rubrics
    {
        $rubric = Rubrics::find()->andWhere(['=', 'slug', $alias])->limit(1)->one();

        if (!$rubric) {
            throw new NotFoundHttpException('Rubrics is not found.');
        }

        return $rubric;
    }

    public function getAliasById(int $id): string
    {
        return Rubrics::find()->select('slug')->andWhere(['=', 'id', $id])->limit(1)->column()[0];
    }

    public function getAll(): DataProviderInterface
    {
        $query = Rubrics::find()->active();
        return $this->getProvider($query);
    }

    public function getPositions(): array
    {
        return RubricPositions::find()->with('rubricAssignment', 'templateAssignment')->all();
    }

    public function getPosition(int $rubricId): ?RubricPositions
    {
        return RubricPositions::find()->select(['id', 'template_id'])->with('templateAssignment')->andWhere(['=', 'rubric_id', $rubricId])->limit(1)->one();
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['sort' => SORT_ASC],
            ]
        ]);
    }
}