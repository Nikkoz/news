<?php

namespace news\forms\manage\posts;


use news\entities\posts\tags\Tags;
use yii\base\Model;

/**
 * Class TagForm
 * @package news\forms\manage\posts
 *
 * @property string $name
 */
class TagForm extends Model
{
    public $name;

    public function __construct(Tags $tag = null, array $config = [])
    {
        if($tag) {
            $this->name = $tag->name;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['name', 'required'],
            ['name', 'string']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => \Yii::t('app', 'Name')
        ];
    }
}