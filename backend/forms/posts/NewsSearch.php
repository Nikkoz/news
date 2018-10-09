<?php

namespace backend\forms\posts;

use news\entities\posts\News;
use news\entities\posts\rubric\RubricAssignments;
use news\entities\posts\rubric\Rubrics;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class NewsSearch
 * @package common\models\posts
 *
 * @property string $title
 * @property int $status
 * @property int $created_at
 * @property int $created_by
 * @property int $sort
 * @property int $analytic
 * @property int $rubrics
 */
class NewsSearch extends Model
{
    public $title;
    public $status;
    public $created_at;
    public $created_by;
    public $analytic;
    public $rubrics;

    public function rules()
    {
        return [
            [['created_at', 'created_by', 'status', 'analytic'], 'integer'],
            [['title', 'rubrics'], 'safe'],
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
        $query = News::find()->alias('news');

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
            'analytic' => $this->analytic,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        if($this->rubrics) {
            $query->rightJoin(RubricAssignments::tableName() . ' rubric', 'rubric.news_id=news.id');
            $query->andFilterWhere(['rubric.rubric_id' => $this->rubrics]);
        }

        return $dataProvider;
    }
}
