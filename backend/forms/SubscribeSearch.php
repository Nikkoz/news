<?php

namespace backend\forms;


use news\entities\Subscribe;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class SubscribeSearch
 * @package backend\forms
 *
 * @property string $email
 */
class SubscribeSearch extends Model
{
    public $email;

    public function rules(): array
    {
        return [
            [['email'], 'safe'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Subscribe::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                //'defaultOrder' => ['created_at' => SORT_DESC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['email' => $this->email]);

        return $dataProvider;
    }
}