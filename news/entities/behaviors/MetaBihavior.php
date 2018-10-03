<?php

namespace news\entities\behaviors;

use news\entities\Meta;
use news\entities\posts\rubric\Rubrics;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\Json;

class MetaBihavior extends Behavior
{
    public $attribute = 'meta';
    public $jsonAttribute = 'json_meta';

    public function events(): array
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'onAfterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'onBeforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'onBeforeSave',
        ];
    }

    public function onAfterFind(Event $event)
    {
        /** @var Rubrics $rubrics */
        $rubrics = $event->sender;

        $meta = Json::decode($rubrics->getAttribute($this->jsonAttribute));

        $rubrics->{$this->attribute} = new Meta($meta['title'], $meta['description'], $meta['keywords']);
    }

    public function onBeforeSave(Event $event)
    {
        /** @var \news\entities\posts\rubric\Rubrics $rubrics */
        $rubrics = $event->sender;

        $rubrics->setAttribute($this->jsonAttribute, Json::encode([
            'title' => $rubrics->{$this->attribute}->title,
            'description' => $rubrics->{$this->attribute}->description,
            'keywords' => $rubrics->{$this->attribute}->keywords,
        ]));
    }
}