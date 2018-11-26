<?php

namespace backend\forms\posts;


use news\entities\posts\rubric\templates\RubricTemplates;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class RubricTemplatesSearch
 * @package backend\forms\posts
 *
 * @property string $name
 */
class RubricTemplatesSearch extends Model
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
        $query = RubricTemplates::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}