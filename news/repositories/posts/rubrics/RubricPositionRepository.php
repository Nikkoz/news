<?php

namespace news\repositories\posts\rubrics;


use news\entities\posts\rubric\templates\RubricPositions;

class RubricPositionRepository
{
    public function get(int $id): RubricPositions
    {
        if (!$rubric = RubricPositions::findOne($id)) {
            throw new \DomainException('Rubric position is not found.');
        }

        return $rubric;
    }

    public function save(RubricPositions $rubric): void
    {
        if (!$rubric->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(RubricPositions $rubric): void
    {
        if (!$rubric->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}