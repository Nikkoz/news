<?php

namespace news\entities\posts\queries;


use yii\db\ActiveQuery;

class RubricQuery extends ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['status' => 1]);
    }
}