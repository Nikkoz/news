<?php
namespace news\forms\manage\posts\post;

use news\entities\posts\slider\Sliders;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class SlidersForm
 * @package news\forms\manage\posts\post
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 *
 * @property integer $number
 * @property UploadedFile $pictures
 */
class SlidersForm extends Model
{
    public $id;
    public $name;
    public $description;
    public $pictures;

    private $_slider;
    private $number;

    public function __construct(Sliders $slider = null, int $number = 0, array $config = [])
    {
        if($slider) {
            $this->id = $slider->id;
            $this->name = $slider->name;
            $this->description = $slider->description;

            $this->_slider = $slider;
        }

        $this->number = $number;

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            //[['pictures'], !empty($this->name) ? 'required' : null],
            [['name', 'description'], 'string', 'max' => 255],
            ['pictures', 'each', 'rule' => ['image']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => \Yii::t('sliders', 'ID'),
            'name' => \Yii::t('app', 'Name'),
            'description' => \Yii::t('app', 'Description'),
            'pictures' => \Yii::t('app', 'Pictures'),
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->pictures = UploadedFile::getInstances($this, "[$this->number]pictures");

            return true;
        }
        return false;
    }

    public function getSlider()
    {
        return $this->_slider;
    }
}