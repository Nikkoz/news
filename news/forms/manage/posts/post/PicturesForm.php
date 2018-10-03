<?php
namespace news\forms\manage\posts\post;

use news\entities\posts\News;
use phpDocumentor\Reflection\Types\Integer;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class PicturesForm
 * @package news\forms\manage\posts
 *
 * @property $rectanglePictureFile
 * @property $squarePictureFile
 * @property $hotPictureFile
 * @property $analyticPictureFile
 */
class PicturesForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $rectanglePictureFile;
    public $squarePictureFile;
    public $hotPictureFile;
    public $analyticPictureFile;

    public function __construct(News $news = null, array $config = [])
    {
        if($news) {
            $this->rectanglePictureFile = $news->rectanglePictureFile;
            $this->squarePictureFile = $news->squarePictureFile;
            $this->hotPictureFile = $news->hotPictureFile;
            $this->analyticPictureFile = $news->analyticPictureFile;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['rectanglePictureFile', 'squarePictureFile', 'hotPictureFile', 'analyticPictureFile'], 'image'],
        ];
    }

    /**
     * @return bool
     * change to afterValidate
     */
    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->rectanglePictureFile = UploadedFile::getInstance($this, 'rectanglePictureFile');
            $this->squarePictureFile = UploadedFile::getInstance($this, 'squarePictureFile');
            $this->hotPictureFile = UploadedFile::getInstance($this, 'hotPictureFile');
            $this->analyticPictureFile = UploadedFile::getInstance($this, 'analyticPictureFile');

            return true;
        }
        return false;
    }

    public function getId(string $attribute): string
    {
        return $this->{$attribute} ? $this->{$attribute}->id : '';
    }
}