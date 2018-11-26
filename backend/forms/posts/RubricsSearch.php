<?php

namespace backend\forms\posts;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use news\entities\posts\rubric\Rubrics;

/**
 * RubricsSearch represents the model behind the search form of `common\models\posts\Rubrics`.
 */
class RubricsSearch extends Model
{
    public $name;

    public function rules(): array
    {
        return [
            [['name'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params): ActiveDataProvider
    {
        $query = Rubrics::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['sort' => SORT_ASC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
