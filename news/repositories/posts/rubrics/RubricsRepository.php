<?php

namespace news\repositories\posts\rubrics;


use news\entities\posts\rubric\Rubrics;

class RubricsRepository
{
    public function get(int $id): Rubrics
    {
        if (!$rubric = Rubrics::findOne($id)) {
            throw new \DomainException('Rubrics is not found.');
        }

        return $rubric;
    }

    public function save(Rubrics $rubric): void
    {
        if (!$rubric->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Rubrics $rubric): void
    {
        if (!$rubric->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}