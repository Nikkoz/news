<?php

namespace news\entities\posts\rubric;

use news\entities\posts\queries\RubricQuery;
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
 * @property boolean $status
 * @property int $sort
 * @property Meta $meta
 */
class Rubrics extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

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

    public static function create(string $name, string $color, int $sort, int $status, Meta $meta): self
    {
        $rubric = new static();

        $rubric->name = $name;
        $rubric->color = $color;
        $rubric->sort = $sort;
        $rubric->status = $status;
        $rubric->meta = $meta;

        return $rubric;
    }

    public function edit(string $name, string $color, int $sort, int $status, Meta $meta): void
    {
        $this->name = $name;
        $this->color = $color;
        $this->sort = $sort;
        $this->status = $status;
        $this->meta = $meta;
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isDraft(): bool
    {
        return $this->status == self::STATUS_INACTIVE;
    }

    public function activate(): void
    {
        if($this->isActive()) {
            throw new \DomainException(\Yii::t('app', 'Rubric is already active.'));
        }

        $this->status = self::STATUS_ACTIVE;
    }

    public function deactivate(): void
    {
        if($this->isDraft()) {
            throw new \DomainException(\Yii::t('app', 'Rubric is already inactive.'));
        }

        $this->status = self::STATUS_INACTIVE;
    }

    public static function find(): RubricQuery
    {
        return new RubricQuery(static::class);
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'color' => Yii::t('app', 'Color'),
            'sort' => Yii::t('app', 'Sort'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}