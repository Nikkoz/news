<?php
namespace news\forms\manage\posts\post;

use news\entities\posts\News;
use news\forms\manage\CompositeForm;
use news\forms\manage\MetaForm;

/**
 * Class NewsCreateForm
 * @package news\forms\manage\posts
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property integer $sort
 * @property boolean $analytics
 * @property boolean $hot
 * @property boolean $discussing
 * @property boolean $reading
 * @property boolean $choice
 * @property integer $status
 * @property string $preview_text
 * @property array $detail_text
 *
 * @property MetaForm $meta
 * @property RubricsForm $rubrics
 * @property PicturesForm $pictures
 * @property SlidersForm $sliders
 * @property VideosForm $videos
 */
class NewsCreateForm extends CompositeForm
{
    public $title;
    public $alias;
    public $sort;
    public $analytics;
    public $hot;
    public $discussing;
    public $reading;
    public $choice;
    public $status;
    public $preview_text;
    public $detail_text;

    public function __construct(array $config = [])
    {
        $this->meta = new MetaForm();
        $this->pictures = new PicturesForm();
        $this->rubrics = new RubricsForm();
        $this->sliders = [new SlidersForm()];
        $this->videos = [new VideosForm()];

        parent::__construct($config);
    }

    public function setSliders(int $count): array
    {
        $sliders = [];

        for($i = 0; $i < $count; $i++) {
            $sliders[] = new SlidersForm(null, $i);
        }

        return $sliders;
    }

    public function setVideos(int $count): array
    {
        $videos = [];

        for($i = 0; $i < $count; $i++) {
            $videos[] = new VideosForm(null, $i);
        }

        return $videos;
    }

    public function rules()
    {
        return [
            [['title', 'detail_text'],'required'],
            [['title', 'alias'], 'string', 'max' => 255],
            [['preview_text'], 'string'],
            //[['alias'], 'unique', 'targetClass' => News::class],
            ['sort', 'integer'],
            ['detail_text', 'safe'],
            [['sort'], 'default', 'value' => 100],
            [['analytics', 'hot', 'discussing', 'reading', 'choice', 'status'], 'integer', 'max' => 1],
        ];
    }

    protected function internalForms(): array
    {
        return ['pictures', 'sliders', 'videos', 'meta', 'rubrics'];
    }
}