<?php

namespace news\entities\posts\slider;

use yii\db\ActiveRecord;


/**
 * Class SliderAssignments
 * @package news\entities\posts\slider
 *
 * @property integer $news_id
 * @property integer $slider_id
 */
class SliderAssignments extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%news_slider_assignments}}';
    }

    /*public function rules(): array
    {
        return [
            [['news_id', 'slider_id'], 'integer'],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::class, 'targetAttribute' => ['news_id' => 'id']],
            [['slider_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sliders::class, 'targetAttribute' => ['slider_id' => 'id']],
        ];
    }*/

    public static function create($sliderId): self
    {
        $assignment = new static();
        $assignment->slider_id = $sliderId;

        return $assignment;
    }

    public function isForSlider($id): bool
    {
        return $this->slider_id == $id;
    }

    public function getSlider(): Sliders
    {
        return Sliders::findOne($this->slider_id);
    }
}