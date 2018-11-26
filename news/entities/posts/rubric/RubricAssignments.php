<?php

namespace news\entities\posts\rubric;

use common\models\posts\News;
use news\entities\posts\rubric\Rubrics;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%news_rubrics}}".
 *
 * @property int $news_id
 * @property int $rubric_id
 *
 * @property Rubrics $rubric
 */
class RubricAssignments extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%news_rubrics_assignments}}';
    }

    /*public function rules(): array
    {
        return [
            [['news_id', 'rubric_id'], 'integer'],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::class, 'targetAttribute' => ['news_id' => 'id']],
            [['rubric_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rubrics::class, 'targetAttribute' => ['rubric_id' => 'id']],
        ];
    }*/

    public static function create($rubricId): self
    {
        $assignment = new static();
        $assignment->rubric_id = $rubricId;

        return $assignment;
    }

    public function isForRubric($id): bool
    {
        return $this->rubric_id == $id;
    }

    public function getRubric(): Rubrics
    {
        return Rubrics::findOne($this->rubric_id);
    }
}
