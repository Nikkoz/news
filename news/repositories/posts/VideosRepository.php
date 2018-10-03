<?php
namespace news\repositories\posts;

use news\entities\posts\video\Videos;

class VideosRepository
{
    public function get($id): Videos
    {
        if(!$video = Videos::findOne($id)) {
            throw new \DomainException('Video is not found.');
        }

        return $video;
    }

    public function save(Videos $video): void
    {
        if(!$video->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Videos $video): void
    {
        if(!$video->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}