<?php

namespace news\entities\posts\rubric\templates;


use yii\db\ActiveRecord;

/**
 * Class rubricTemplates
 * @package news\entities\posts\rubric\templates
 *
 * @property int $id
 * @property string $name
 * @property string $file
 * @property int $count_news
 */
class RubricTemplates extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%rubric_templates}}';
    }

    public static function create(string $name, string $file, int $count_news): self
    {
        $template = new static();

        $template->name = $name;
        $template->file = $file;
        $template->count_news = $count_news;

        return $template;
    }

    public function edit(string $name, string $file, int $count_news): void
    {
        $this->name = $name;
        $this->file = $file;
        $this->count_news = $count_news;
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'name' => \Yii::t('app', 'Name'),
            'file' => \Yii::t('app', 'File'),
            'count_news' => \Yii::t('app', 'News count'),
        ];
    }
}