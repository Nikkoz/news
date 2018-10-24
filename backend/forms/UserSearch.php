<?php

namespace backend\forms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use news\entities\user\User;

/**
 * Class UserSearch
 * @package backend\forms
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property int $status
 * @property string $role
 * @property string $name
 * @property string $lastname
 */
class UserSearch extends Model
{
    public $username;
    public $email;
    public $status;
    public $role;
    public $name;
    public $lastname;

    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['username', 'email', 'role', 'name', 'lastname'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = User::find()->alias('u');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'u.status' => $this->status,
        ]);

        if (!empty($this->role)) {
            $query->innerJoin('{{%auth_assignment}} a', 'a.user_id = u.id');
            $query->andWhere(['a.item_name' => $this->role]);
        }

        $query->andFilterWhere(['like', 'u.username', $this->username])
            ->andFilterWhere(['like', 'u.email', $this->email])
            ->andFilterWhere(['like', 'u.name', $this->name])
            ->andFilterWhere(['like', 'u.lastname', $this->lastname]);

        return $dataProvider;
    }
}
