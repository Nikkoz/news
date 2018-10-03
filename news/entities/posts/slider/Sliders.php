<?php
namespace news\entities\posts\slider;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use common\models\Pictures;

/**
 * This is the model class for table "{{%sliders}}".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 *
 * @property Pictures $pictures
 *
 * @property PicturesSliderAssignments $picturesAssignments
 */
class Sliders extends ActiveRecord
{
    public $pictures;

    public static function tableName(): string
    {
        return '{{%sliders}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'picturesAssignments'
                ]
            ]
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function create(string $name, string $description): self
    {
        $slider = new static();

        $slider->name = $name;
        $slider->description = $description;

        return $slider;
    }

    public function edit(string $name, string $description): void
    {
        $this->name = $name;
        $this->description = $description;
    }

    public function assignPicture($id): void
    {
        $assignments = $this->picturesAssignments;

        foreach ($assignments as $assignment) {
            if($assignment->isForPicture($id)) {
                return;
            }
        }

        $assignments[] = PicturesSliderAssignments::create($id);
        $this->picturesAssignments = $assignments;
    }

    public function revokePicture($id): void
    {
        $assignments = $this->picturesAssignments;

        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForPicture($id)) {
                unset($assignments[$i]);
                $this->picturesAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function getPicturesAssignments(): ActiveQuery
    {
        return $this->hasMany(PicturesSliderAssignments::class, ['slider_id' => 'id']);
    }
}
