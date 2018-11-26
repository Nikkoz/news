<?php

namespace news\forms\manage\posts\post\rubrics;


use news\entities\posts\rubric\Rubrics;
use news\entities\posts\rubric\templates\RubricPositions;
use news\entities\posts\rubric\templates\RubricTemplates;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class PositionForm
 * @package news\forms\manage\posts\post\rubrics
 *
 * @property int $position
 * @property int $rubric
 * @property int $template
 *
 * @property RubricTemplates $templates
 * @property Rubrics $rubrics
 */
class PositionForm extends Model
{
    public $rubric;
    public $template;
    public $position;

    public function __construct(RubricPositions $position = null, array $config = [])
    {
        if ($position) {
            $this->position = $position->position;
            $this->rubric = $position->rubric_id;
            $this->template = $position->template_id;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['rubric', 'template', 'position'], 'required'],
            [['rubric', 'template', 'position'], 'integer']
        ];
    }

    public function getTemplates(): array
    {
        return ArrayHelper::map(RubricTemplates::find()->asArray()->all(), 'id', 'name');
    }

    public function getRubrics(): array
    {
        return ArrayHelper::map(Rubrics::find()->active()->asArray()->all(), 'id', 'name');
    }
}