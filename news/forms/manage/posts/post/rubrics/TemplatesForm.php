<?php

namespace news\forms\manage\posts\post\rubrics;


use news\entities\posts\rubric\templates\RubricTemplates;
use yii\base\Model;

/**
 * Class RubricTemplatesForm
 * @package news\forms\manage\posts\post\rubrics
 *
 * @property string $name
 * @property string $file
 * @property int $count_news
 */
class TemplatesForm extends Model
{
    public $name;
    public $file;
    public $count_news;

    public function __construct(RubricTemplates $template = null, array $config = [])
    {
        if ($template) {
            $this->name = $template->name;
            $this->file = $template->file;
            $this->count_news = $template->count_news;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'file', 'count_news'], 'required'],
            [['name', 'file'], 'string', 'max' => 255],
            ['count_news', 'integer']
        ];
    }
}