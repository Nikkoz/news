<?php

namespace news\readModels\posts;


use news\entities\posts\rubric\Rubrics;
use news\entities\posts\rubric\templates\RubricPositions;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class RubricsReadRepository
{
    public function count(): int
    {
        return Rubrics::find()->active()->count();
    }

    public function getAll(): DataProviderInterface
    {
        $query = Rubrics::find()->active();
        return $this->getProvider($query);
    }

    public function getPositions()
    {
        return RubricPositions::find()->with('rubricAssignment', 'templateAssignment')->all();
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