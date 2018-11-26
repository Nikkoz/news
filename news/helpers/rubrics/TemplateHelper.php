<?php

namespace news\helpers\rubrics;


use news\entities\posts\rubric\templates\RubricTemplates;
use yii\helpers\ArrayHelper;

final class TemplateHelper
{
    public static function templateList(): array
    {
        return ArrayHelper::map(RubricTemplates::find()->all(), 'id', 'name');
    }
}