<?php

namespace news\entities\behaviors;


use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\Json;

class JsonBehavior extends Behavior
{
    public $attribute;

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
        $model = $event->sender;

        $model->{$this->attribute} = Json::decode($model->{$this->attribute});
    }

    public function onBeforeSave(Event $event)
    {
        $model = $event->sender;

        $model->setAttribute($this->attribute, Json::encode($model->{$this->attribute}));
    }
}