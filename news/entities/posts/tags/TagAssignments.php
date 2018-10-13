<?php

namespace news\entities\posts\tags;


use yii\db\ActiveRecord;

/**
 * Class TagsAssignments
 * @package news\entities\posts\tags
 *
 * @property int $news_id
 * @property int $tag_id
 */
class TagAssignments extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%news_tags_assignments}}';
    }

    public static function create(int $tagId): self
    {
        $assignment = new static();
        $assignment->tag_id = $tagId;

        return $assignment;
    }

    public function isForTag(int $id): bool
    {
        return $this->tag_id == $id;
    }
}