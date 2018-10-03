<?php
namespace news\entities\posts\video;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use news\entities\Pictures;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Videos
 * @package news\entities\posts\video
 *
 * @property integer $id
 * @property string $link
 * @property string $name
 * @property string $site
 * @property integer $picture_id
 *
 * @property Pictures $picture
 */
class Videos extends ActiveRecord
{
    private $_picture;

    public static function tableName(): string
    {
        return '{{%videos}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'picture'
                ]
            ]
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function create(string $link, string $name, string $site): self
    {
        $video = new static();

        $video->link = $link;
        $video->name = $name;
        $video->site = $site;

        return $video;
    }

    public function edit(string $link, string $name, string $site): void
    {
        $this->link = $link;
        $this->name = $name;
        $this->site = $site;
    }

    public function setPicture(int $id): void
    {
        $this->picture_id = $id;
    }

    public function revokePicture(): void
    {
        $this->picture_id = '';
    }

    public function getPicture(): ActiveQuery
    {
        return $this->hasOne(Pictures::class, ['id' => 'picture_id']);
    }
}