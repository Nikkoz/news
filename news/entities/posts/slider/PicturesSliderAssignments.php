<?php
namespace news\entities\posts\slider;

use news\entities\Pictures;
use yii\db\ActiveRecord;

/**
 * Class PicturesAssignments
 * @package news\entities\posts\slider
 *
 * @property integer $slider_id
 * @property integer $picture_id
 */
class PicturesSliderAssignments extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%sliders_pictures_assignments}}';
    }

    /*public function rules(): array
    {
        return [
            [['slider_id', 'picture_id'], 'required'],
            [['slider_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sliders::class, 'targetAttribute' => ['slider_id' => 'id']],
            [['picture_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pictures::class, 'targetAttribute' => ['picture_id' => 'id']],
        ];
    }*/

    public static function create($pictureId): self
    {
        $assignment = new static();
        $assignment->picture_id = $pictureId;

        return $assignment;
    }

    public function isForPicture($id): bool
    {
        return $this->picture_id == $id;
    }

    public function getImage()
    {
        return Pictures::findOne($this->picture_id);
    }
}