<?php

namespace news\readModels\posts;


use news\entities\posts\tags\Tags;

class TagsReadRepository
{
    public function count(): int
    {
        return Tags::find()->count();
    }

    public function getIdByTag(string $tag): int
    {
        return Tags::find()->select('id' )->andWhere(['=','name', $tag])->limit(1)->column()[0];
    }
}