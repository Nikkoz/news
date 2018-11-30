<?php

namespace news\entities;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class Subscribe
 * @package news\entities
 *
 * @property int $id
 * @property string $email
 * @property integer $created_at
 */
class Subscribe extends ActiveRecord
{
    use EventTrait;

    public static function tableName(): string
    {
        return '{{%subscribe}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => false,
                ],
            ]
        ];
    }

    public static function create(string $email): self
    {
        $subscribe = new static();
        $subscribe->email = $email;

        return $subscribe;
    }

    public function edit(string $email): void
    {
        $this->email = $email;
    }
}