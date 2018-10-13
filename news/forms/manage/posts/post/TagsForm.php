<?php

namespace news\forms\manage\posts\post;


use news\entities\posts\News;
use news\entities\posts\tags\Tags;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class TagsForm
 * @package news\forms\manage\posts\post
 *
 * @property array $tags
 */
class TagsForm extends Model
{
    public $tags;

    public function __construct(News $news = null, array $config = [])
    {
        if($news) {
            $this->tags = ArrayHelper::getColumn((array)$news->tagAssignments, 'tag_id');
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['tags', 'required'],
            ['tags', 'each', 'rule' => ['integer']]
        ];
    }

    public function tagsList(): array
    {
        return ArrayHelper::map(Tags::find()->asArray()->all(), 'id', 'name');
    }

    public function beforeValidate(): bool
    {
        $this->tags = array_filter((array)$this->tags);
        return parent::beforeValidate();
    }

    public function attributeLabels(): array
    {
        return [
            'tags' => \Yii::t('app', 'Tags'),
        ];
    }
}