<?php

namespace news\repositories\posts;


use news\entities\posts\tags\Tags;

class TagsRepository
{
    public function get(int $id): Tags
    {
        if (!$tag = Tags::findOne($id)) {
            throw new \DomainException('Tag is not found.');
        }

        return $tag;
    }

    public function save(Tags $tag): void
    {
        if (!$tag->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Tags $tag): void
    {
        if (!$tag->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}