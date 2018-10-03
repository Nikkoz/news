<?php

namespace news\forms\manage;

use Yii;
use news\entities\Meta;
use yii\base\Model;

class MetaForm extends Model
{
    public $title;
    public $keywords;
    public $description;

    public function __construct(Meta $meta = null, array $config = [])
    {
        if($meta) {
            $this->title = $meta->title;
            $this->keywords = $meta->keywords;
            $this->description = $meta->description;

        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['title', 'string', 'max' => 255],
            [['keywords', 'description'], 'string']
        ];
    }



    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', 'TitleMeta'),
            'description' => Yii::t('app', 'DescriptionMeta'),
            'keywords' => Yii::t('app', 'KeywordsMeta'),
        ];
    }
}