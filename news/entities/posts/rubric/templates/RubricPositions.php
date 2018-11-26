<?php

namespace news\entities\posts\rubric\templates;


use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use news\entities\posts\rubric\Rubrics;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class RubricPositions
 * @package news\entities\posts\rubric\templates
 *
 * @property int $id
 * @property int $rubric_id
 * @property int $template_id
 * @property int $position
 *
 * @property Rubrics $rubricAssignment
 * @property RubricTemplates $templateAssignment
 */
class RubricPositions extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%rubric_positions}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'rubricAssignment', 'templateAssignment'
                ]
            ]
        ];
    }

    public static function create(int $pos, int $rubric, int $template): self
    {
        $position = new static();

        $position->position = $pos;
        $position->rubric_id = $rubric;
        $position->template_id = $template;

        return $position;
    }

    public function edit(int $pos, int $rubric, int $template): void
    {
        $this->position = $pos;
        $this->rubric_id = $rubric;
        $this->template_id = $template;
    }

    // assignments

    public function getRubricAssignment(): ActiveQuery
    {
        return $this->hasOne(Rubrics::class, ['id' => 'rubric_id']);
    }

    public function getTemplateAssignment(): ActiveQuery
    {
        return $this->hasOne(RubricTemplates::class, ['id' => 'template_id']);
    }
}