<?php

namespace backend\forms\posts;

use news\entities\posts\News;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class NewsSearch
 * @package common\models\posts
 */
class NewsSearch extends Model
{
    public $title;
    public $publish;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $sort;
    public $is_analytic;

    public function rules()
    {
        return [
            [['sort', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['title', 'is_analytic', 'publish'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = News::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['updated_at' => SORT_DESC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'sort' => $this->sort,
            'is_analytic' => $this->is_analytic,
            'publish' => $this->publish,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
