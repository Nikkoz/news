<?php

namespace news\entities\posts\rubric;

use Yii;
use news\entities\behaviors\MetaBihavior;
use news\entities\Meta;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%rubrics}}".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $color
 * @property string $meta_json
 * @property int $sort
 * @property Meta $meta
 */
class Rubrics extends ActiveRecord
{
    public $meta;

    public static function tableName()
    {
        return '{{%rubrics}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => MetaBihavior::class,
                'jsonAttribute' => 'meta_json'
            ], [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'slugAttribute' => 'slug'
            ]
        ];
    }

    public static function create(string $name, string $color, int $sort, Meta $meta): self
    {
        $rubric = new static();

        $rubric->name = $name;
        //$rubric->slug = $slug;
        $rubric->color = $color;
        $rubric->sort = $sort;
        $rubric->meta = $meta;

        return $rubric;
    }

    public function edit(string $name, string $color, int $sort, Meta $meta): void
    {
        $this->name = $name;
        //$this->slug = $slug;
        $this->color = $color;
        $this->sort = $sort;
        $this->meta = $meta;
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('rubrics', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'color' => Yii::t('app', 'Color'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }
}