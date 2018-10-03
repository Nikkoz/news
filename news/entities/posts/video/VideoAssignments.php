<?php
namespace news\entities\posts\video;

use yii\db\ActiveRecord;

/**
 * Class VideoAssignments
 * @package news\entities\posts\video
 *
 * @property integer $video_id
 */
class VideoAssignments extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%news_videos_assignments}}';
    }

    public static function create($videoId): self
    {
        $assignment = new static();
        $assignment->video_id = $videoId;

        return $assignment;
    }

    public function isForVideo($id): bool
    {
        return $this->video_id == $id;
    }

    public function getVideo(): Videos
    {
        return Videos::findOne($this->video_id);
    }
}