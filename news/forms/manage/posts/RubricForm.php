<?php

namespace news\forms\manage\posts;

use news\forms\manage\CompositeForm;
use news\forms\manage\MetaForm;
use news\validators\SlugValidator;
use Yii;
use news\entities\posts\rubric\Rubrics;

/**
 * Class RubricsForm
 * @package news\forms\manage\posts
 *
 * @property string $name
 * @property string $slug
 * @property string $color
 * @property integer $sort
 *
 * @property MetaForm $meta
 */
class RubricForm extends CompositeForm
{
    public $name;
    public $slug;
    public $color;
    public $sort;

    private $_rubric;

    public function __construct(Rubrics $rubric = null, array $config = [])
    {
        if($rubric) {
            $this->name = $rubric->name;
            $this->slug = $rubric->slug;
            $this->color = $rubric->color;
            $this->sort = $rubric->sort;

            $this->meta = new MetaForm($rubric->meta);

            $this->_rubric = $rubric;
        } else {
            $this->sort = 100;
            $this->meta = new MetaForm();
        }

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['sort'], 'integer'],
            [['sort'], 'default', 'value' => 100],
            [['name', 'color','slug'], 'string', 'max' => 255],
            ['slug', SlugValidator::class],
            [['name','slug'], 'unique', 'targetClass' => Rubrics::class, 'filter' => $this->_rubric ? ['<>', 'id', $this->_rubric->id] : null],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('rubrics', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'color' => Yii::t('app', 'Color'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }

    public function internalForms(): array
    {
        return ['meta'];
    }
}