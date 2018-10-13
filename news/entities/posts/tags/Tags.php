<?php

namespace news\entities\posts\tags;


use yii\db\ActiveRecord;

/**
 * Class Tags
 * @package news\entities\posts\tags
 *
 * @property string $name
 * @property int $id
 */
class Tags extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%tags}}';
    }

    public static function create(string $name): self
    {
        $tag = new static();

        $tag->name = $name;

        return $tag;
    }

    public function edit(string $name): void
    {
        $this->name = $name;
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'name' => \Yii::t('app', 'Name'),
        ];
    }
}