<?php

namespace news\repositories\posts\rubrics;


use news\entities\posts\rubric\templates\RubricTemplates;

class RubricTemplateRepository
{
    public function get(int $id): RubricTemplates
    {
        if (!$rubric = RubricTemplates::findOne($id)) {
            throw new \DomainException('Rubrics is not found.');
        }

        return $rubric;
    }

    public function save(RubricTemplates $rubric): void
    {
        if (!$rubric->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(RubricTemplates $rubric): void
    {
        if (!$rubric->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}