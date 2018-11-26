<?php

namespace backend\forms\posts;


use news\entities\posts\rubric\templates\RubricPositions;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class RubricPositionSearch
 * @package backend\forms\posts
 *
 * @property int $rubric_id
 * @property int $template_id
 */
class RubricPositionSearch extends Model
{
    public $rubric_id;
    public $template_id;

    public function rules(): array
    {
        return [
            [['rubric_id', 'template_id'], 'safe'],
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
        $query = RubricPositions::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['position' => SORT_ASC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'rubric_id' => $this->rubric_id,
            'template_id' => $this->template_id
        ]);

        return $dataProvider;
    }
}