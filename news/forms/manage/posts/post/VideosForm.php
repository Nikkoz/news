<?php
namespace news\forms\manage\posts\post;

use news\entities\posts\video\Videos;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class VideosForm
 * @package news\forms\manage\posts\post
 *
 * @property string $link
 * @property string $name
 * @property string $site
 *
 * @property integer $number
 *
 * @property UploadedFile $picture
 */
class VideosForm extends Model
{
    public $id;
    public $link;
    public $name;
    public $site;
    public $picture;

    private $_video;
    private $number;

    public function __construct(Videos $video = null, int $number = 0, array $config = [])
    {
        if($video) {
            $this->id = $video->id;
            $this->link = $video->link;
            $this->name = $video->name;
            $this->site = $video->site;

            $this->_video = $video;
        }

        $this->number = $number;

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            //[['picture'], !empty($this->link) ? 'required' : null],
            [['link', 'name', 'site'], 'string', 'max' => 255],
            ['picture', 'image'],
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->picture = UploadedFile::getInstance($this, "[$this->number]picture");

            return true;
        }
        return false;
    }

    public function getVideo()
    {
        return $this->_video;
    }
}